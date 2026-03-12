<?php
session_start();
$conn = mysqli_connect("localhost","root","","meesho-project");

if(isset($_POST['signup'])){
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    mysqli_query($conn,"INSERT INTO users(full_name,email,password,phone,address)
    VALUES('$full_name','$email','$password','$phone','$address')");

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Signup</title>
<style>
body{
    font-family:Arial;
    background:linear-gradient(135deg,#ff3f6c,#ff9f00);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}
.box{
    background:white;
    padding:30px;
    border-radius:12px;
    width:350px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}
h2{
    text-align:center;
    color:#ff3f6c;
}
input,textarea{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:6px;
}
button{
    width:100%;
    padding:12px;
    background:#ff3f6c;
    color:white;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
}
button:hover{
    background:#e6335f;
}
a{
    text-decoration:none;
    color:#ff3f6c;
    font-weight:bold;
}
</style>
</head>
<body>

<div class="box">
<h2>Create Account</h2>

<form method="POST">
<input type="text" name="full_name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<input type="text" name="phone" placeholder="Phone">
<textarea name="address" placeholder="Address"></textarea>
<button name="signup">Signup</button>
</form>

<p align="center">
<a href="login.php">Already have account? Login</a>
</p>

</div>

</body>
</html>