<?php
// Logout user by destroying the session
session_start();

$destroy = session_destroy();
setcookie("username","", time() -3600,"/");

if($destroy){
    header('Location: login.php');
}
?>