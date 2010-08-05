<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

 $classVersion = "2.0";
 $creationDate = "6/14/10";
 $lastUpdated = "6/14/10";
 $lastUpdatedAuthor = "Timothy Dunn";
 $classDescription = "IP to location helper class";
 
class ip2location{
	function getlocation($userIP){
	   
       $d = file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=".$userIP."&output=xml");
 
    	//Use backup server if cannot make a connection
    	if (!$d){
    		$backup = file_get_contents("http://backup.ipinfodb.com/ip_query.php?ip=".$userIP."&output=xml");
    		$answer = new SimpleXMLElement($backup);
    		if (!$backup) return false; // Failed to open connection
    	}else{
    		$answer = new SimpleXMLElement($d);
    	}
    
        $country_code = $answer->CountryCode;
    	$country_name = $answer->CountryName;
    	$region_name = $answer->RegionName;
    	$city = $answer->City;
    	$zippostalcode = $answer->ZipPostalCode;
    	$latitude = $answer->Latitude;
    	$longitude = $answer->Longitude;
    	$timezone = $answer->Timezone;
    	$gmtoffset = $answer->Gmtoffset;
    	$dstoffset = $answer->Dstoffset;
        $hostname = gethostbyaddr($userIP);
     
    	//Return the data as an array
    	return array('ip' => $ip, 'hostname' => $hostname, 'country_code' => $country_code, 'country_name' => $country_name, 'region_name' => $region_name, 'city' => $city, 'zippostalcode' => $zippostalcode, 'latitude' => $latitude, 'longitude' => $longitude, 'timezone' => $timezone, 'gmtoffset' => $gmtoffset, 'dstoffset' => $dstoffset);
    }
}
?>