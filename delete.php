<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

include("../edexpertsonline.net/config.php");
        ?>
        
    <!-- jquery + jquery UI includes -->
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
    

        <script type="text/javascript">
            function UpdateStatus(counter){
                $('#status').html(counter); 
            }
            $(document).ready(function(){
               $('#status').html('0'); 
            });
        </script>    
    <div id="status" class="status"> testing </div>
    
        <?
//DELETE from records where TO_days(now()) - TO_days(FROM_UNIXTIME(`Timestamp`)) >= '365'
       ?>
        <script type="text/javascript">
            UpdateStatus('1');
        </script>    
       <?
    $sql = "SELECT recordID from records where TO_days(now()) - TO_days(FROM_UNIXTIME(`Timestamp`)) >= '365' limit 0, 10";
    $results = mysql_query($sql);
    $count = 0;
    while ($tmp_row = mysql_fetch_assoc($results)){
       ?>
        <script type="text/javascript">
            UpdateStatus('<?=$count?>');
        </script>    
       <?
        $count++;
        $sql = "DELETE FROM records where recordID = '" . $tmp_row['recordID'] . "'";
        $res = mysql_query($sql);
    }
    

?>