<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */


function timer($finish = false){
    static $start_frac_sec, $start_sec, $end_frac_sec, $end_sec;
    if($finish){
        list($end_frac_sec,$end_sec) = explode(" ", microtime());
        return round((($end_sec - $start_sec) + ($end_frac_sec - $start_frac_sec)), 4);
    }else{
        list($start_frac_sec,$start_sec) = explode(" ", microtime());
    }
}

function measure_kbps($totTime){
  function micro_time(){
    $timearray = explode(" ", microtime());
    return ($timearray[1] + $timearray[0]);
  }

  for ($i=0; $i<1023; $i++){
    $chunk.='A';
  }
  $chunk.='\n';
  
  echo "<!-- ";
  flush();
  $count=0;
  $starttime = micro_time();
  do {
    echo $chunk;
    $count++;
    flush();
    $endtime = micro_time();
    $totaltime = $endtime - $starttime;
    $totaltime = round($totaltime,5);
  } while ($totaltime < $totTime);
  echo " -->\n";
  
  return ($count * 8);
}


?>