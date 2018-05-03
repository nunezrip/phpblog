<?php

  // Satrting session and calling the file "db.php" which contains our connection to the databas: 
  // $db = mysqli_connect("localhost", "root", "", "blog");
  session_start();
  include_once("db.php");

   // Check if a session exits with a username and if not redirecting to the login.php page to login
  if(!isset($_SESSION['username'])) {
    header("location: login.php");
    return;
  }

  // Conditional statement to check if a post exists under the userd 'pid' to DELETE from the database; if not redirect to the index.php page
  if(!isset($_GET['pid'])) {
      header("location: index.php");
    // If a post exists DELETE from the sql database: $sql = "DELETE FROM posts WHERE id=$pid";
  } else {
      $pid = $_GET['pid'];
      $sql = "DELETE FROM posts WHERE id=$pid";
      mysqli_query($db, $sql);
      header("location: index.php");
  }

?>