<?php
session_start();
$conn = mysqli_connect("localhost","root","","meesho-project");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Cart</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    margin:0;
    padding:20px;
}

h2{
    text-align:center;
    color:#ff3f6c;
}

.cart-container{
    max-width:900px;
    margin:20px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 6px 15px rgba(0,0,0,0.1);
}

.cart-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 0;
    border-bottom:1px solid #ddd;
}

.cart-item img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:8px;
}

.item-info{
    flex:1;
    margin-left:15px;
}

.price{
    font-weight:bold;
    color:green;
}

.total{
    text-align:right;
    font-size:18px;
    margin-top:15px;
    font-weight:bold;
}

.buttons{
    margin-top:20px;
    text-align:center;
}

.btn{
    padding:10px 15px;
    text-decoration:none;
    border-radius:6px;
    margin:5px;
    display:inline-block;
    color:white;
}

.home{
    background:#777;
}

.shop{
    background:#ff9f00;
}

.checkout{
    background:#ff3f6c;
}

.empty{
    text-align:center;
    color:#777;
    padding:20px;
}

</style>
</head>
<body>

<h2>My Cart</h2>

<div class="cart-container">

<?php
$total = 0;

if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){

    foreach($_SESSION['cart'] as $product_id => $qty){

        $result = mysqli_query($conn,"SELECT * FROM products WHERE product_id=$product_id");
        $row = mysqli_fetch_assoc($result);

        $subtotal = $row['price'] * $qty;
        $total += $subtotal;
?>

    <div class="cart-item">
        <img src="images/<?php echo $row['image']; ?>">
        <div class="item-info">
            <h4><?php echo $row['product_name']; ?></h4>
            <p>Quantity: <?php echo $qty; ?></p>
        </div>
        <div class="price">₹<?php echo $subtotal; ?></div>
    </div>

<?php
    }
?>

    <div class="total">
        Total: ₹<?php echo $total; ?>
    </div>

    <div class="buttons">
        <a href="index.php" class="btn home">← Back to Home</a>
        <a href="index.php" class="btn shop">Continue Shopping</a>
        <a href="checkout.php" class="btn checkout">Proceed to Checkout →</a>
    </div>

<?php
} else {
    echo "<div class='empty'>Your cart is empty 😔</div>";
?>

    <div class="buttons">
        <a href="index.php" class="btn home">← Back to Home</a>
    </div>

<?php
}
?>

</div>

</body>
</html>