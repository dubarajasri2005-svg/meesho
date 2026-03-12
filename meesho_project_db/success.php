<?php
session_start();

if(!isset($_SESSION['last_order_id'])){
    header("Location: index.php");
    exit();
}

$order_id = $_SESSION['last_order_id'];

$delivery_date = date("d M Y", strtotime("+5 days"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}

.box{
    background:white;
    padding:40px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.15);
    text-align:center;
    width:400px;
}

h2{
    color:green;
}

.order-id{
    font-size:18px;
    margin:10px 0;
    font-weight:bold;
}

.delivery{
    color:#555;
    margin:10px 0 20px;
}

a{
    display:inline-block;
    padding:10px 15px;
    margin:5px;
    text-decoration:none;
    border-radius:6px;
    color:white;
}

.home{
    background:#777;
}

.orders{
    background:#ff3f6c;
}

</style>
</head>
<body>

<div class="box">

<h2>🎉 Order Placed Successfully!</h2>

<div class="order-id">
Order ID: #<?php echo $order_id; ?>
</div>

<div class="delivery">
Estimated Delivery Date: <?php echo $delivery_date; ?>
</div>

<a href="index.php" class="home">Go to Home</a>
<a href="my_orders.php" class="orders">View My Orders</a>

</div>

</body>
</html>