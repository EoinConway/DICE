<?php

class AttendeeTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'user');
    }
    //END METHOD: Construct
    
    //METHOD:    getAllAttendees() 
    /**
     * Performs a SELECT query to returns all records from the table. 
     * ID,Firstname and Lastname columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllAttendeesByEvent($eventID){
        $sql = "SELECT 
                    first_name First, last_name Last
                FROM
                    attendee,
                    user,
                    event
                WHERE
                    attendee.User_ID = user.User_ID
                        AND attendee.event_ID = event.event_ID
                        AND event.event_ID = '$eventID';"
                ;
        if($rs=$this->db->query($sql)){
            if ($rs->num_rows>0){return $rs;}else{return false;}//at least one record should be returned
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getAllAttendees()
    
    
    //METHOD: getAttendeeRecord($userID, $eventID)
    /**
     * Returns a record (FirstName and LastName by userID and eventID
     * 
     * 
     * 
     */
    public function getAttendeeRecord($userID, $eventID){
        $sql="SELECT 
                    first_name First, last_name Last
                FROM
                    attendee,
                    user,
                    event
                WHERE
                    attendee.User_ID = user.User_ID
                        AND attendee.event_ID = event.event_ID
                        AND event.event_ID = '$eventID'
                        AND user.User_ID = '$userID';";
        
        if($rs=$this->db->query($sql)){
            if ($rs->num_rows===1){return $rs;}else{return false;}//only one record should be returned
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($userID
    
    
    //METHOD: deleteAttendee($userID, $eventID)
     /**
     * Performs a DELETE query for a single record ($userID, $eventID).  Verifies the
     * record exists before attempting to delete
     * 
     */
    public function deleteAttendee($userID, $eventID){
        
        if($this->getAttendeeRecord($userID, $eventID)){ //confirm the record exists before deletig
            $sql = "DELETE FROM attendee 
                    WHERE
                        User_ID = '$userID'
                        AND
                        event_ID = '$eventID';";
            if($this->db->query($sql)){return true;}else {return false;} //try to delete the record
        }
        else{
            return false; //record doesnt exist
        }       
    }
     //END METHOD: deleteRecordbyID($admin_ID) 
    
    //METHOD:    addAttendee($userID,$eventID)
      /**
       * add new Attendee record by userID and eventID
       * 
       * @param type $userID
       * @param type $eventID
       * @return boolean
       */
    public function addAttendee($userID,$eventID){
        
        
        //construct the INSERT SQL
        $sql = "INSERT INTO attendee(User_ID, event_ID) VALUES('$userID', '$eventID')";
        
        //execute the insert query
        //check the insert query worked
        if ($rs=$this->db->query($sql)){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addAttendee($userID,$eventID)

    
    //METHOD:    getAttendingEvents($user_ID)
    /**
     * Returns all events user is attending 
     * 
     * @param type $user_ID
     * @return boolean
     */
    public function getAttendingEvents($user_ID) {

        $sql = "SELECT 
		event.event_name Name,
		slu.sport Sport,
		event.fee Fee,
		event.event_date Date
	FROM
		event,
		sportlookup slu,
                attendee
	WHERE
		slu.sport_nr = event.sport
		AND 
		User_ID = '$user_ID'
                AND
                attendee.event_ID = event.event_ID;";
        if ($rs = $this->db->query($sql)) {
                return $rs;
        } else {
            return false;
        }
    }
    //END METHOD: addRecord($postArray,$encryptPW)
}

?>