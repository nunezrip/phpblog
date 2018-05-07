<?php
// Starting session - Session variables hold information about one single user, and are available to all pages in one application.
session_start();
include_once("db.php");

// If seesion is not set redirect to the login.php page
if(!isset($_SESSION['id'])) {
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
  <title>Blog View Post</title>
</head>
<body>

  <?php

    require_once("nbbc/nbbc.php");

    $bbcode = new BBCode;

    $pid = isset($_GET['pid']) ? $_GET['id'] : '';;

    $sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";

    $res = mysqli_query($db, $sql);

    if (mysqli_num_rows($res) > 0) {
      while ($row = mysqli_fetch_assoc($res)) {
        
        $id = $row['id'];
        $title = $row['title'];
        $date = $row['date'];
        $content = $row['content'];

        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
          $admin = "<div><A href='del_post.php?pid=$id'>DELETE</a>&nbsp;<a href='edit_post.php?pid=$id'>EDIT</a></div>";
        } else {
            $admin = "";
        }

        $output = $bbcode->Parse($content);

        echo "<div><h2>$title</h2><h3>$date</h3<p>$output</p>$admin<hr /></div";
    }
  } else {
    echo "<a class='back-link' href='view_post.php'>BACK:</a>";
      echo "<p>...There are no posts to display!</p>";
  }

  ?>
  
  <!-- Returns to index.php -->
  <a href="index.php">RETURN</a>;

</body>
</html>