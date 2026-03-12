<?php
session_start();
$conn=mysqli_connect("localhost","root","","meesho-project");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id=$_SESSION['user_id'];
$orders=mysqli_query($conn,"SELECT * FROM orders WHERE user_id=$user_id ORDER BY order_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<style>
body{font-family:Arial;background:#f5f5f5;margin:0;padding:20px;}
h2{text-align:center;color:#ff3f6c;}
.order{background:white;padding:20px;margin:20px auto;width:70%;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);}
.order h3{margin:0;color:#333;}
.item{margin-left:20px;color:#555;}
a{display:block;text-align:center;margin-top:20px;color:#ff3f6c;font-weight:bold;text-decoration:none;}
</style>
</head>
<body>

<h2>My Orders</h2>

<?php
while($order=mysqli_fetch_assoc($orders)){
    echo "<div class='order'>";
    echo "<h3>Order ID: ".$order['order_id']."</h3>";
    echo "<p>Date: ".$order['order_date']."</p>";
    echo "<p><strong>Total: ₹".$order['total_amount']."</strong></p>";

    $items=mysqli_query($conn,"
    SELECT p.product_name,oi.quantity,oi.price
    FROM order_items oi
    JOIN products p ON oi.product_id=p.product_id
    WHERE oi.order_id=".$order['order_id']
    );

    while($item=mysqli_fetch_assoc($items)){
        echo "<p class='item'>".$item['product_name']." | Qty: ".$item['quantity']." | ₹".$item['price']."</p>";
    }

    echo "</div>";
}
?>

<a href="index.php">← Back to Home</a>

</body>
</html>