<?php

session_start();

// If seesion is not set redirect to the login.php page
if(!isset($_SESSION['id'])) {
    header("location: login.php");
}

include_once("db.php");

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
      require_once("nbbc/nbbc.php");

      $bbcode = new BBCode;

      $sql = "SELECT * FROM posts ORDER BY id DESC";

      $res = mysqli_query ($db, $sql) or die(mysqli_error());

      $posts = "";

      if(mysqli_num_rows($res) > 0) {
          while($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $title = $row['title'];
            $content = $row['content'];
            $date = $row['date'];

            $admin = "<div><a href='del_post.php?pid=$id'>DELETE</a>&nbsp;<a href='edit_post.php?pid=$id'>EDIT</a></div>";

            $output = $bbcode->Parse($content);

            $posts .= "<div><h2><a href='view_post.php?pid=$id'>$title</a></h2><h3>$date</h3><p>$output</p>$admin</div>";
          }
          echo $posts;
      } else {
          echo "There are no posts to display!";
      }

  ?>

        <!-- Link to redirect to the post.php page if there are no post  -->
        <a href='post.php' target='_blank'>POST</a>; 

</body>
</html>