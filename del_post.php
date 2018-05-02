<?php

  session_start();
  include_once("db.php");

  if(!isset($_SESSION['username'])) {
    header("location: login.php");
    return;
  }

  // Conditional statement to check for the userd_id to DELETE from the database

  if(!isset($_GET['pid'])) {

  } else {
      $pid = $_GET['pid'];
      $sql = "DELETE FROM posts WHERE id=$pid";
      mysqli_query($db, $sql);
      header("location: index.php");
  }

?>