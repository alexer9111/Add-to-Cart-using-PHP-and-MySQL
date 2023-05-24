<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productdb";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    echo "Failed to Connect";
}

if(isset($_GET["action"]) && $_GET["action"] == "delete"){
    $productName = $_GET["name"];
    $deleteQuery = "DELETE FROM `product_second` WHERE description = '$productName'";
    mysqli_query($conn, $deleteQuery);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php"><span>Shop Here</span></a>
        <div>
            <a href="">LogIn</a>
            <a href="cart.php">Cart</a>
        </div>
    </nav>
    <h3>Cart</h3>
    <div class="table_container">
        <table>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Remove Item</th>
            </tr>
            <?php
            $query = "SELECT * FROM `product_second` ORDER BY id ASC";
            $result = mysqli_query($conn, $query);
            $total = 0;
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td><img src="img/<?php echo $row["image"];?>" alt=""></td>
                        <td><?php echo $row["description"];?></td>
                        <td><?php echo $row["price"];?></td>
                        <td><?php echo $row["quantity"];?></td>
                        <td><?php echo number_format($row["quantity"]*$row["price"],2);?></td>
                        <td><a href="cart.php?action=delete&name=<?php echo $row["description"];?>"><span>Remove Item</span></a></td>
                        <?php
                        $total = $total + ($row["quantity"]*$row["price"]);
                    }
                }
                ?>
                </tr>
                <tr></tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td><?php echo number_format($total, 2);?></td>
                    <td><button>Proceed to Payment</button></td>
                </tr>

        </table>
    </div>
    <footer></footer>
</body>
</html>
