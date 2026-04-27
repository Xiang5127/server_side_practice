<?php
session_start();

// error_reporting catches errors
// ini_set can change the php.ini file settings
// this will be == 0 in production
// we do log_errors instead in production
ini_set('display_errors', 1);

// we can have different levels of error reporting: 
// E_ERROR, E_WARNING, E_PARSE, E_NOTICE, E_ALL
error_reporting(E_ALL);

// Trigger Error
echo "Undefined variable test: " . $undefined_variable . "<br>";

// echo "Division by zero test: ";
// $result = 100 / 0;
// echo $result . "<br>";

require('database.php');

$bad_query = "INSERT INTO error_logs (error_code, error_message, error_time)
 VALUES ('E_TEST', 'Testing malformed query', '2025-01-01 00:00:00'";
mysqli_query($connection, $bad_query) or die("MySQL Error: " . mysqli_error($con));

mysqli_close($connection);

echo '<br>End of Script';
?>