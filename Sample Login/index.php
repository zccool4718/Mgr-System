<?php

/**
 * @author Nathan Mast
 * @copyright 2010
 */
session_start();
 if(isset($_POST['login']))
 {
 include '/classes/class.login.php';
 $login = new login();
 
    if($login->isloggedin())
    {
        echo "success";
    }
    else 
    {
        $login->showErrors();
    }
 }
 $token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
?>
Username must be 5-12 Characters, Password must be at least 8 Characters, 1 upper 1 number
<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
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