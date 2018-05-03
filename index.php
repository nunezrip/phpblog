<?php

    if(isset($_SESSION['id'])) {
        header("location: view_post.php");
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


      $query_username = mysqli_query($db, $sql, $sql_fetch_username);
      $query_email = mysqli_query($db, $sql, $sql_fetch_email);

      // Error handling-Checking if username, password and email are in the database
      if(mysqli_num_rows($query_username)) {
          echo "There is already a user with that name!";
          return;
      } 

      if($username == "") {
          echo "Please enter a username!";
          return;
      }

      if($password == ""  ||  $password_confirm == "") {
          echo "Please enter your password";
          return;
      }

      if($password != $password_confirm) {
          echo "The passwords do not match!";
          return;
      }

      if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "") {
          echo "This email is not valid!";
          return;
      }

      if(mysqli_num_rows($query_email)) {
          echo "That email is already in use!";
          return;
      } 

      mysqli_query($db, $sql_store);

      header("location: view_post.php");

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


  <form class='registration-form' action="index.php" method="post" enctype="multipart/form-data">
      <input placeholder="Username" name="username" type="text" autofocus>
      <input placeholder="Password" name="password" type="password">
      <input placeholder="Confirm Password" name="password_confirm" type="password">
      <input placeholder="E-mail Address" name="email" type="text">
      <button>register</button>
  </form>


  
</body>
</html>