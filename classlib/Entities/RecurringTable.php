<?php

class RecurringTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'RecurringTable');
    }
    //END METHOD: Construct
   
    
    
    //METHOD: getRecordByID($sport_nr)
    /**
     * Returns a partial record (sport only by ID)
     * 
     * @param string $sport_nr
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($recurring_nr){
        $sql="SELECT recurring_type FROM recurringlookup WHERE recurring_nr='$recurring_nr'";
        $rs=$this->db->query($sql);
        if($rs->num_rows===1){
            return $rs;
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($recurring_nr)
    

     
    
    //METHOD: deleteRecordbyID($recurring_nr)
     /**
     * Performs a DELETE query for a single record ($recurring_nr).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $recurring_nr  String containing number of corresponding recurrence type record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($recurring_nr){
        
        if($this->getRecordByID($recurring_nr)){ //confirm the record exists before deletig
            $sql = "DELETE FROM recurringlookup WHERE recurring_nr='$recurring_nr'";
            $this->db->query($sql); //delete the record
            return true;
        }
        else{
            return false;
        }       
    }
     //END METHOD: deleteRecordbyID($recurring_nr) 
   
    //METHOD:    getAllRecords() 
    /**
     * Performs a SELECT query to returns all records from the table. 
     * recurring_nr, recurring_type columns.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT * FROM recurringlookup';
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
         * $postArray['recurring_nr'] string Recurring Name
     * 
     * @return boolean
     * 
     * 
     */   
    public function addRecord($postArray){
        
        //get the values entered in the form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $recurringType= addslashes($recurringType);
        
        
        //construct the INSERT SQL
        $sql="INSERT INTO recurringlookup (recurring_type) VALUES ('$recurringType')";   
       
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addRecord($postArray,$encryptPW)   

   
    
}

