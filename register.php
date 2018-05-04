<?php

    if(isset($_SESSION['id'])) {
        header("location: index.php");
    }

    if(isset($_POST['register'])) {
      include_once("db.php");

      $username = strip_tags($_POST['username']);
      $password = strip_tags($_POST['password']);
      $password_confirm = strip_tags($_POST['password_confirm']);
      $email = strip_tags($_POST['email']);
  
      $username = stripslashes($username);
      $password = stripslashes($password);
      $password_confirm = stripslashes($password_confirm);
      $email = stripslashes($email);
  
      $username = mysqli_real_escape_string($db, $username);
      $password = mysqli_real_escape_string($db, $password);
      $password_confirm = mysqli_real_escape_string($db, $password_confirm);
      $email = mysqli_real_escape_string($db, $email);

      $password = md5($password);
      $password_confirm = md5($password_confirm);

      // Inserting username, password, email into the database
      $sql_store = "INSERT into users(username, password, email) VALUES ('$username', '$password', '$email')";

      // Checking and comparing entered username and email with the database holdings/records
      $sql_fetch_username = "SELECT username FROM users WHERE username = '$username'";
      $sql_fetch_email = "SELECT email FROM users WHERE email = '$email'";


      $query_username = mysqli_query($db, $sql_fetch_username);
      $query_email = mysqli_query($db, $sql_fetch_email);

      // Error handling-Checking if username, password and email are in the database
      if(mysqli_num_rows($query_username)) {
        echo "There is already a user with that name!";
        echo "<a class='back-link' href='register.php'>BACK</a>";
        return;
      } 

      if($username == "") {
        echo "Please enter a username!";
        echo "<a class='back-link' href='register.php'>BACK</a>";
        return;
      }

      if($password == ""  ||  $password_confirm == "") {
        echo "Please enter your password";
        echo "<a class='back-link' href='register.php'>BACK</a>";
        return;
      }

      if($password != $password_confirm) {
        echo "The passwords do not match!";
        echo "<a class='back-link' href='register.php'>BACK</a>";  
        return;
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "") {
        echo "This email is not valid!";
        echo "<a class='back-link' href='register.php'>BACK</a>";  
        return;
      }

      if(mysqli_num_rows($query_email)) {
        echo "That email is already in use!";
        echo "<a class='back-link' href='register.php'>BACK</a>";  
        return;
      } 

      mysqli_query($db, $sql_store);

      header("location: index.php");

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>
  <link href='style.css' type='text/css' rel='stylesheet'>
</head>
<body>

<div class='heading'>
  <h1 class='headline'>Hi there! Welcome to myBlog!</h1>
    <h2>If you are a new user; please register; otherwise LOGIN below:</h2>
    <!-- <h1 style="font-family: Tahoma;">Login</h1> -->
    <div class="login-form">
    <form action="login.php" method="post" enctype="multipart/form-data">
        <input placeholder="Username" name="username" type="text" autofocus>
        <input placeholder="Password" name="password" type="password">
        <input name="login" type="submit" value="Login">
    </form>
    
    </div>
  </div>


  <div class='reg-form'
  <form class='registration-form' action="register.php" method="post" enctype="multipart/form-data">
      <input placeholder="Username" name="username" type="text" autofocus>
      <input placeholder="Password" name="password" type="password">
      <input placeholder="Confirm Password" name="password_confirm" type="password">
      <input placeholder="E-mail Address" name="email" type="text">
      <input class='reg-btn' name="register" type="submit" value="Register">
  </form>
  </div>
  <img class="blg" src="./img/blg.png" alt="">
</body>
</html>