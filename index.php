<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */
    
    $pageTitle = "Home page - This site is still under construction!";
        
    $dir    = 'core';
    $files1 = scandir($dir);
    $classInfo = array();
    
    foreach($files1 as $key => $value){
        unset($classVersion);
        unset($creationDate);
        unset($lastUpdated);
        unset($lastUpdatedAuthor);
        unset($classDescription);
        
        if(!is_dir($value)){
            include($dir."/".$value);
            $tmp = explode(".", $value);
            
            $classInfo[$tmp[1]]["Class"] = $tmp[1];
            $classInfo[$tmp[1]]["version"] = $classVersion;
            $classInfo[$tmp[1]]["Date"] = $creationDate;
            $classInfo[$tmp[1]]["Update"] = $lastUpdated;
            $classInfo[$tmp[1]]["Author"] = $lastUpdatedAuthor;
            $classInfo[$tmp[1]]["Description"] = $classDescription;   
        }
    };
    
    
    $info_db['username'] = "site";
    $info_db['password'] = "Qazxsw21";
    $info_db['database'] = "dbs_site";
    
    $db = new database($info_db);
    $login = new login($info_db);
    
    //Validation of page to get basic informaiton from database or add's a new page
    
    $sql = "SELECT count(*) as count FROM dbs_site.site_page WHERE file = '" . basename(__FILE__) . "'";
    $pageCount = $db->Query($sql);
    
    if($pageCount['count'] == 0){                
        $sql = "INSERT INTO dbs_site.site_page VALUES (null, '".basename(__FILE__)."', 1, now(), 0)";
        $db->Execuite($sql);
    } elseif($pageCount['count'] > 0){
        $sql = "SELECT count(*) as count, avg(loadTime) as avg FROM dbs_site.stats_page WHERE pageID = (SELECT pageID FROM dbs_site.site_page WHERE file = '".basename(__FILE__)."')";
        $pageAvg = $db->Query($sql);
                        
        $sql = "UPDATE dbs_site.site_page SET avgBuildTime = ".$pageAvg['avg'].", counter = (SELECT counter FROM (SELECT * FROM dbs_site.site_page) as x WHERE file = '".basename(__FILE__)."') + 1 WHERE file = '".basename(__FILE__)."'";
        $db->Execuite($sql);
        
        $sql = "SELECT * FROM dbs_site.site_page WHERE file = '".basename(__FILE__)."'";
        $pageInfo = $db->Query($sql);
    }
    
    $_POST['pgid'] = $pageInfo['pageID'];    
    
    //Login Part of this page, logs the user in.
    if(isset($_POST['action']) and preg_match("/[A-Z  | a-z]+/", $_POST['user']) and preg_match("/[A-Z  | a-z]+/", $_POST['pass'])){
         $tmp_login = $login->ActionShorter($_POST['action'], $_POST);
    } elseif(isset($_GET['action'])){
        $_POST['url'] = "index.php";
        $_POST['ip'] = $_SERVER['REMOTE_ADDR'];
        $_POST['action'] = $_GET['action'];
         $tmp_login = $login->ActionShorter($_POST['action'], $_POST);
        
    }
              	
                
    //Menu Builder
   	if(count($_SESSION) > 1 and $_SESSION['accessLevel'] > 0){	
		$topMenu['Welcome ' . $_SESSION['displayName'] . " "] = "";		
		$topMenu['Logout'] = basename(__FILE__)."?action=logout&url=" . $_SERVER['PHP_SELF'];
        
        if($_SESSION['accessLevel'] > 4){
            $topMenu['Rep Homepage'] = "rep.php";              
        }
        
        if($_SESSION['accessLevel'] > 8){
            $topMenu['Admin'] = "admin/admin.php";              
        }
        
	} else {
		$topMenu['Login'] = '<a onclick="dijit.byId(\'dialog1\').show()">Login</a>';
        $login->addActiveGuest($_SERVER['REMOTE_ADDR'], $pageInfo['pageID']);
        
	}          
                           
              
              
    $page = new Page($info_db, $pageTitle, $pageInfo['pageID'], $topMenu);

	$dojoScripts[] = "dijit.form.Button";
	$dojoScripts[] = "dijit.Dialog";
	$dojoScripts[] = "dijit.form.TextBox";

    $page->cssSet("css/main.css");
    $page->dojoSetup("soria", $dojoScripts);
   
    $page->Header();
    $page->Main();
    
    
    
    /**
 * Main Content Start Here
 */
	print('
    <div class="outcontentright">
        <div class="contentright">
	 ');
     
     
            //            print_r($_SESSION);
     
    
 	print('                  
        </div>
    </div>
	 ');       
     
 	print('
    <div class="outcontent">
        <div class="content">
	 ');


    print('Please login using your e-mail address as the username and your sm + zip code as your password.
    <br /><br />
    Example <br /><br />
    
    if your e-mail is <strong>sam@email.com</strong>, your sm ID is <strong>101SM</strong> and your zip code is <strong>63123</strong><br /><br />
    
    Then your username is <strong>same@email.com</strong> and your password is <strong>101SM63123</strong><br /><br />
    
    NOTE: Over the weekend there will be alot more functions added to the site, one of those will be a forced password change. Right now you do not need to change your password, but by or on Monday the 18, 2010 you will be forced to.
    
    ');
    
                        
 	print('                   
        </div>
    </div>
	 ');
	 	
        
      
  
        
 print(' 
<div dojoType="dijit.Dialog" id="dialog1" title="Login">
    <table>
        <tr>
            <td>	  
                <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
                    <table align="left" border="0" cellspacing="0" cellpadding="3">
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="user" maxlength="30" value="'.$_POST['user'].'"></td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="pass" maxlength="30" value="'.$_POST['pass'].'"></td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left"><input type="checkbox" name="remember">
                            <input type=Hidden NAME="url" VALUE="rep.php">
                            <input type=Hidden NAME="ip" VALUE="'.$_SERVER['REMOTE_ADDR'].'">
                            <input type=Hidden NAME="action" VALUE="login">
                            Remember me next time &nbsp;&nbsp;&nbsp;
                            <input type="submit" value="Login"></td>
                        </tr>	
                    </table>
                </form> 
            </td>
        </tr>
    </table>
</div>
 ');
 

 /**
 * Main Content End Here
 */
    
    
    $page->Footer();
    $db->Disconnect();
     


?>