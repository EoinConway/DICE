<?php

class EventTypeTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'EventTypeTable');
    }
    //END METHOD: Construct
   
    
    
    //METHOD: getRecordByID($type_nr)
    /**
     * Returns a partial record (event type only by type_nr)
     * 
     * @param string $type_nr
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($type_nr){
        $sql="SELECT Type FROM eventtypelookup WHERE Type_Nr='$type_nr'";
        $rs=$this->db->query($sql);
        if($rs->num_rows===1){
            return $rs;
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($type_nr)
    

     
    
    //METHOD: deleteRecordbyID($type_nr)
     /**
     * Performs a DELETE query for a single record ($type_nr).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $type_nr  String containing number of corresponding event type record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($type_nr){
        
        if($this->getRecordByID($type_nr)){ //confirm the record exists before deletig
            $sql = "DELETE FROM eventtypelookup WHERE Type_Nr='$type_nr'";
            $this->db->query($sql); //delete the record
            return true;
        }
        else{
            return false;
        }       
    }
     //END METHOD: deleteRecordbyID($type_nr) 
   
    //METHOD:    getAllRecords() 
    /**
     * Performs a SELECT query to returns all records from the table. 
     * type_nr, event_type columns.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT * FROM eventtypelookup';
        $rs=$this->db->query($sql);
        if($this->db->affected_rows){
            return $rs;
        }
        else{
            return false;
        }        
        
    }   
    //END METHOD: getAllRecords()
    
     //METHOD:    addRecord($postArray)
    /**
     * Inserts a new record in the table. 
     * 
     * @param array $postArray containing data to be inserted
         * $postArray['type_nr'] string Event Type
     * 
     * @return boolean
     * 
     * 
     */   
    public function addRecord($postArray){
        
        //get the values entered in the form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $eventType= addslashes($eventType);
        
        
        //construct the INSERT SQL
        $sql="INSERT INTO eventtypelookup (Type) VALUES ('$eventType')";   
       
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addRecord($postArray,$encryptPW)   

   
    
}

