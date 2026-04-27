<?php
require('../database.php');
$id = $_GET['id'];
$query =
"DELETE FROM `products` 
WHERE id = '$id';";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
header("Location: view.php");
exit();
?>