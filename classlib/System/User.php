<?php
/**
 * Class: User
 * 
 * The user class represents the end user of the application. 
 * 
 * This class is responsible for providing the following functions:
 * 
     * User registration
     * User Login
     * User Logout
     * Persisting user session data by keeping the$_SESSION array up to date
 *
 * 
 */
class User {
    
//CLASS properties
    protected $session;       //Session Class
    protected $db;            //MySQLi object: the database connection ( 
    protected $userID;        //String: containing User ID
    protected $userFirstName; //String: 
    protected $userLastName;  //String: 
    protected $userType;      //String: usertype is either LECTURER or STUDENT
    protected $postArray;     //Array - copy of $_POST array
    protected $chatEnabled;   //boolean: TRUE if AJAX chat is enabled for this session
    protected $loggedin;
    protected $encryptPW; //boolean true if passwords are hash encrypted in DB

//CLASS methods	

    //METHOD: constructor 
    function __construct($session,$database,$encryptPW) {   
        $this->loggedin=$session->getLoggedinState();
        $this->db=$database;
        $this->session=$session;
        //get properties from the session object
        $this->userID=$session->getUserID();
        $this->userFirstName=$session->getUserFirstName();
        $this->userLastName=$session->getUserLastName();
        $this->userType=$session->getUserType();
        $this->chatEnabled=$session->getChatEnabledState();
        $this->encryptPW=$encryptPW;
        $this->postArray=array();
    }
    //END METHOD: constructor 

    //METHOD: login($userID, $password)
    public function login($email, $password) {
        //This login function checks both the user and event admin tables for valid login credentials

        //encrypt the password
        //$password = hash('ripemd160', $password);
        
        //we dont know which type of user is attempting to login
        //need to generate objects to test both
        $eventAdminTable=new EventAdminTable($this->db);
        $userTable= new UserTable($this->db);
 
        if($eventAdminTable->validate_login($email, $password, $this->encryptPW)){  //check if the login details match an ADMIN       
                //query the table for that specific user
                $rs=$eventAdminTable->getRecordByEmail($email);
                $row=$rs->fetch_assoc(); //get the users record from the query result  
                                
                //then set the session array property values
                $this->session->setUserID($row['admin_ID']);
                $this->session->setUserFirstName($row['first_name']);
                $this->session->setUserLastName($row['last_name']);
                $this->session->setUserType('EVENTADMIN'); 
                $this->session->setLoggedinState(TRUE);

                //update the User class properties
                $this->userID=$row['admin_ID'];
                $this->userFirstName=$row['first_name'];
                $this->userLastName=$row['last_name'];
                $this->userType='EVENTADMIN';
                return TRUE;
            }
            else if($userTable->validate_login($email, $password,$this->encryptPW)) { //check if the login details match a MANAGER
                //query the table for that specific user
                $rs=$userTable->getRecordByEmail($email);
                $row=$rs->fetch_assoc(); //get the users record from the query result                 
                
                //then set the session array property values
                $this->session->setUserID($row['User_ID']);
                $this->session->setUserFirstName($row['first_name']);
                $this->session->setUserLastName($row['last_name']);
                $this->session->setUserType('USER'); 
                $this->session->setLoggedinState(TRUE);

                //update the User class properties
                $this->userID=$row['User_ID'];
                $this->userFirstName=$row['first_name'];
                $this->userLastName=$row['last_name'];
                $this->userType='USER';
                return TRUE;                
            }
            else{
                $this->session->setLoggedinState(FALSE);
                $this->loggedin=FALSE;
                return FALSE;
            }
    }
    //END METHOD: login($userID, $password)

    //METHOD: logout()
    public function logout(){
        //
        $this->session->logout();
    }
    //END METHOD: logout()

