<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

 session_start();

 $classVersion = "2.2";
 $creationDate = "5/20/10";
 $lastUpdated = "5/20/10";
 $lastUpdatedAuthor = "Timothy Dunn";
 $classDescription = "Login class";
 
include_once("class.database.php");
include_once('class.ip2location.php');
 
 class login{
	private $db;
    private $ip;
    
    private $userID;
    
    public function __construct($tmp_info_db, $server_tmp = "localhost"){
        
        if(is_array($tmp_info_db)){
            $this->db = new database($tmp_info_db, $server_tmp);            
        } else {
            return false;
        }
                  
        $this->ip = new ip2location();
    }
    
    public function ActionShorter($action, $logVars){
        if(method_exists($this, $action)){
            return $this->$action($logVars);
        } else {          
            return "Action Not found!";
        }
    }
    
    private function login($logVars){        
        $this->removeInactiveUsers();
        $this->removeInactiveQuest();
        
        $userID = $this->CheckUserName($logVars['user']);
        if($this->CheckPassword($userID, $logVars['pass'])){  
            $this->removeActiveGuest($logVars['ip']);
            $this->addActiveUser($logVars['ip'], $logVars['pgid'], $userID);
            $this->UpdateLastLogin($userID);  
            foreach($this->GetUserData($userID) as $index => $value){                
					$_SESSION[$index] = $value;
            } 
            @header('Location: ' . $logVars['url']); 
        } else {           
            return "Error Can not login!"; 
        }
        
    }
    
    private function logout($logVars){    
        $this->removeInactiveUsers();
        $this->removeInactiveQuest();
        
        $this->removeActiveUser($logVars['ip']);
		session_destroy();
		@header('Location: ' . $logVars['url']);
    }
    
    private function CheckUserName($userName){
		$sql = "SELECT * FROM dbs_site.site_users WHERE userName = '". $userName."'";
		$results = $this->db->Query($sql);
		return $results['userID'];
	}
	
	private function GetUserLevel($userID){
		$sql = "SELECT accessLevel FROM dbs_site.site_users WHERE userID = ".$userID;
		$results = $this->db->Query($sql);
		if(count($results) > 0){
			return $results['accessLevel'];
		} else {
			return false;
		}
	}
	
	private function CheckPassword($userID, $userPassword){
		$sql = "SELECT * FROM dbs_site.site_users WHERE userID = ".$userID." and password = MD5('".$userPassword."')";
        $this->db->Execuite($sql);
		if($this->db->affected_rows > 0){
			return true;
		} else {
			return false;
		}
	}
	
	private function GetUserData($userID){
        $sql = "SELECT userID, userName, displayName, accessLevel, lastLogin FROM dbs_site.site_users WHERE userID = ".$userID;
        return $this->db->Query($sql);
	}
    
    private function UpdateLastLogin($userID){        
        $sql = "UPDATE dbs_site.site_users SET lastLogin = now() WHERE userID = ".$userID;
        
		if($this->db->Execuite($sql)){
			return true;
		} else {
			return false;
		}
    }
    
	public function CountActiveUsers(){
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
		$sql = "SELECT count(*) FROM dbs_site.site_activeUsers";
        $results = $this->db->Query($sql);
		return $results['count(*)'];
	}
	
	public function CountActiveGuests(){
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
		$sql = "SELECT count(*) FROM dbs_site.site_activeGuest";	
        $results = $this->db->Query($sql);
		return $results['count(*)'];
	}
    
    public function GetActiveUsers(){
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
		$sql = "SELECT * FROM dbs_site.site_activeUsers";	
        return $this->db->Query($sql);
    }
    
    public function GetActiveGuests(){
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
		$sql = "SELECT * FROM dbs_site.site_activeGuest";	
        return $this->db->Query($sql);
    }
	
	public function removeInactiveUsers(){
		$timeout = time()-10*60;
		$sql = "DELETE FROM dbs_site.site_activeUsers WHERE timeStamp < '".date('Y-m-d H:i:s', $timeout)."'";
        
		if($this->db->Execuite($sql)){
			return true;
		} else {
			return false;
		}
   }
	
	public function removeInactiveQuest(){
		$timeout = time()-5*60;
		$sql = "DELETE FROM dbs_site.site_activeGuest WHERE timeStamp < '".date('Y-m-d H:i:s', $timeout)."'";
        
		if($this->db->Execuite($sql)){
			return true;
		} else {
			return false;
		}
    }   
   
   public function removeActiveUser($IP){
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
      $sql = "DELETE FROM dbs_site.site_activeUsers WHERE ipAddress = '".$IP."'";
        
		if($this->db->Execuite($sql)){
			return true;
		} else {
			return false;
		}
   }
   
   public function removeActiveGuest($IP){
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
      $sql = "DELETE FROM dbs_site.site_activeGuest WHERE ipAddress = '".$IP."'";
        
		if($this->db->Execuite($sql)){
			return true;
		} else {
			return false;
		}
   }
    
    public function addActiveGuest($IP, $pID){ 
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
        $tmp_location = $this->ip->getlocation($IP);                
        $sql = "REPLACE INTO dbs_site.site_activeGuest VALUES (".$pID.", '".$IP."', ".$tmp_location['latitude'].", ".$tmp_location['longitude'].", '".$tmp_location['country_name']."', '".$tmp_location['hostname']."', now())";
        
		if($this->db->Execuite($sql)){
			return true;
		} else {
			return false;
		}
   }
    
    public function addActiveUser($IP, $pID, $userID){ 
        $this->removeInactiveQuest();
        $this->removeInactiveUsers();
        $sql = "DELETE FROM dbs_site.site_activeGuest WHERE ipAddress = '".$IP."'";
        $this->db->Execuite($sql);
        
        $tmp_location = $this->ip->getlocation($IP);                
        $sql = "REPLACE INTO dbs_site.site_activeUsers VALUES (".$pID.", '".$IP."', ".$tmp_location['latitude'].", ".$tmp_location['longitude'].", '".$tmp_location['country_name']."', '".$tmp_location['hostname']."', now(), ".$userID.")";
        
		if($this->db->Execuite($sql)){
			return true;
		} else {
			return false;
		}        
   }
    
 }

?>