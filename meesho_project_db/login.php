<?php
session_start();
$conn=mysqli_connect("localhost","root","","meesho-project");

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");
    if(mysqli_num_rows($check)>0){
        $user=mysqli_fetch_assoc($check);
        $_SESSION['user_id']=$user['user_id'];
        $_SESSION['user_name']=$user['full_name'];
        header("Location: index.php");
        exit();
    } else {
        $error="Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{font-family:Arial;background:linear-gradient(135deg,#ff3f6c,#ff9f00);display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}
.box{background:white;padding:30px;border-radius:12px;width:350px;box-shadow:0 10px 25px rgba(0,0,0,0.2);}
h2{text-align:center;color:#ff3f6c;}
input{width:100%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:6px;}
button{width:100%;padding:12px;background:#ff3f6c;color:white;border:none;border-radius:6px;font-size:16px;cursor:pointer;}
button:hover{background:#e6335f;}
.error{color:red;text-align:center;}
a{text-decoration:none;color:#ff3f6c;font-weight:bold;}
</style>
</head>
<body>
<div class="box">
<h2>Login</h2>
<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
<form method="POST">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
<p align="center"><a href="signup.php">Create Account</a></p>
</div>
</body>
</html>