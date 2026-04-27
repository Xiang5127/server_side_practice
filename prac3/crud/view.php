<?php
require('../auth.php');
require('../database.php');

 $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
 $search_min_price = isset($_GET['search_min_price']) ? $_GET['search_min_price'] : null;
 $search_max_price = isset($_GET['search_max_price']) ? $_GET['search_max_price'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
</head>
<body>
    <p><a href="../dashboard.php">User Dashboard</a>
    | <a href="view.php">View Product Records</a>
    | <a href="../logout.php">Logout</a></p>

    <h2>View Products</h2>
    
    <?php
    // $query = 
    // "SELECT * FROM `products`;";

    // $result = mysqli_query($connection, $query);

    // if (mysqli_num_rows($result) > 0) {
    //     while($row = mysqli_fetch_assoc($result)){
    //         // do something with the data
    //         echo "Product Name: " . $row['product_name'] . "<br>";
    //         echo "Price: " . $row['price'] . "<br>";
    //         echo "Quantity: " . $row['quantity'] . "<br>";
    //     }   
    // }
    ?>

    <!--- Search form --->
    <form method="get" action="">
        <input type="text" value="<?=$search_name?>" name="search_name" placeholder="Search by product name">
        <input type="number" value="<?=$search_min_price?>" name="search_min_price" placeholder="Min Price" step="0.01">
        <input type="number" value="<?=$search_max_price?>" name="search_max_price" placeholder="Max Price" step="0.01">
        <input type="submit" value="Search">
        <input type="button" value="Reset" onclick="window.location.href='view.php'">
        <!-- <input type="submit" value="Reset" onclick=()=>{
            clear($search_name);
            clear($search_min_price);
            clear($search_max_price);
            window.location.href = 'view.php';
        }> -->
    </form>

    <table width="100%" border="1" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Date Recorded</th>
                <th>Submitted By</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php

            // Static query: 
            // no search functions
            // $query = 
            // "SELECT * FROM `products`
            // ORDER BY id DESC
            // ;";
            // $result = mysqli_query($connection, $query);

            // Dynamic query with search function:
            $query = "SELECT * FROM `products` WHERE 1=1";

            if (!empty($search_name)) {
                $query .= " AND product_name LIKE '%" . mysqli_real_escape_string($connection, $search_name) . "%'";
            }

            if (!empty($search_min_price)) {
                $query .= " AND price >= " . (float)$search_min_price;
            }

            if (!empty($search_max_price)) {
                $query .= " AND price <= " . (float)$search_max_price;
            }

            $query .= " ORDER BY id DESC;";

            $result = mysqli_query($connection, $query);

            $count = 1;
            $currencySymbol = "RM";

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td align='center'>" . $count . "</td>";
                    echo "<td align='center'>" . $row['product_name'] . "</td>";
                    echo "<td align='center'>" . $currencySymbol . $row['price'] . "</td>";
                    echo "<td align='center'>" . $row['quantity'] . "</td>";
                    echo "<td align='center'>" . $row['date_record'] . "</td>";
                    echo "<td align='center'>" . $row['submittedby'] . "</td>";
                    echo "<td align='center'><a href='update.php?id=" . $row['id'] . "'>Update</a></td>";
                    echo "<td align='center'><a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></td>";
                    echo "</tr>";
                }   
            }
            ?>
        </tbody>
    </table>
</body>
</html>