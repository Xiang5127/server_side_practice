<?php
// Forgot password takes email input, 
// then check if exist, 
// then generate a token and store in database,
// then send email with the token link to user.
// Then the reseet password form is here.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Form</title>
</head>
<body>
    <?php
    require('../database.php');

    if(isset($_GET['token'])){
        $token = mysqli_real_escape_string($connection, $_GET['token']);

        // We only take the first occurance 
        // to prevent User kept pressing forget password
        $query = 
        "SELECT * FROM `password_resets` 
        WHERE token = '$token'
        LIMIT 1; ";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) == 1){
            // Now in here, we finally validated the User is real
            // Get associative array from row
            // (hashmap)
            $row = mysqli_fetch_assoc($result);
            $email = $row["email"];

            // Show reset password form
            // we have a type='hidden' input to store "global variable" email
            // HTML only want plan text, so need to value="<?php echo $email; .."
            echo 
            '<form method="post" action="">
            <h3>Enter new password for ' . $email . '</h3>
            <input type="password" name="new_password" placeholder="New Password" required><br>
            <input type="hidden" name="email" value="' . $email . '">
            <input type="submit" name="submit" value="Reset Password">
            </form>';
        }
        else{
            echo 'Invalid token..';
        }
    }
    else{
        echo "<p>Invalid token.</p>";
        exit();
    }

    if(isset($_POST['new_password']) && !empty($_POST['new_password'])){
        $new_password = stripslashes($_POST['new_password']);
        $new_password = mysqli_real_escape_string($connection, $new_password);
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($connection, $email);

        // Update password in user table
        $query = 
        "UPDATE `user`
        SET password = '" . md5($new_password) . "' 
        WHERE email = '$email'; ";
        
        $result = mysqli_query($connection, $query);

        if($result){
            echo "<p>Password reset successfully.</p>";

            // Delete the token from password_resets table
            $query = 
            "DELETE FROM `password_resets` 
            WHERE email = '$email'; ";
            mysqli_query($connection, $query);

            Header('Location: ../login.php?reset_success=1');
            exit();
        }
        else{
            echo "<p>Failed to reset password. Please try again.</p>";
        }
    }
    ?>
</body>
</html>