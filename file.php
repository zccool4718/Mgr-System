<?php/** * @author Timothy Dunn * @copyright 2010 */print('    <script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>    <link type="text/css" rel="stylesheet" href="css/cupertino/jquery-ui-1.8.2.custom.css" />    <link type="text/css" rel="stylesheet" href="css/demo_table_jui.css" />                    <script type="text/javascript">			$(document).ready(function(){			 $(\'.dataTable\').dataTable({			              		"sPaginationType": "full_numbers",					                    "bJQueryUI": true,                    "sDom": \'<"top"fi>rt<"bottom"lp<"clear">\'                            });   			});    </script>');if ($handle = opendir('C:\Users\ZCCool4718\Documents\Saved Music')) {    print('        <table width="100%" border="0" class="display dataTable" id="Listtable">            <thead>                <tr style="white-space: nowrap;">                    <th style="width: 60px;">No.</th>                    <th>Artist</th>                </tr>            </thead>            <tbody>    ');    $count = 0;    while (false !== ($file = readdir($handle))) {        if($file !== "." && $file !== ".."){            $count++;            print('                <tr>                    <td>'.$count.'</td>                    <td>'.$file.'</td>                </tr>            ');        }    }        print('                </tbody>	            <tfoot>                <tr style="white-space: nowrap;">                    <th style="width: 30px;">No.</th>                    <th>Artist</th>                </tr>            </tfoot>        </table>    '); }?>