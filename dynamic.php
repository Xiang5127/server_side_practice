<html>
<head>
    <title>Dynamic Page</title>
</head>
<body>
    <h1>Welcome to the Dynamic Page</h1>
    <p>This page was generated dynamically using PHP.</p>
    <p>Current Date and Time: <?php echo date('Y-m-d H:i:s'); ?></p>
</body>
</html>

<?php

/**
 * Different type of HTTP Requests and Global Variables:
 * - $_GET('name'): An associative array of variables passed to the current script via the URL parameters.
 * - $_POST('name'): An associative array of variables passed to the current script via the HTTP POST
 * - $_REQUEST('get'): An associative array that contains the contents of $_GET, $_POST, and $_COOKIE.
 * - $_SERVER: An array containing information such as headers, paths, and script locations:
 *   - $_SERVER['REQUEST_METHOD']: Returns the request method used to access the page (e.g., GET, POST).
 * 
 * - isset(): A function that checks if a variable is set and is not NULL.
 */

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['input'])){
        $userInput = $_GET['input'];
        echo "<h2>You entered: " . htmlspecialchars($userInput) . "</h2>";
    } else {
        echo "<h2>No input received.</h2>";
    }
?>