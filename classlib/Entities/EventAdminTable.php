<?php

class EventAdminTable extends TableEntity {
    //METHOD: Construct

    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection) {
        parent::__construct($databaseConnection, 'event_admin');
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

        $sql = "SELECT first_name,last_name FROM event_admin WHERE email='$email' AND password='$password'";
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
    //METHOD: getFullRecordByID($admin_ID)

    /**
     * Returns a record (first_name, last_name, email, mobile_nr, join_date from event_admin table) 
     * 
     * @param type $admin_ID
     * @return boolean
     */
    public function getFullRecordByID($admin_ID) {
        $sql = "SELECT first_name,last_name,email,mobile_nr,join_date FROM event_admin WHERE admin_ID ='$admin_ID';";
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

    //END METHOD: getRecordByID($admin_ID)
    //METHOD: getRecordByID($admin_ID)

    /**
     * Returns a record (FirstName and LastName only by admin_ID
     * 
     * 
     * @param type $admin_ID
     * @return boolean
     */
    public function getRecordByEmail($email) {
        $sql = "SELECT admin_ID,first_name,last_name FROM event_admin WHERE email ='$email';";
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
        $sql = 'SELECT admin_ID,first_name,last_name FROM event_admin';
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
    //METHOD: deleteRecordbyID($admin_ID)

    /**
     * Performs a DELETE query for a single record ($admin_ID).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $admin_ID  String containing ID of event admin record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($admin_ID) {

        if ($this->getRecordByID($admin_ID)) { //confirm the record exists before deletig
            $sql = "DELETE FROM event_admin WHERE admin_ID='$admin_ID'";
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
     * Add Event Admin to event_admin table using form post array
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
        $sql = "INSERT INTO event_admin(first_name, last_name, email, mobile_nr, password, join_date) VALUES('$firstname', '$lastname', 
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

    //END METHOD: updateRecord($postArray)
    //METHOD:    getAdministratingEvents($admin_ID)

    /**
     * Returns all events administrated by admin_ID
     * 
     * @param type $admin_ID
     * @return boolean
     */
    public function getAdministratingEvents($admin_ID) {

        $sql = "SELECT 
                    event.event_ID ID,
                    event.event_name Name,
                    slu.sport Sport,
                    event.fee Fee,
                    event.event_date Date
                FROM
                    event,
                    sportlookup slu
                WHERE
                    slu.sport_nr = event.sport
                    AND 
                    admin_ID='$admin_ID'
                    AND
                    event.status = '1'
                ;";
        if ($rs = $this->db->query($sql)) {
            return $rs;
        } else {
            return false;
        }
    }
    //END METHOD: getAdministratingEvents($admin_ID)
    
    //METHOD:    getAdministratingEvents($admin_ID)

    /**
     * Returns all events administrated by admin_ID
     * 
     * @param type $admin_ID
     * @return boolean
     */
    public function getRecordByEvent($admin_ID, $eventID) {

        $sql = "SELECT 
                    first_name First, last_name Last
                FROM
                    event_admin,
                    event
                WHERE
                    event_admin.admin_ID = event.admin_ID
                        AND event.event_ID = '$eventID'
                        AND event_admin.admin_ID = '$admin_ID';";
        if ($rs = $this->db->query($sql)) {
            if ($rs->num_rows === 1) {
                return $rs;
            } else {
                return false;
            }
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
        $sql = "UPDATE event_admin SET mobile_nr='$mobile' WHERE admin_ID='$userID'";

        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //END METHOD: updateMobile($mobile, $userID)
    

    //METHOD:    verifyPW($password, $userID)
    public function verifyPW($password, $userID) {


        $password = hash('ripemd160', $password);


        $sql = "SELECT first_name,last_name FROM event_admin WHERE password='$password' AND admin_ID='$userID'";
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
        $sql = "UPDATE event_admin SET password='$password' WHERE admin_ID='$userID'";

        //execute the insert query
        //check the insert query worked
        if ($rs = $this->db->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    //END METHOD: updatePW($postArray)

    
    //METHOD:    getEventsToArchive($admin_ID)

    /**
     * Returns all events administrated by admin_ID
     * 
     * @param type $admin_ID
     * @return boolean
     */
    public function getEventsToArchive($admin_ID) {

        $sql = "SELECT 
                    event_ID ID, 
                    event_date Date
                FROM
                    event
                WHERE
                    CURDATE() > event_date
                    AND
                    admin_ID = '$admin_ID';";
        if ($rs = $this->db->query($sql)) {
            return $rs;
        } else {
            return false;
        }
    }
    //END METHOD: getEventsToArchive($admin_ID)
    
    //METHOD:    sendRegistrationEmail($email)
    public function sendRegistrationEmail($email) {
        
        $subject = "DICE Registration";

        $message = "
                    <html>
                    <head>
                    <title>Registration Complete!</title>
                    </head>
                    <body>
                    <p>Thank you for registering as an event administrator for DICE events</p>
                    <p>Please follow the <a href='http://localhost/dice/index.php?pageID=home'>link</a> to browse and create events on our website.</p>
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
