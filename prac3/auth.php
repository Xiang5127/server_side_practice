'auth.php' is here.
This is used to track logged in users.
<br>
<?php
// session_start() does not mean starting a session 
// but it means 
// "we are going to use the $_SESSION globalvariable now!"  ?
session_start();
if(!isset($_SESSION["username"])){
    header('Location: login.php');
    exit();
}
?>