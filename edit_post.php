<?php

  session_start();
  include_once("db.php");

  if(!isset($_SESSION['username'])) {
    header("location: login.php");
    return;
  }

  if(!isset($_SESSION['username'])) {
    header("location: login.php");
  }

  $pid = $_GET['pid'];

  if(isset($_POST['update'])) {
      $title = strip_tags($_POST['title']);
      $content = strip_tags($_POST['content']);

      $title = mysqli_real_escape_string($db, $title);
      $content = mysqli_real_escape_string($db, $content);

      $date = date('l jS \of F Y h:i:s A');

      $sql = "UPDATE posts SET title='$title', content='$content', date='$date' WHERE id=$pid";

      if($title == "" || $content == "") {
          echo "Please complete your post!";
          return;
      }

      mysqli_query($db, $sql);

      header("location: index.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Blog - Post</title>
</head>
<body>

  <?php
      $sql_get = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
      $res = mysql_query($db, $sql_get);

      if(mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            $title = $row['title'];
            $content = $row['content'];

            echo "<form action='edit_post.php?pid=$pid' method='post' enctype='multipart/form-data'>";
            echo "<input placeholder='Title' name='title' type='text' value='$title' autofocus size='48'><br /><br />";
            echo "<textarea placeholder='Content' name='content' rows='20' cols='50'>$content</textarea><br />";

          }
      }
  ?>


      <input name="update" type="submit" value="Update">
  </form>

</body>
</html>