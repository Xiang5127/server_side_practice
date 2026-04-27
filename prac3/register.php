<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    // PHP here to check POST
    // then insert into database
    <?php

    // literally copy paste from database.php
    require('database.php');

    if(isset($_POST['username'])){
        // Everytime before insert need to 
        // 1) stripslashes()
        // 2) mysqli_real_escape_string()

        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($connection, $username);

        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($connection, $password);

        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($connection, $email);

        $reg_date = date('Y-m-d H:i:s');
        
        // SQL query only wants to look at Pure String
        $query = 
        "INSERT INTO `user` (name, email, password, reg_date) 
        VALUES ('$username', '$email', '" . md5($password) . "', '$reg_date')";

        if(mysqli_query($connection, $query)){
            echo "User registered successfully.";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
    ?>

    <div>
        <h2>Register</h2>
        <form action="" method="post">
            <label>Username: </label>
            <input type="text" name="username" placeholder="Enter Username" required><br>
            <label>Email: </label>
            <input type="email" name="email" required><br>
            <label>Password: </label>
            <input type="password" name="password" required><br>
            <input type="submit" name='submit' value="Register">
        </form>
    </div>
</body>
</html>