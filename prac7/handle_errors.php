<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// make a function to log errors to db
function log_error($error_code, $error_message){
    require('database.php');

    $error_time = date('Y-m-d H:i:s');
    
    // $error_code = mysqli_real_escape_string($connection, $error_code);
    // $error_message = mysqli_real_escape_string($connection, $error_message);
    
    // instead of escape string, we use prepared statement
    // $stmt
    $query = 
    "INSERT INTO error_logs 
    (error_code, error_message, error_time) 
    VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, 'sss', $error_code, $error_message, $error_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    mysqli_close($connection);
}

// We do some error here: 
require('database.php');

echo "<h3>Division-by-Zero Check</h3>";
$divisor = 0;
$divisionByZeroOccurred = false;

// Instead of letting the error happen, 
// we check for it beforehand
if ($divisor == 0) {
 echo "Error: Division by zero avoided.<br>";
 $divisionByZeroOccurred = true;
} else {
 $result = 100 / $divisor;
 echo "Result: $result<br>";
}

// Then we log the error to database if it occurred
if($divisionByZeroOccurred){
    log_error('E_DIV_ZERO', 'Attempted division by zero, Please check your calculations');
    echo '<p style="color:#FF0000;">Error: Division by zero occurred. This has been logged.</p>';
}

echo "<h3>Undefined Variable Check</h3>";
if (isset($some_undefined_variable)) {
 echo $some_undefined_variable;
} 
else {
 echo "Notice: 'some_undefined_variable' is not defined. Make sure all variables are declared before use.<br>";
 $error_message = "Detected an undefined variable in the code.";
 log_error('E_UNDEFINED_VAR', $error_message);
 echo "<p>Logged undefined variable notice to the database successfully.</p>";
}

mysqli_close($connection);
echo '<br>End of Script';


?>