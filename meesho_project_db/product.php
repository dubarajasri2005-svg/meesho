<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "meesho-project");

$id = $_GET['id'];

if(isset($_POST['add_to_cart'])){
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }
    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += 1;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
    header("Location: cart.php");
    exit();
}

if(isset($_POST['buy_now'])){
    $_SESSION['cart'] = [];
    $_SESSION['cart'][$id] = 1;
    header("Location: checkout.php");
    exit();
}

$query = mysqli_query($conn,"
    SELECT p.*, c.category_name
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.product_id = $id
");

$product = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $product['product_name']; ?></title>
<style>
body{font-family:Arial;background:#f5f5f5;margin:0;}
.container{max-width:600px;margin:40px auto;background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
.image{text-align:center;}
.image img{width:300px;height:300px;object-fit:cover;}
.price{color:green;font-size:22px;font-weight:bold;}
.rating{color:gold;font-size:18px;margin:5px 0;}
button{width:100%;padding:12px;margin-top:10px;border:none;cursor:pointer;font-size:16px;border-radius:5px;}
.add{background:orange;}
.buy{background:green;color:white;}
.back{display:block;margin-top:15px;text-align:center;text-decoration:none;color:#ff3f6c;font-weight:bold;}
.review-box{margin-top:20px;padding:15px;background:#fafafa;border-radius:8px;}
</style>
</head>
<body>

<div class="container">

<div class="image">
<img src="/meesho_project_db/images/<?php echo $product['image']; ?>">
</div>

<h2><?php echo $product['product_name']; ?></h2>
<p><?php echo $product['description']; ?></p>
<p>Category: <?php echo $product['category_name']; ?></p>
<p class="price">₹<?php echo $product['price']; ?></p>

<div class="rating">
<?php
for($i=1;$i<=5;$i++){
    if($i <= $product['rating']){
        echo "★";
    } else {
        echo "☆";
    }
}
?>
</div>

<p>Stock: <?php echo $product['stock']; ?></p>

<form method="POST">
<button type="submit" name="add_to_cart" class="add">Add to Cart</button>
</form>

<form method="POST">
<button type="submit" name="buy_now" class="buy">Buy Now</button>
</form>

<a href="index.php" class="back">← Back to Home</a>

<div class="review-box">
<h3>Customer Reviews</h3>

<?php
$reviews = mysqli_query($conn,"SELECT * FROM reviews WHERE product_id = $id");

if(mysqli_num_rows($reviews) > 0){
    while($rev = mysqli_fetch_assoc($reviews)){
        echo "<p><strong>".$rev['user_name']."</strong>: ".$rev['comment']."</p>";
    }
}else{
    echo "<p>No reviews yet.</p>";
}
?>

</div>

</div>

</body>
</html>