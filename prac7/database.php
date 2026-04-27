<?php
$connection = mysqli_connect('localhost', 'root', '', 'practice7');
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>