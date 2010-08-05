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
  
    //Menu Builder
   	if(count($_SESSION) > 1 and $_SESSION['accessLevel'] > 0){	
		$topMenu['Welcome ' . $_SESSION['displayName'] . " "] = "";		
		$topMenu['Logout'] = basename(__FILE__)."?action=logout&url=" . $_SERVER['PHP_SELF'];
        $topMenu['Homepage'] = "index.php"; 
        
        if($_SESSION['accessLevel'] > 4){
            $topMenu['Rep Homepage'] = "rep.php";              
        }
        
        
        if($_SESSION['accessLevel'] > 8){
            $topMenu['Admin'] = "admin/admin.php";   
            
        }        
	} else {
    		@header('Location: index.php');
        
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
     
 	print('                  
        </div>
    </div>
	 ');       
     
 	print('
    <div class="outcontent">
        <div class="content">
	 ');


    print(' Please use this area for information passing. For document and event sharing.
        
    ');
    
    if($_SESSION['accessLevel'] > 4){
        print('
        <br />
        <br />
        <br />
            <table class="fileTable">
                <tr>
                    <th>File ID</th>
                    <th>File Name</th>
                    <th>Description</th>
                    <th>Added Date</th>
                    <th>Added By</th>
                    <th>Download</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Clear Sign Up Sheet (2)</td>
                    <td>Temp Sign up sheet until online ording is ready</td>
                    <td>6/25/2010</td>
                    <td>William Hanks</td>
                    <td>
            ');
            
            if($_SESSION['accessLevel'] > 5){
        print('
                        <a href="documents/ClearSignUpSheet.doc" title="Word Document 97-2003"><img align="absbottom" src="images/documents/doc.ico" />Doc (Old Word)</a> 
                        <a href="documents/ClearSignUpSheet.docx" title="Word Document"><img align="absbottom" src="images/documents/doc.ico" />Doc (New Word)</a>  
                        <a href="documents/ClearSignUpSheet.pdf" title="PDF Document"><img align="absbottom" src="images/documents/pdf.ico" />PDF</a>
            ');
            }
        print('
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Installing clear tips</td>
                    <td>Install help guide</td>
                    <td>6/25/2010</td>
                    <td>William Hanks</td>
                    <td>
            ');
            
            if($_SESSION['accessLevel'] > 5){
        print('
                        <a href="documents/Installingcleartips.doc" title="Word Document 97-2003"><img align="absbottom" src="images/documents/doc.ico" />Doc (Old Word)</a> 
                        <a href="documents/Installingcleartips.docx" title="Word Document"><img align="absbottom" src="images/documents/doc.ico" />Doc (New Word)</a>  
                        <a href="documents/Installingcleartips.pdf" title="PDF Document"><img align="absbottom" src="images/documents/pdf.ico" />PDF</a>
            ');
            }
        print('
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>AR-EventRequest-Electronic</td>
                    <td>Event Request Forum</td>
                    <td>6/25/2010</td>
                    <td>William Hanks</td>
                    <td> 
            ');
            
            if($_SESSION['accessLevel'] > 5){
        print('
                        <a href="documents/AR-EventRequest-Electronic.pdf" title="PDF Document"><img align="absbottom" src="images/documents/pdf.ico" />PDF</a>
            ');
            }
        print('
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Map</td>
                    <td>Cover Area Map</td>
                    <td>6/25/2010</td>
                    <td>William Hanks</td>
                    <td> 
            ');
            
            if($_SESSION['accessLevel'] > 5){
        print('
                        <a href="documents/Map.doc" title="Word Document 97-2003"><img align="absbottom" src="images/documents/doc.ico" />Doc (Old Word)</a> 
                        <a href="documents/Map.docx" title="Word Document"><img align="absbottom" src="images/documents/doc.ico" />Doc (New Word)</a>  
                        <a href="documents/Map.pdf" title="PDF Document"><img align="absbottom" src="images/documents/pdf.ico" />PDF</a>  
                        <a href="documents/map.jpg" title="JPG Image File"><img align="absbottom" src="images/documents/jpg.ico" />JPG</a>
            ');
            }
        print('
                    </td>
                </tr>
            </table>
        
        ');                  
    }
                        
 	print('                   
        </div>
    </div>
	 ');


 /**
 * Main Content End Here
 */
    
    
    $page->Footer();
    $db->Disconnect();
     


?>