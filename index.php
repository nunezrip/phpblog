<?php
// Starting session - Session variables hold information about one single user, and are available to all pages in one application.
session_start();


// If seesion is not set redirect to the login.php page
if(!isset($_SESSION['id'])) {
    header("location: register.php");
    // return;
}

include_once("db.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Blog Index</title>
  <link href='Style/index.css' type='text/css' rel='stylesheet'>

</head>
<body>

    <div class="heading">
    <img src="img/BlogIcon2.png" alt="login-logo" height="70" width="200">
    <h1 class='headline'>Welcome to <i>yourBlog!</i></h1>
    </div>
  <?php

    // Requiring nbbc: NBBC is a high-speed, extensible, easy-to-use validating BBCode parser that accepts BBCode as input and generates XHTML 1.0 Transitional-compliant markup as its output no matter how mangled the input.
        
    require_once("nbbc/nbbc.php");

    // Set new object of BBCode
    $bbcode = new BBCode;

    // Set-up SQL query selecting data from the "blog"csql databse table called "posts" and ordering them in descending order
    $sql = "SELECT * FROM posts ORDER BY id DESC";

    // Set-up the results set to mysqli_query passing the databse($db) which is the connection and the $sql which is the specific query set-up above and the die function if there is an error
    $res = mysqli_query ($db, $sql) or die(mysqli_error());

    $posts = "";

    // Set-up conditional to chech for the data table variables data using the mysqli_num_rows() function which returns the number of rows in a result set and getting the data using the The mysqli_fetch_assoc() function to grab the results of the query ($res) which fetches a result row as an associative array. Syntax: mysqli_fetch_assoc(result).
      if(mysqli_num_rows($res) > 0) {
          while($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $title = $row['title'];
            $content = $row['content'];
            $date = $row['date'];

            $admin = "<div><a href='del_post.php?pid=$id'>DELETE</a>&nbsp<a href='edit_post.php?pid=$id'>EDIT</a></div>";

            // Sending the data to the BBCode parser to remove potential malicious data elements or charcters from the result and assigning the parsed result to the ($output)variable.
            $output = $bbcode->Parse($content);

            // Setting up a $posts variable use to assigne the BBCode-parsed results of the query under $output for viewing/displaying
            $posts .= "<div><h2><a href='view_post.php?pid=$id'>$title</a></h2><h3>$date</h3><p>$output</p>$admin<hr /></div>";
          }
          echo $posts;
      } else {
        echo "<a class='back-link' href='view_post.php'>BACK:</a>";
          echo "...There are no posts to display!";
      }

      if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
          echo "<a href='admin.php'>ADMIN</a> | <a href='home.php'>LOGOUT</a>";
      }

      if(!isset($_SESSION['username'])) {
          echo "<a href='login.php'>LOGIN</a>";
      }

      if(isset($_SESSION['username']) && !isset($_SESSION['admin'])) {
        echo "<a href='home.php'>LOGOUT</a>";
    }
  ?>

</body>
</html>