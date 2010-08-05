<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

 $classVersion = "3.2";
 $creationDate = "5/13/10";
 $lastUpdated = "5/13/10";
 $lastUpdatedAuthor = "Timothy Dunn";
 $classDescription = "Database class";

 class database{
    private $username;
    private $password;
    private $database;
    private $server;
    
    private $db_Con;
    
    public $affected_rows;
    
    public function __construct($tmp_info_db, $server_tmp = "localhost"){
        
        if(is_array($tmp_info_db)){
            $this->username = $tmp_info_db['username'];
            $this->password = $tmp_info_db['password'];
            $this->database = $tmp_info_db['database'];            
        } else {
            return false;
        }
        $this->server = $server_tmp;
                
        if($this->Connection()){
            return true;
        } else {
            return false;  //replace with error code using an error class
        }
    }    
    
    private function Connection(){
        $this->db_Con = @mysql_connect($this->server, $this->username, $this->password, true);
        
        if(!$this->db_Con){
            return false;  //replace with error code using an error class
        }
    }
    
   	public function Query($sql){   	    
        $dbSelected = @mysql_select_db($this->database, $this->db_Con);
        
        if(!$dbSelected){
            return false;  //replace with error code using an error class
        }
        
        $tmp_results = @mysql_query($sql, $this->db_Con);
        if(mysql_errno($this->db_Con)){
            return false;  //replace with error code using an error class
        } else {            
            $this->affected_rows = mysql_affected_rows();
            
            while ($tmp_row = mysql_fetch_assoc($tmp_results)) {
                $row[] = $tmp_row;
            }
            
            if(mysql_num_rows($tmp_results) == 1){
                $tmp_row = $row[0]; 
                $row = $tmp_row;               
            }
            
            return $row;
        }
        
	}
    
   	public function Execuite($sql){   	    
        $dbSelected = @mysql_select_db($this->database, $this->db_Con);
        
        if(!$dbSelected){
            return false;  //replace with error code using an error class
        }
        
        $tmp_results = @mysql_query($sql, $this->db_Con);
        if(mysql_errno($this->db_Con)){
            return false;  //replace with error code using an error class
        } else {            
            $this->affected_rows = mysql_affected_rows();
            return true;
        }
        
	}        
    
	public function Disconnect(){		
		@mysql_close($this->db_Con);		
	}
    	
    
    
 }


?>