    //METHOD: register($postArray)
    public function register($postArray,$userType){
        
         //get the values entered in the registration form
        $ID=$this->db->real_escape_string($postArray['ID']);
        $firstName=$this->db->real_escape_string($postArray['firstName']);
        $email=$this->db->real_escape_string($postArray['email']);
        $mobile=$this->db->real_escape_string($postArray['mobile']);
        $lastName=$this->db->real_escape_string($postArray['lastName']);
        $password=$this->db->real_escape_string($postArray['pass1']);
        //encrypt the password
        $password = hash('ripemd160', $password);       
    
        //construct the INSERT SQL
        if ($userType==="LECTURER"){
                    
            $sql="INSERT INTO lecturer (LectID,FirstName,LastName,PassWord,email,mobile) VALUES ('$ID','$firstName','$lastName','$password','$email','$mobile')";
        }
        else{
            $sql="INSERT INTO students (StudentID,FirstName,LastName,PassWord,email,mobile) VALUES ('$ID','$firstName','$lastName','$password','$email','$mobile')";
        }
     
        //$sql="INSERT INTO lecturer (LectID,FirstName,LastName,PassWord) VALUES ('".$postArray['lectID']."','".$postArray['lectFirstName']."','".$postArray['lectLastName']."','".$postArray['lectPass1']."')";
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //END METHOD: register($postArray)

    
    //helper methods
    
    //METHOD: recordEditForm()
    public function recordEditForm(){
        //this helper method generates a record edit FORM as a string
        //the form is populated with the currently logged in user's details for editing
        //the UserID is not editable (read only)
        //this method produces a different form depending on the type of user that is logged in (LECTURER or STUDENT)
        $returnString='';
        if($this->getUserType()==='LECTURER'){ // lecturer is logged in   
        //this method generates a record edit form for a Lecturer
        $sql="SELECT LectID,FirstName,LastName,email,mobile FROM lecturer WHERE LectID='".$this->getUserID()."'";

        if((@$rs=$this->db->query($sql))&&($rs->num_rows===1)){  //execute the query and check it worked and returned data    
                //use the resultset to create the EDIT form
                $row=$rs->fetch_assoc();
                //construct the EDIT ACCOUNT DETAILS form 
                $returnString.='<form method="post" action="index.php?pageID=accountEdit">';
                $returnString.='<div class="form-group">';
                $returnString.='<label for="LecturerID">LecturerID</label><input required readonly type="text" class="form-control" value="'.$row['LectID'].'" id="LecturerID" name="LecturerID"  title="This field cannot be edited">';
                $returnString.='<label for="FirstName">FirstName</label><input required type="text" class="form-control" value="'.$row['FirstName'].'" id="FirstName" name="FirstName" pattern="[a-zA-Z0-9óáéí\' ]{1,45}" title="FirstName (up to 45 Characters)">';
                $returnString.='<label for="LastName">LastName</label><input required type="text" class="form-control" value="'.$row['LastName'].'" id="LastName" name="LastName" pattern="[a-zA-Z0-9óáéí\' ]{1,45}" title="LastName (up to 45 Characters)">';
                $returnString.='<label for="email">email</label><input required type="text" class="form-control" value="'.$row['email'].'" id="email" name="email" pattern="[a-zA-Z0-9óáé@_\.\- ]{1,45}" title="email (up to 45 Characters)">';
                $returnString.='<label for="mobile">mobile</label><input required type="text" class="form-control" value="'.$row['mobile'].'" id="mobile" name="mobile" pattern="[0-9()- ]{1,45}" title="mobile (up to 45 Characters)">';

                $returnString.='</div>';
                $returnString.='<button type="submit" class="btn btn-default" name="btn" value="accountSave">Save Changes</button>';
                $returnString.='</form>'; 
        }
            else{
                $returnString.='Invalid selection - Module may already have been deleted.';
            }
            
        }
        else{ //student is logged in
            $sql="SELECT StudentID,FirstName,LastName,County,email,mobile FROM students WHERE StudentID='".$this->getUserID()."'" ;
            if((@$rs=$this->db->query($sql))&&($rs->num_rows===1)){  //execute the query and check it worked and returned data    
                //use the resultset to create the EDIT form
                $row=$rs->fetch_assoc();
                //construct the EDIT ACCOUNT DETAILS form 
                
                $returnString.='<form method="post" action="index.php?pageID=accountEdit">';
                $returnString.='<div class="form-group">';
                $returnString.='<label for="StudentID">StudentID</label><input required readonly type="text" class="form-control" value="'.$row['StudentID'].'" id="StudentID" name="StudentID"  title="This field cannot be edited">';
                $returnString.='<label for="FirstName">FirstName</label><input required type="text" class="form-control" value="'.$row['FirstName'].'" id="FirstName" name="FirstName" pattern="[a-zA-Z0-9óáéí\' ]{1,45}" title="FirstName (up to 45 Characters)">';
                $returnString.='<label for="LastName">LastName</label><input required type="text" class="form-control" value="'.$row['LastName'].'" id="LastName" name="LastName" pattern="[a-zA-Z0-9óáéí\' ]{1,45}" title="LastName (up to 45 Characters)">';
                $returnString.='<label for="County">County</label><input required type="text" class="form-control" value="'.$row['County'].'" id="County" name="County" pattern="[a-zA-Z0-9óáéí\' ]{1,45}" title="County (up to 45 Characters)">';
                $returnString.='<label for="email">email</label><input required type="text" class="form-control" value="'.$row['email'].'" id="email" name="email" pattern="[a-zA-Z0-9óáé@_\.\- ]{1,45}" title="email (up to 45 Characters)">';
                $returnString.='<label for="mobile">mobile</label><input required type="text" class="form-control" value="'.$row['mobile'].'" id="mobile" name="mobile" pattern="[0-9()- ]{1,45}" title="mobile (up to 45 Characters)">';
                $returnString.='</div>';
                $returnString.='<button type="submit" class="btn btn-default" name="btn" value="accountSave">Save Changes</button>';
                $returnString.='</form>'; 
            }
            else{
                $returnString.='Invalid selection - Module may already have been deleted.';
            }
        }
        return $returnString;
    }
    //END METHOD: recordEditForm()
    
    //METHOD: saveUpdate($sql)
    public function saveUpdate($sql){
        //this method executes the $sql argument and verifies only 1 record/row affected
        if((@$rs=$this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){ 
            return TRUE;
        }
        else{
            return FALSE;
        }        
    }
    //END METHOD: saveUpdate($sql)
    
    //METHOD: verifyPassword($password)
    public function verifyPassword($password){
        //This method verifies a password for a user that is logged in

        //encrypt the password
        $password = hash('ripemd160', $password);
        
        //construct the SQL depending on the user type that is loggged on
        if($this->getUserType()==='LECTURER'){ // lecturer is logged in 
            $sql ="SELECT * FROM lecturer WHERE LectID='$this->userID' AND PassWord='$password'";
        }
        else{ //student is logged in
            $sql="SELECT  * FROM students WHERE StudentID='$this->userID' AND PassWord='$password'";
        }
        
        //execute the query and verify the result
        if( (@$rs=$this->db->query($sql))&&($rs->num_rows===1)){ //only one record should be returned if the password is valid
            return TRUE;  //password is valid for the current user
        }
        else{
            return FALSE; //password is NOT valid for the current user
        }  
        
    }
    //END METHOD: verifyPassword($password)
      
    //METHOD: changePassword($password)
    public function changePassword($password){
        //This method changes the users password 
        
        //encrypt the password passes as argument
        $password = hash('ripemd160', $password);
        
        //generate the SQL depending on user type
        if($this->getUserType()==='LECTURER'){ // lecturer is logged in 
            $sql="UPDATE lecturer SET password = '$password'  WHERE LectID = '$this->userID'"; 
        }
        else{ //student is logged in
            $sql="UPDATE students SET password = '$password'  WHERE StudentID = '$this->userID'"; 
        }
        
        //execute the query and verify only 1 row exists
        if((@$rs=$this->db->query($sql)===TRUE)&&($this->db->affected_rows===1)){ 
            return $sql;
        }
        else{
            return $sql;
        }  
        
    }  
    //END METHOD: changePassword($password)
        
    //setters
    public function setLoginAttempts($num){$this->session->setLoginAttempts($num);}
    public function setChatEnabledState($state){$this->session->setChatEnabledState($state);}
    
    //getters
    public function getLoggedInState(){return $this->session->getLoggedinState();}//end METHOD - getLoggedInState        
    public function getUserID(){return $this->userID;}
    public function getUserFirstName(){return $this->userFirstName;}
    public function getUserLastName(){return $this->userLastName;}
    public function getUserType(){return $this->userType;}
    public function getLoginAttempts(){return $this->session->getLoginAttempts();}  
    public function getChatEnabledState(){return $this->chatEnabled;}
     public function getDiagnosticInfo(){
        echo '<div class="container-fluid"   style="background-color: #AAAAAA">'; //outer DIV
            echo '<h3>USER (CLASS)  properties</h3>';
            echo '<table border=1 border-style: dashed; style="background-color: #EEEEEE" >';
            echo '<tr><th>PROPERTY</th><th>VALUE</th></tr>';
            echo "<tr><td>userID  </td><td>$this->userID       </td></tr>";
            echo "<tr><td>userFirstName  </td><td>$this->userFirstName     </td></tr>";
            echo "<tr><td>userLastName  </td><td>$this->userLastName         </td></tr>";
            echo "<tr><td>userType  </td><td>$this->userType         </td></tr>";
            echo "<tr><td>chatEnabled  </td><td>$this->chatEnabled         </td></tr>";
            echo "<tr><td>loggedin  </td><td> $this->loggedin        </td></tr>";
            echo "<tr><td>Password Encryption  </td><td> $this->encryptPW        </td></tr>";
            echo "<tr><td>  </td><td>         </td></tr>";
            echo "<tr><td>  </td><td>         </td></tr>";
            echo "<tr><td>  </td><td>         </td></tr>";
            
            echo '</table>';
            echo '<p><hr>';
        echo '</div>';
    }//END METHOD:  getDiagnosticInfo()

}
