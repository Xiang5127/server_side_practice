<?php
require('auth.php');
require('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>

    <!--- PHP code to handle file upload and deletion --->
    <?php

    $allowed_type = [".jpg", ".jpeg", ".png", ".pdf", ".docx"];

    // Handle file upload
    if(isset($_POST['upload'])){
        // $_FILES is a superglobal var in PHP
        // 2D array, [type file input][keys]
        // $_POST only knows how to hold text strings.
        // $_FILES is the only array that holds the multi-dimensional metadata
        // we can have: 
        // $_FILES['file']['name'] - original name of the file
        // $_FILES['file']['tmp_name'] - the temporary path of the file in the server
        // $_FILES['file']['size'] - the size of the file in bytes
        // $_FILES['file']['error'] - any error code during upload
        $file = $_FILES['file'];
        
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if(in_array($file_extension, $allowed_type)){
            echo "<p>File type not allowed.</p>";
            exit();
        }

        // the destination actual folder path 
        // to store the file
        $directory = "uploads/" . $file['name'];

        if (move_uploaded_file($file['tmp_name'], $directory)){
            // now insert into database
            $safe_filename = mysqli_real_escape_string($connection, $file['name']);
            $safe_user_input = mysqli_real_escape_string($connection, $_POST['user_input']);

            $query = 
            "INSERT INTO `files` (filename, user_input)
            VALUES ('$safe_filename', '$safe_user_input');";

            mysqli_query($connection, $query) or die(mysqli_error($connection));
        }
    }

    // Handle file reupload (update)
    if(isset($_POST["update"])){
        // we are going to check if user do 
        // 1) File re-upload
        // 2) User input update

        $file_id = $_POST['file_id'];
        $userInput = $_POST["user_input"];
        
        // Remember, when the form has enctype="multipart/form-data", 
        // the file input will be in $_FILES, not $_POST
        if($_FILES['new_file']['size'] > 0){
            $new_file_name = $_FILES['new_file']['name'];
            $new_file_tmp_name = $_FILES['new_file']['tmp_name'];
            $new_directory = "uploads/" . $new_file_name;

            if(move_uploaded_file($new_file_tmp_name, $new_directory)){
                // we also need to delete the old file in uploads folder
                $query1 =
                "SELECT * FROM files
                WHERE id = '$file_id';";

                if(mysqli_num_rows(mysqli_query($connection, $query1)) == 0){
                    echo "<p>File not found.</p>";
                    exit();
                }

                $row = mysqli_fetch_assoc(mysqli_query($connection, $query1));
                $old_filename = $row['filename'];
                $old_file_path = "uploads/" . $old_filename;
                if(file_exists($old_file_path)){
                    unlink($old_file_path);
                }

                // update database with new filename and user input
                $safe_new_filename = mysqli_real_escape_string($connection, $new_file_name);
                $safe_user_input = mysqli_real_escape_string($connection, $userInput);

                $update_query = 
                "UPDATE files SET 
                filename = '$safe_new_filename', 
                user_input = '$safe_user_input'
                WHERE id = '$file_id';";

                mysqli_query($connection, $update_query) or die(mysqli_error($connection));
            }
        }
    }

    // Handle file deletion
    // We delete it via id, not filename
    if(isset($_GET['delete'])){
        $file_id = mysqli_real_escape_string($connection, $_GET['delete']);
        
        $query1 =
        "SELECT * FROM files
        WHERE id = '$file_id';";

        if(mysqli_num_rows(mysqli_query($connection, $query1)) == 0){
            echo "<p>File not found.</p>";
            exit();
        }

        $row = mysqli_fetch_assoc(mysqli_query($connection, $query1));
        $filename = $row['filename'];

        // We also need to delete the actual file in uploads folder
        $file_path = "uploads/" . $filename;
        if(file_exists($file_path)){
            unlink($file_path);
        }

        $deletequery = 
        "DELETE FROM files
        WHERE id = '$file_id';";

        mysqli_query($connection, $deletequery);
        header("Location: file_manager.php");
        exit();
    }
    ?>

    <p><a href="dashboard.php">User Dashboard</a>
    | <a href="crud/view.php">View Product Records</a>
    | <a href="logout.php">Logout</a></p>

    <h2>Upload Your Files</h2>

    <!--- Form to upload file --->
    <form enctype="multipart/form-data" method="post" action="">
        <input type="text" name="user_input" placeholder="Add comment or notes" required><br><br>
        <input type="file" name="file" required><br><br>
        <input type="submit" name="upload" value="Upload File">
    </form>

    <br>
    <h3>Uploaded Files</h3>

    <?php
    // Display all uploaded files
    $query = "SELECT * FROM files;";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            ?>

            <!--- Show the file and user input --->
            <form enctype="multipart/form-data" action="" method="post">
                <li>
                    <?= $row['filename'] ?>
                    -
                    <input type="file" name="new_file"><br>
                    <input type="hidden" name="file_id" value="<?=$row['id']?>">
                    <label for="user_input"> - User Input: </label>
                    <input name="user_input" value="<?=$row['user_input']?>"/>
                    -
                    <a href="uploads/<?=$row['filename']?>">View</a>
                    |
                    <a href="file_manager.php?delete=<?=$row['id']?>" onclick="return confirm('Are you sure?')">Delete</a>
                    |
                    <input type="submit" name="update" value="Update">
                </li>
            </form>

            <?php
        }
    }
    ?>

    
    
</body>
</html>