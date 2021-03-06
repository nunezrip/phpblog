<?php

  // Satrting session and calling the file "db.php" which contains our connection to the databas: 
  // $db = mysqli_connect("localhost", "root", "", "blog");
  session_start();

  // 3x SQL injection prevention methods: strip_tags, stripslashes, and mysqli_real_escape_string
  if(isset($_POST['login'])) {
    include_once("db.php");
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $username = stripslashes($username);
    $password = stripslashes($password);

    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);

    // One additional security layer: cinverting the password into md5 encrypted password
    $password = md5($password);

    // $sql = "SELECT * FROM ussers WHERE username = '$username'". This code on sql is how hackers can do "sql injection" using comment hashes "// DROP TABLE users" to get a copy of the table "users".
  
    // SQL Databasse query LIMITING the query to just one
    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    // Set the query variable passing the sql database
    $query = mysqli_query($db, $sql);
   
    // Fetch the user_id from the table row and assign it to the variable $id
    $row = mysqli_fetch_array($query);
    $id = $row['id'];
  
    //Grab the password from the row and assign it to the variable $db_password
    $db_password = $row['password'];

    //Grab the admin from the row and assign it to the variable $admin
    $admin = $row['admin'];

    // Conditional statement to check if the password entered matches the one in the database
    if($password == $db_password) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        if($admin == 1) {
            $_SESSION['admin'] = 1;
        }
        // Redirect to page index.php
        header("location: index.php");

    } else {
        echo "<a class='back-link' href='login.php'>BACK</a>";  
        echo "...Incorrect username or password!";
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Blog Login</title>
  <link href='Style/login.css' type='text/css' rel='stylesheet'>

</head>
<body>
    <div class="heading">
<img src="img/login5.png" alt="login-btn" >
</div>

    <form action="login.php" method="post" enctype="multipart/form-data">
        <input placeholder="Username" name="username" type="text" autofocus>
        <input placeholder="Password" name="password" type="password">
        <input name="login" type="submit" value="Login">
    </form>

</body>
</html>