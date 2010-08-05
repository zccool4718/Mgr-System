<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

 $classVersion = "2.0";
 $creationDate = "5/12/10";
 $lastUpdated = "5/12/10";
 $lastUpdatedAuthor = "Timothy Dunn";
 $classDescription = "Page Builder class";
 
 
include_once("class.database.php");

 class page{
	private $db; 
    private $pageParts = array(); 
    private $css = array();     
    private $dojo = array(); 
    private $dojoTheme = "";
    private $dojoSet = false;    
    
    private $pageID = 0;
    private $pageTitle = "";
    
	private $topMenu = array();
	
    public function __construct($info_db, $tmp_pageTitle, $tmp_pageID, $tmp_menu){  
		$this->timer();
		$this->db = new DataBase($info_db);
        
        if(is_array($tmp_menu)){
            $this->topMenu = $tmp_menu;
        }
                
        $sql = "SELECT * FROM dbs_site.site_parts order by partID" ;
        $this->pageParts = $this->db->Query($sql);
        $this->pageID = $tmp_pageID;
    }   
   
    private function timer($finish = false){
	    static $start_frac_sec, $start_sec, $end_frac_sec, $end_sec;
	    if($finish){
	        list($end_frac_sec,$end_sec) = explode(" ", microtime());
			        return  round((($end_sec - $start_sec) + ($end_frac_sec - $start_frac_sec)), 4);
	    }else{
	        list($start_frac_sec,$start_sec) = explode(" ", microtime());
	    }
	}
    
	public function cssSet($tmp_css = ""){
        if(is_array($tmp_css)){
            if(count($tmp_css) > 0){
                foreach($tmp_css as $index => $value){
                	$this->css[] = $value;
                }
            }
        } else if(strlen($tmp_css) > 0){
            $this->css[] = $tmp_css;
        }  
        
        if(count($this->css) < 1){
            $tmp_css = $this->css[0]; 
            unset($this->css); 
            $this->css[] = array($tmp_css);               
        }
	}
    
    private function dojoSet($tmp_dojo = ""){
        if(is_array($tmp_dojo)){
            if(count($tmp_dojo) > 0){
                foreach($tmp_dojo as $index => $value){
                	$this->dojo[] = $value;
                }
            }
        } else if(strlen($tmp_dojo) > 0){
            $this->dojo[] = $tmp_dojo;
        }  
        
        if(count($this->dojo) < 1){
            $tmp_dojo = $this->dojo[0];
            unset($this->dojo); 
            $this->dojo = array($tmp_dojo);               
        }
        
    }
    
    public function dojoSetup($dojoTheme, $dojoScripts = ""){
        if(strlen($dojoTheme) > 0){
            $this->dojoTheme = $dojoTheme;
            $this->dojoSet = true;
			$this->cssSet("dojo/dijit/themes/" . $dojoTheme . "/" . $dojoTheme . ".css");
        }            
	    $this->cssSet("dojo/dojo/resources/dojo.css");
       
        $this->dojoSet("dojo.parser");
        if(count($dojoScripts) > 0 || strlen($dojoScripts) > 0){
            $this->dojoSet($dojoScripts);        
        } 
    }
	
	public function Header(){
		print('		
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html>

			<head>
				<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
                <meta content="J47b6COiR-w9cqpJTYiOwkDlh_af5AN-EiUDL9WkUM0" name="google-site-verification"/>
				<meta name="author" content="Timothy Dunn">
				<title>'.$this->pageTitle.'</title>
		');
        
        
		
		eval($this->pageParts[1]['code']);
        		
		eval($this->pageParts[0]['code']);	

			
		print('		
				<style type="text/css">
		');
	
		if(is_array($this->css)){
			foreach($this->css as $index => $value){
			 if(is_array($value)){
			     print_r($value);
			 }
				print('					   
				       @import "'.$value.'";
				');
			}
		}
		
		print('	
				</style>
       
		');	
            
		if($this->dojoSet){	
			print('	
				<script type="text/javascript" src="dojo/dojo/dojo.js" djConfig="parseOnLoad: true"></script>
				<script type="text/javascript" src="dojo/dijit/dijit.js"></script>
			    <script type="text/javascript">
			');
		
			if(is_array($this->dojo))			
				foreach($this->dojo as $index => $value){
					print('					   
					       dojo.require("'.$value.'");
					');
				}
		
			print('	
				    </script>
                    
                    </head>
			');
				
		}
        	 
		
	
	}    
	
	public function Main(){ //Main Content
		if($this->dojoSet){
			print('			
				<body class="' . $this->dojoTheme . '">
			');
		} else {
			print('			
				<body>
			');
		}

		print('
            <div class="part1">             
                <div class="part11">
                </div>
                <div class="part12">
                </div>
                <div class="part13">                    
                </div>
                <div class="topMenu">
        ');
                        
        foreach($this->topMenu as $menuName => $menuURL){
            if($menuName == "Login"){					
					print($menuURL.' | ');
			} else {
				if(!empty($menuURL)){
					print('<a href="'.$menuURL.'">'.$menuName.'</a> | ');
				} else {
					print($menuName . "|");
				}	
			}			
        }
        
        print(' 
                    </div>
            </div>
            <div class="part2">  
        ');
	}    
	
	public function Footer(){	   
		eval($this->pageParts[2]['code']);
	}
 }
 

?>