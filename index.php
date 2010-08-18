<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

require("includes/config.php");
require("includes/common.php");

timer();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="author" content="Timothy Dunn">
    <title> Index - Template</title>
    
    <style>
        @import "css/default/style.css";
        @import "css/cupertino/jquery-ui-1.8.4.custom.css";
        
        
    </style>
    
    <!-- jquery + jquery UI includes -->
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.4.custom.min.js"></script>
    

    <!-- jquery + jquery UI includes Plugins-->
    <script type="text/javascript" language="javascript" src="js/jquery-ui.dialog.js"></script>
    
    <!-- Javascript -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#dialog").dialog("destroy");
            
            $('#login').live('click', function(){
                $("#dialog").css('visibility', 'visible');
		$('#dialog').dialog('open');
                
                $("#dialog").dialog({
		    autoOpen: false,
                    height: 250,
                    width: 300,
                    modal: true,
                    buttons: {
                        'Login': function() {
			    $(this).dialog('close');
                        },
                        Cancel: function() {
                            $(this).dialog('close');
                        }
                    }
                });
            });
            
            $(".dialog").css('visibility', 'hidden');
        
        });
        

</script>
    
</head>
<body>
    
    <table class="mainTable">
        <thead>
        <tr>
            <th class="mainMenu left font12">
                <ul>
                    <li class="mainMenuSelected">Home</li>
                    <li><a href="">Links</a></li>
                    <li><a href="">Admin</a></li>
                </ul>
            </th>
            <th class="mainMenu right font12">
                <ul>
                    <li><a id="login" class="login">Login</a></li>
                    <li><a href="">Register</a></li>
                </ul>
            </th>
        </tr>   
        </thead>
        <tbody>
            <td colspan="2" class="mainBody font14"> This is body
            
                <div id="dialog" name="dialog" class="dialog" title="Login">
                    <div class="loginTxt font10">
                    Username must be 5-12 Characters, Password must be at least 8 Characters, 1 upper 1 number. <br/><br/>
                    </div>
                    <form method="post" action="">
                        <div>
                            <label for="username">Username:</label>
                            <input type="text" name="username"  />
                        </div>
                        <div>
                            <label for="body">Password:</label>
                            <input type="password" name="password" />
                        </div>
                        <input type="hidden" name="token" value="<?=$token;?>" />
                        <input type="submit" name="login" value="Login"/>
                    </form>
                </div>
            </td>
        </tbody>
        <tfoot>
            <td colspan="2" class="mainFoot center font10">
            <?    
                $pageGenTime = timer(true);    
                $kbps=measure_kbps($pageGenTime);
                $mbps=$kbps / 1024;
                print("Page generated in " . $pageGenTime . " seconds");
                
                
            
            ?>
            </td>
        </tfoot>
    </table>
    
</body>
</html>



<?


?>