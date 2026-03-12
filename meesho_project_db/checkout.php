<?php
session_start();
$conn = mysqli_connect("localhost","root","","meesho-project");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn,"SELECT * FROM users WHERE user_id=$user_id");
$user = mysqli_fetch_assoc($user_query);

$total = 0;
foreach($_SESSION['cart'] as $product_id => $qty){
    $res = mysqli_query($conn,"SELECT * FROM products WHERE product_id=$product_id");
    $row = mysqli_fetch_assoc($res);
    $total += $row['price'] * $qty;
}

if(isset($_POST['place_order'])){

    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    $bank_name="";
    $account_number="";
    $ifsc="";
    $payment_status="Pending";

    if($payment_method=="Online"){
        $bank_name=$_POST['bank_name'];
        $account_number=$_POST['account_number'];
        $ifsc=$_POST['ifsc'];
        $payment_status="Paid";
    }

    $estimated_delivery = date('Y-m-d', strtotime('+5 days'));

    mysqli_query($conn,"UPDATE users SET address='$address' WHERE user_id=$user_id");

    mysqli_query($conn,"INSERT INTO orders 
    (user_id,total_amount,order_date,payment_method,payment_status,order_status,estimated_delivery,
    bank_name,account_number,ifsc_code)
    VALUES 
    ($user_id,$total,NOW(),'$payment_method','$payment_status',
    'Pending','$estimated_delivery','$bank_name','$account_number','$ifsc')");

    $order_id = mysqli_insert_id($conn);

    foreach($_SESSION['cart'] as $product_id => $qty){
        $res = mysqli_query($conn,"SELECT * FROM products WHERE product_id=$product_id");
        $row = mysqli_fetch_assoc($res);

        mysqli_query($conn,"INSERT INTO order_items (order_id,product_id,quantity,price)
        VALUES ($order_id,$product_id,$qty,".$row['price'].")");

        $new_stock = $row['stock'] - $qty;
        mysqli_query($conn,"UPDATE products SET stock=$new_stock WHERE product_id=$product_id");
    }

    unset($_SESSION['cart']);
    header("Location: success.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<style>

body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#ff3f6c,#ff8fab);
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.checkout-box{
background:white;
width:900px;
display:flex;
border-radius:20px;
overflow:hidden;
box-shadow:0 20px 40px rgba(0,0,0,0.2);
}

.left{
width:55%;
padding:40px;
}

.right{
width:45%;
background:#fafafa;
padding:40px;
border-left:2px solid #eee;
}

h2{
margin-top:0;
color:#ff3f6c;
}

input,textarea,select{
width:100%;
padding:12px;
margin-top:10px;
border-radius:8px;
border:1px solid #ddd;
font-size:14px;
}

textarea{
resize:none;
height:80px;
}

button{
width:100%;
padding:15px;
background:#ff3f6c;
color:white;
border:none;
border-radius:10px;
font-size:16px;
margin-top:20px;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#e6325c;
transform:scale(1.03);
}

.payment-box{
display:none;
background:#f3f3f3;
padding:15px;
border-radius:10px;
margin-top:15px;
}

.summary-item{
display:flex;
justify-content:space-between;
margin:10px 0;
}

.total{
font-size:20px;
font-weight:bold;
color:#ff3f6c;
}

</style>

<script>
function toggleBank(){
    var method=document.getElementById("payment_method").value;
    var box=document.getElementById("bankDetails");

    if(method=="Online"){
        box.style.display="block";
    }else{
        box.style.display="none";
    }
}
</script>

</head>
<body>

<div class="checkout-box">

<div class="left">

<h2>Checkout</h2>

<form method="POST">

<h4>Delivery Address</h4>
<textarea name="address" required><?php echo $user['address']; ?></textarea>

<h4>Payment Method</h4>
<select name="payment_method" id="payment_method" onchange="toggleBank()" required>
<option value="">Select Payment</option>
<option value="COD">Cash On Delivery</option>
<option value="Online">Online Payment</option>
</select>

<div id="bankDetails" class="payment-box">
<h4>Bank Details</h4>
<input type="text" name="bank_name" placeholder="Bank Name">
<input type="text" name="account_number" placeholder="Account Number">
<input type="text" name="ifsc" placeholder="IFSC Code">
</div>

<button name="place_order">Place Order</button>

</form>

</div>

<div class="right">

<h2>Order Summary</h2>

<?php
foreach($_SESSION['cart'] as $product_id => $qty){
    $res = mysqli_query($conn,"SELECT * FROM products WHERE product_id=$product_id");
    $row = mysqli_fetch_assoc($res);
?>

<div class="summary-item">
<span><?php echo $row['product_name']." (x".$qty.")"; ?></span>
<span>₹<?php echo $row['price']*$qty; ?></span>
</div>

<?php } ?>

<hr>

<div class="summary-item total">
<span>Total</span>
<span>₹<?php echo $total; ?></span>
</div>

</div>

</div>

</body>
</html>