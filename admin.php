<?php
// Starting session - Session variables hold information about one single user, and are available to all pages in one application.
session_start();

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
  <title>Blog</title>
</head>
<body>
  
  <?php

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
            $date = $row['date'];

            // Setting up an $admin variabel to assign DELETE and EDIT links for removing or updating existing posts
            $admin = "<div><a href='del_post.php?pid=$id'>DELETE</a>&nbsp;<a href='edit_post.php?pid=$id'>EDIT</a></div>";

            // Setting up a $posts variable use to assigne the BBCode-parsed results of the query under $output for viewing/displaying
            $posts .= "<div><h2><a href='view_post.php?pid=$id' target='_blank'>$title</a></h2><h3>$date</h3$admin<hr /></div>";
          }
          echo $posts;
      } else {
          echo "There are no posts to display!";
      }

  ?>
        <!-- Link to redirect to the post.php page if there are no post  -->
        <a href='post.php' target='_blank'>ADD YOUR POST</a>; 

</body>
</html>