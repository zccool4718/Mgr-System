<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

 session_start();
 
include_once("class.database.php");
 
 class login{
	private $db;

    public function __construct($tmp_info_db, $server_tmp = "localhost"){
        if(is_array($tmp_info_db)){
            $this->db = new database($tmp_info_db, $server_tmp);            
        } else {
            return false;
        }
    }
    
 }
 
?>