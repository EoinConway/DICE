<?php

class TableEntity {
    
protected $db;
private $tableName;
    
function __construct ($databaseConnection,$tableName){
    $this->tableName=$tableName;
    $this->db=$databaseConnection;
}    

//table entity methods


public function select_all(){
    $sql = "SELECT * FROM  $this->tableName";  //valid query
    if(@$rs=$this->db->query($sql)){  //execute query and check resultset has been returned 
        return $rs;  //Static methods can be called directly - without creating an instance of the class first.
        $rs->free();
    }
    else{  //something went wrong with the SQL query execution 
        return false;  
    }
}


//getters
public function get_table_name(){
    return $this->tableName;
}    
    
    
}
