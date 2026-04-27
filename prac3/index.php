<?php
// we check if user is logged in,
// we need this block of code in all pages we want to protect
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <?php
    echo "<h1>Welcome, " . $_SESSION['username'] . "!</h1>";
    
    // Check cookie for remember me
    if(isset($_COOKIE["username"])) {
        $cookie_value = $_COOKIE["username"];
        echo "<p>Remembered user: " . $cookie_value . "</p>";
    }
    else{
        echo "<p>No remembered user.</p>";
    }

    echo '<a href="dashboard.php">Dashboard</a> <br><br>';
    echo '<a href="logout.php">Logout</a>';
    ?>
</body>
</html>