<?php

class SportTable extends TableEntity {

    //METHOD: Construct
    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection A validated MySQLi database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'SportTable');
    }
    //END METHOD: Construct
   
    
    
    //METHOD: getRecordByID($sport_nr)
    /**
     * Returns a partial record (sport only by ID)
     * 
     * @param string $sport_nr
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */ 
    public function getRecordByID($sport_nr){
        $sql="SELECT sport FROM sportlookup WHERE sport_nr='$sport_nr'";
        $rs=$this->db->query($sql);
        if($rs->num_rows===1){
            return $rs;
        }
        else{
            return false;
        }        
        
    }
    //END METHOD: getRecordByID($sport_nr)
    

     
    
    //METHOD: deleteRecordbyID($sport_nr)
     /**
     * Performs a DELETE query for a single record ($sport_nr).  Verifies the
     * record exists before attempting to delete
     * 
     * @param $sport_nr  String containing number of corresponding sport record to be deleted
     * 
     * @return boolean Returns FALSE on failure. For successful DELETE returns TRUE
     */
    public function deleteRecordbyID($sport_nr){
        
        if($this->getRecordByID($sport_nr)){ //confirm the record exists before deletig
            $sql = "DELETE FROM sportlookup WHERE sport_nr='$sport_nr'";
            $this->db->query($sql); //delete the record
            return true;
        }
        else{
            return false;
        }       
    }
     //END METHOD: deleteRecordbyID($sport_nr) 
   
    //METHOD:    getAllRecords() 
    /**
     * Performs a SELECT query to returns all records from the table. 
     * sport_nr, Sport columns only.
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
     public function getAllRecords(){
        $sql = 'SELECT * FROM sportlookup';
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
         * $postArray['sport_nr'] string Sport Name
     * 
     * @return boolean
     * 
     * 
     */   
    public function addRecord($postArray){
        
        //get the values entered in the form contained in the $postArray argument      
        extract($postArray);
        
        //add escape to special characters
        $sportName= addslashes($sport);
        
        
        //construct the INSERT SQL
        $sql="INSERT INTO sportlookup (sport) VALUES ('$sportName')";   
       
        //execute the insert query
        $rs=$this->db->query($sql); 
        //check the insert query worked
        if ($rs){return TRUE;}else{return FALSE;}
    }
    //END METHOD: addRecord($postArray,$encryptPW)   

   
    
}

