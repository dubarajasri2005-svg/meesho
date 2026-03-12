<?php
session_start();
$conn = mysqli_connect("localhost","root","","meesho-project");

$where = [];

if(isset($_GET['search']) && $_GET['search'] != ""){
    $search = $_GET['search'];
    $where[] = "product_name LIKE '%$search%'";
}

if(isset($_GET['category']) && $_GET['category'] != ""){
    $category = $_GET['category'];
    $where[] = "category_id = $category";
}

$query = "SELECT * FROM products";

if(count($where) > 0){
    $query .= " WHERE " . implode(" AND ", $where);
}

$products = mysqli_query($conn,$query);
$categories = mysqli_query($conn,"SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
<title>Meesho Store</title>

<style>

body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f5f5;
}

.navbar{
    background:#ff3f6c;
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.logo{
    font-size:22px;
    font-weight:bold;
}

.nav-links a{
    color:white;
    text-decoration:none;
    margin-left:18px;
    font-weight:bold;
}

.nav-links a:hover{
    text-decoration:underline;
}

.container{
    padding:25px;
}

.top-controls{
    display:flex;
    justify-content:space-between;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:10px;
}

select,input{
    padding:8px;
    border-radius:6px;
    border:1px solid #ccc;
}

button{
    padding:8px 14px;
    background:#ff3f6c;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

button:hover{
    background:#e6335f;
}

.products{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(230px,1fr));
    gap:20px;
}

.card{
    background:white;
    border-radius:10px;
    padding:15px;
    box-shadow:0 6px 15px rgba(0,0,0,0.1);
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:100%;
    height:200px;
    object-fit:cover;
    border-radius:8px;
}

.price{
    color:green;
    font-weight:bold;
    margin:10px 0;
}

.view-btn{
    display:inline-block;
    padding:8px 12px;
    background:#ff3f6c;
    color:white;
    border-radius:6px;
    text-decoration:none;
}

.no-products{
    text-align:center;
    font-size:18px;
    color:#777;
}

</style>
</head>
<body>

<div class="navbar">
    <div class="logo">Meesho</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="cart.php">Cart</a>

        <?php if(isset($_SESSION['user_id'])){ ?>
            <a href="my_orders.php">My Orders</a>
            <a href="logout.php">Logout (<?php echo $_SESSION['user_name']; ?>)</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        <?php } ?>
    </div>
</div>

<div class="container">

<div class="top-controls">

<form method="GET">
    <select name="category" onchange="this.form.submit()">
        <option value="">All Categories</option>
        <?php while($cat = mysqli_fetch_assoc($categories)){ ?>
            <option value="<?php echo $cat['category_id']; ?>"
            <?php if(isset($_GET['category']) && $_GET['category']==$cat['category_id']) echo "selected"; ?>>
                <?php echo $cat['category_name']; ?>
            </option>
        <?php } ?>
    </select>

    <?php if(isset($_GET['search'])){ ?>
        <input type="hidden" name="search" value="<?php echo $_GET['search']; ?>">
    <?php } ?>
</form>

<form method="GET">
    <input type="text" name="search" placeholder="Search products..."
    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <button>Search</button>

    <?php if(isset($_GET['category'])){ ?>
        <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>">
    <?php } ?>
</form>

</div>

<div class="products">

<?php
if(mysqli_num_rows($products) > 0){
    while($row = mysqli_fetch_assoc($products)){
?>
    <div class="card">
        <img src="images/<?php echo $row['image']; ?>">
        <h4><?php echo $row['product_name']; ?></h4>
        <div class="price">₹<?php echo $row['price']; ?></div>
        <a class="view-btn" href="product.php?id=<?php echo $row['product_id']; ?>">
            View Details
        </a>
    </div>
<?php
    }
} else {
    echo "<div class='no-products'>No products found</div>";
}
?>

</div>

</div>

</body>
</html>