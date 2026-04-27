<!--- Error handler with .txt file --->

<?php
// most important for error: 
// 1) ini_set('display_errors', 0/1);
// 2) error_reporting(E_ALL);

ini_set('display_errors', 1);
error_reporting(E_ALL);

function logErrorToDb($error_code, $error_msg){
    require('database.php');

    $error_time = date('Y-m-d H:i:s');

    $query = 
    "INSERT INTO `error_logs` (error_code, error_message, error_time)
    VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);

    if($stmt){
        mysqli_stmt_bind_param($stmt, 'sss', $error_code, $error_msg, $error_time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}


function customErrorHandler($errno, $errstr, $errfile, $errline){
    // we use two built in function in PHP: 
    // error_log('msg', 3 (indicate to write to specific file), 'error_log.txt')
    // set_error_handler('customErrorHandler') put in a function name
    // when you call this, php gives 4 data: 
    // - $errno (warning, fatal, notice etc)
    // - $errstr (the error message)
    // - $errfile (which file happen)
    // - $errline (which line)

    // echo error message
    $custom_error_msg = $errno . ' ' . $errstr . ' occured in ' . $errfile .' at line ' . $errline .'<br>';
    echo "<br>Custom Message: " . $custom_error_msg . "<br>";

    $error_time = date("Y-m-d H:i:s");

    // write to file
    error_log($error_time . " " . $custom_error_msg . "\n", 3, 'error_log.txt');

    // save to db
    logErrorToDb($errno, $custom_error_msg);

    // needed return true to avoid php default error screen
    return true;
}

// set error handler --> put in function name
set_error_handler("customErrorHandler");

function customExceptionHandler($exception) {
 $exceptionMessage = "Exception: " . $exception->getMessage();
 echo "<b>Exception:</b> $exceptionMessage<br>";
 error_log("[" . date("Y-m-d H:i:s") . "] $exceptionMessage\n", 3, "error_log.txt");

 logErrorToDB("EXCEPTION", $exceptionMessage);
}
set_exception_handler("customExceptionHandler");



?>