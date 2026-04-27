// We need to start a session here: <br>
// The Golden Rule: If a .php file needs to <br>
// read, write, or even think about session data <br>
// at any point in its execution, <br>
// session_start() must be the very first thing it does. <br>
<?php
session_start();
$saved_username = $_COOKIE["username"] ?? '';
?>    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    // NOTE: 
    // mysqli_real_escape_string() ensures the database doesn't confuse data for SQL commands.
    // htmlspecialchars() ensures the browser doesn't confuse data for HTML/JS commands.
    // stripslashes() belongs in a museum!

    // literally copy paste from database.php
    require('database.php');

    // check if we come from reset password
    if(isset($_GET['reset_success'])) {
        if($_GET['reset_success'] == 1){
            echo '<div>
            <h3>Password reset successful. Please login with your new password.</h3>
            </div>';
        }
        else {
            echo 'Password reset failed.';
        }
    }

    // check if we come from form submit
    // else, show the login form
    if(isset($_POST['username'])){
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($connection, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($connection, $password);

        // In PHP, single quotes '' mean Raw String
        // use double quotes "" to replace variables with their values
        // SQL query only wants to look at Pure String
        $query = 
        "SELECT * FROM `user` 
        WHERE name = '$username' AND password = '" . md5($password) . "'; ";

        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $rows = mysqli_num_rows($result); // count how many rows we get back

        if($rows == 1){
            // The account is valid -> log user in by creating session
            $_SESSION['username'] = $username;

            // We check remember me
            if(isset($_POST['remember_me'])){
                // Set cookie to remember user for 7 days
                setcookie('username', $username, time() + (7 * 24 * 60 * 60), "/"); // 7 days
            }

            header('Location: index.php'); // header(Location: 'url')
            exit(); // kills it so it don't render the form below
        }
        else{
            echo '<div>
            <h3>Username/password is incorrect.</h3>
            </div>';
        }
    } else {
        // show the login form
        echo 
        '<div>
        <h2>Login</h2>
        <form action="" method="post">
            <label>Username: </label>
            <input type="text" name="username" value="' . htmlspecialchars($saved_username) . '" placeholder="Enter Username" required><br>
            <label>Password: </label>
            <input type="password" name="password" placeholder="Enter Password" required><br>
            <input type="checkbox" name="remember_me"> Remember Me<br>
            <input type="submit" name="submit" value="Login">
        </form>
        <p>Not registered yet? <a href="register.php">Register Here</a></p>
        <p>Forgot password? <a href="pass_reset/forgot_password.php">Reset Here</a></p>
        </div>';
    }
    ?>
    
</body>
</html>