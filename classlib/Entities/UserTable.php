<?php

class UserTable extends TableEntity {
    //METHOD: Construct

    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection) {
        parent::__construct($databaseConnection, 'user');
    }

    //END METHOD: Construct
    //METHOD: 

    /**
     * Returns a true login validation if email and password match database record
     * 
     * @param type $email
     * @param type $password
     * @param type $encryptPW
     * @return boolean
     */
    public function validate_login($email, $password, $encryptPW) {


        if ($encryptPW) {//encrypt the password
            $password = hash('ripemd160', $password);
        }

        $sql = "SELECT first_name,last_name FROM user WHERE email='$email' AND password='$password'";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            } //only one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: 
    //METHOD: getFullRecordByID($user_ID)

    /**
     * Returns a record (first_name, last_name, email, mobile_nr, join_date from user table) 
     * 
     * @param type $user_ID
     * @return boolean
     */
    public function getFullRecordByID($user_ID) {
        $sql = "SELECT first_name,last_name,email,mobile_nr,join_date FROM user WHERE User_ID ='$user_ID';";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            }//only one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getRecordByID($user_ID)
    //METHOD: getRecordByID($user_ID)

    /**
     * Returns a record (FirstName and LastName only by user_ID
     * 
     * 
     * @param type $user_ID
     * @return boolean
     */
    public function getRecordByEmail($email) {
        $sql = "SELECT User_ID,first_name,last_name FROM user WHERE email ='$email';";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            }//only one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getRecordByID($userID
    //METHOD:    getAllRecords() 

    /**
     * Performs a SELECT query to returns all records from the table. 
     * ID,Firstname and Lastname columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getAllRecords() {
        $sql = 'SELECT User_ID,first_name,last_name FROM user';
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows > 0) {
                return $rs;
            } else {
                return false;
            }//at least one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: getAllRecords()
    //METHOD: deleteRecordbyID($user_ID)

    /**
     * Performs a DELETE query for a single record ($user_ID).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $user_ID  String containing ID of user record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($user_ID) {

        if ($this->getRecordByID($user_ID)) { //confirm the record exists before deletig
            $sql = "DELETE FROM user WHERE User_ID='$user_ID'";
            if ($this->db->query($sql)) {
                return true;
            } else {
                return false;
            } //try to delete the record
        } else {
            return false; //record doesnt exist
        }
    }

    //END METHOD: deleteRecordbyID($admin_ID) 
    //METHOD:    addRecord($postArray,$encryptPW)

    /**
     * Add User to user table using form post array
     * 
     * @param type $postArray
     * @param type $encryptPW
     * @return boolean
     */
    public function addRecord($postArray, $encryptPW) {

        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);

        //add escape to special characters
        $firstname = addslashes($firstname);
        $lastname = addslashes($lastname);
        $email = addslashes($email);
        $mobnumber = addslashes($mobnumber);
        $password = addslashes($password);
        $joindate = date("Y-m-d");

        //check is password encryption is required
        if ($encryptPW) {//encrypt the password
            $password = hash('ripemd160', $password);
        }

        //construct the INSERT SQL
        $sql = "INSERT INTO user(first_name, last_name, email, mobile_nr, password, join_date) VALUES('$firstname', '$lastname', 
        '$email', '$mobnumber','$password', '$joindate')";
        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: addRecord($postArray,$encryptPW)
    //METHOD:    updateRecord($postArray)

    /**
     * Updates an existing record by ID. Does not change password.  
     * 
     * @param array $postArray containing data to be inserted
     * $postArray['ID'] string StudentID
     * $postArray['firstName'] string FirstName
     * $postArray['lastName'] string LastName
     * $postArray['mobile'] string mobile
     * 
     * @return boolean
     * 
     * 
     */
    public function updateRecord($postArray) {

        //get the values entered in the registration form contained in the $postArray argument      
        extract($postArray);

        //add escape to special characters
        $firstName = addslashes($firstName);
        $lastName = addslashes($lastName);
        $email = addslashes($email);
        $mobile = addslashes($mobile);

        //construct the INSERT SQL                    
        $sql = "UPDATE admin SET FirstName='$firstName',LastName='$lastName',email='$email',mobile='$mobile' WHERE ID='$ID'";

        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: addRecord($postArray,$encryptPW)
    //METHOD:    getAttendingEvents($user_ID)

    /**
     * Returns all events user is attending 
     * 
     * @param type $user_ID
     * @return boolean
     */
    public function getAttendingEvents($user_ID) {

        $sql = "SELECT
                event.event_ID ID,
		event.event_name Name,
		DATE_FORMAT(event.event_date, '%d/%m/%Y') Date
	FROM
		event,
		sportlookup slu,
        attendee
	WHERE
		slu.sport_nr = event.sport
		AND 
		User_ID = '$user_ID'
                AND
                attendee.event_ID = event.event_ID
                AND
                event.status = '1';";
        if ($rs = $this->db->query($sql)) {
            return $rs;
        } else {
            return false;
        }
    }

    //END METHOD: addRecord($postArray,$encryptPW)
    //METHOD:    updateMobile($mobile, $userID)

    /**
     * Updates an existing mobile number by ID.
     * 
     * @param type $postArray
     * @return boolean
     */
    public function updateMobile($mobile, $userID) {

        //construct the INSERT SQL                    
        $sql = "UPDATE user SET mobile_nr='$mobile' WHERE User_ID='$userID'";

        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: updateRecord($mobile, $userID)
    //METHOD:    verifyPW($password, $userID)
    public function verifyPW($password, $userID) {


        $password = hash('ripemd160', $password);


        $sql = "SELECT first_name,last_name FROM user WHERE password='$password' AND User_ID='$userID'";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            } //only one record should be returned
        } else {
            return false;
        }
    }

    //END METHOD: verifyPW($password, $userID)
    //METHOD:    updatePW($postArray)
    public function updatePW($password, $userID) {

        //get the values entered in the registration form contained in the $postArray argument      

        $password = hash('ripemd160', $password);


        //construct the INSERT SQL                    
        $sql = "UPDATE user SET password='$password' WHERE User_ID='$userID'";

        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: updatePW($postArray)
    //METHOD:    sendRegistrationEmail($email)
    public function sendRegistrationEmail($email) {
        
        $subject = "DICE Registration";

        $message = "
                    <html>
                    <head>
                    <title>Registration Complete!</title>
                    </head>
                    <body>
                    <p>Thank you for registering as a user for DICE events</p>
                    <p>Please follow the <a href='http://localhost/dice/index.php?pageID=home'>link</a> to browse and attend events on our website.</p>
                    </body>
                    </html>
                    ";

// Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($email, $subject, $message, $headers);
    }

    //END METHOD: sendRegistrationEmail($email)
}

?>