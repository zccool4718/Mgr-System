<?php

/**
 * @author Timothy Dunn
 * @copyright 2010
 */

session_start();

function getDBinfo(){
    $db["host"]= "localhost";
    $db["user"]= "root";
    $db["pass"] = "Timkelly1";
    $db["db"]   = "mgrsys";
    return $db;
}
?>