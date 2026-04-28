<?php
// Do database connection
$connection = mysqli_connect("localhost","root","","practical8");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>