<?php

// Remember, we need auth.php
// in all logged in pages to protect users
require('../auth.php');
require('../database.php');

$status = '';

if (isset($_POST['product_name'])) {
    $product_name = stripslashes($_POST['product_name']);
    $product_name = mysqli_real_escape_string($connection, $product_name);
    
    $price = stripslashes($_POST['price']);
    $product_price = mysqli_real_escape_string($connection, $price);
    
    $product_quantity = stripslashes($_POST['quantity']);
    $product_quantity = mysqli_real_escape_string($connection, $product_quantity);

    $date_record = date('Y-m-d H:i:s');

    $submitted_by = $_SESSION['username'];

    // Insert the new product into the database
    $query = 
    "INSERT INTO `products` (product_name, price, quantity, date_record, submittedby)
    VALUES ('$product_name', '$product_price', '$product_quantity', '$date_record', '$submitted_by');
    ";

    if (mysqli_query($connection, $query)) {
        $status = "Product inserted successfully.";
        $status .= "</br></br><a href='view.php'>View Product Record</a>";
    } else {
        $status = "Error: " . mysqli_error($connection);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert New Product</title>
</head>
<body>
    <p><a href="../dashboard.php">User Dashboard</a>
    | <a href="view.php">View Product Records</a>
    | <a href="../logout.php">Logout</a></p>

    <h2>Insert New Product</h2>
    <form method="post" action="">
        <label>Product Name: </label>
        <input type="text" name="product_name" required><br><br>
        <label>Price: </label>
        <input type="number" step="0.01" name="price" required><br><br>
        <label>Quantity: </label>
        <input type="number" step="1" name="quantity" required><br><br>
        <input type="submit" name="submit" value="Insert">
    </form>

    <!--- Show status message after form submission --->
    <p style="color:#008000;"><?php echo $status; ?></p>
</body>
</html>