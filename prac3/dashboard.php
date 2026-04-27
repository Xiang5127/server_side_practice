<?php
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>This is the dashboard.</h1>
    <p>Only logged in users can see this.</p>

    <div name="navigations">
        <a href="index.php">Home</a> <br><br>
        <a href="crud/insert.php">Insert Data</a> <br><br>
        <a href="crud/view.php">View Data</a> <br><br>
        <a href="file_manager.php">Add Files</a><br><br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>