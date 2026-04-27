<?php
include("../auth.php");
require('../database.php');

// We got this from GET actually
$id=$_REQUEST['id'];
$query = "SELECT * FROM products where id='".$id."'";
$result = mysqli_query($connection, $query) or die ( mysqli_error($connection));
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>
<body>
    <p><a href="dashboard.php">User Dashboard</a>
    | <a href="view.php">View Product Records</a>
    | <a href="logout.php">Logout</a></p>

    <h2>Update Product</h2>

    <?php
    // check post to see if form is submitted
    // actually better code is : 
    // if $_SERVERT['REQUEST_METHOD'] == 'POST' then do something
    if(isset($_POST["new"]) && $_POST["new"]==1)
    {
        $id=$_REQUEST['id'];
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $date_record = date('Y-m-d H:i:s');
        $submitted_by = $_SESSION['username'];

        $update = "
        UPDATE products SET
        product_name='".$product_name."',
        price='".$price."',
        quantity='".$quantity."',
        date_record='".$date_record."',
        submittedby='".$submitted_by."'
        WHERE id='".$id."'
        ";

        mysqli_query($connection, $update) or die(mysqli_error($connection));
        echo "<p>Product updated successfully.</p>";
        echo "<a href='view.php'>View Product Records</a>";
    }
    else{
        ?>
        <form method="post" action="">
            <!-- This hidden new is just to check if the form is submitted or not -->
            <input type="hidden" name="new" value="1">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <p>
                <label>New Product Name: </label>
                <input type="text" name="product_name" placeholder="Insert New Product Name" required value="<?= $row['product_name']; ?>"/>
            </p>
            <p>
                <label>New Price: </label>
                <input type="text" name="price" placeholder="Insert New Price" required value="<?= $row['price']; ?>"/>
            </p>
            <p>
                <label>New Quantity: </label>
                <input type="text" name="quantity" placeholder="Insert New Quantity" required value="<?= $row['quantity']; ?>"/>
            </p>
            <p>
                <input type="submit" value="Update Product">
            </p>
        </form>
        <?php
    }
    ?>
</body>
</html>