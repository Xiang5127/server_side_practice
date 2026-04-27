<?php
require('../database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>

    <p>
        So basically, the reset password button sends a link with the token attached in the url to the entered mail address. 
        <br>If it is the real user with the mail, they can access this inbox.
        <br>After retrieving, perhaps via a URL link. The link is clicked ->
        <br>The PHP immediately looks at the token in URL and grabs it (using $_GET) -> 
        <br>Then it checks if the token is valid by looking at the database ->
        <br>If valid, it shows the reset password form. (then it is $_POST time)
        <br>If not, it shows an error message.
    </p>

    <?php
    // check if email is submitted
    if(isset($_POST['email'])){
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($connection, $email);

        // check if email exists in database
        $query =
        "SELECT * FROM `user` 
        WHERE email = '$email'; ";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){
            // email found, generate reset token and send email

            $token = bin2hex(random_bytes(50));

            $query = 
            "INSERT INTO `password_resets` (email, token)
            VALUES ('$email', '$token')";

            $result = mysqli_query($connection, $query);

            if($result){
                echo "<p>A password reset link has been sent to your email.</p>";
                echo "<p>Mock Link is here: <a href='reset_form.php?token=$token'>Reset Password</a></p>";
            }else{
                echo "<p>Failed to generate reset token. Please try again.</p>";
            }
        }
        else{
            echo "<p>Email not found.</p>";
        }

        exit();
    }
    ?>

    <h2>Forgot Password</h2>
    <p>Enter your email to reset your password.</p>
    <form action="" method="post">
        <label>Email: </label>
        <input type="email" name="email" required><br>
        <br>
        <input type="submit" name='submit' value="Reset Password">
    </form>
</body>
</html>