<?php
// Starting session - Session variables hold information about one single user, and are available to all pages in one application.
session_start();
include_once("db.php");

// If seesion is not set redirect to the login.php page
if(!isset($_SESSION['admin']) && $_SESSION['admin'] !=1) {
    header("location: login.php");
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Blog Home</title>
  <link href='Style/home.css' type='text/css' rel='stylesheet'>
</head>
<body>

<div class='heading'>
<img src="img/blog5.png" alt="login-logo" height="200" width="400">

  <h1 class='headline'>Welcome to <i>myBlog!</i></h1>
    <!-- <h2>If you are a new user; please register; otherwise LOGIN below:</h2> -->
    <!-- <h1 style="font-family: Tahoma;">Login</h1> -->
    <div class="welcome-page">

   
    <a href='login.php' target='_blank'><img src="img/login5.png" alt="login-btn" height="100" width="200"></a>
    
  
  <p><strong>OR</strong></p>
 
   <a href='register.php' target='_blank'> <img src="img/register5.png" alt="login-btn" height="80" width="140"></a>
    </div>
  </div>

</body>
</html>


<!-- <div class='heading'> -->
  <!-- <h1 class='headline'>Hi there! Welcome to myBlog!</h1>
    <h2>If you are a new user; please register; otherwise LOGIN below:</h2>
    <!-- <h1 style="font-family: Tahoma;">Login</h1> -->
    <!-- <div class="login-form">
    <form action="login.php" method="post" enctype="multipart/form-data">
        <input placeholder="Username" name="username" type="text" autofocus>
        <input placeholder="Password" name="password" type="password">
        <input name="login" type="submit" value="Login">
    </form>
    
    </div>
  </div> -->

