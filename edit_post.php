<?php

  // Starting session and calling the file "db.php" which contains our connection to the databas: 
  // $db = mysqli_connect("localhost", "root", "", "blog");
  session_start();
  include_once("db.php");

  // Check if a session exits with a username and if not redirecting to the login.php page to login
  if(!isset($_SESSION['username'])) {
    header("location: login.php");
    return;
  }

  // GET the username 'pid' for the edditing; if there is, continue down the page
  if(!isset($_GET['pid'])) {
    header("location: index.php");
  }

  // Set the variable $PID and pass it the value of the existing 'pid' on the database.
  $pid = $_GET['pid'];

  if(isset($_POST['update'])) {
          
    // SQL injection prevention methods: strip_tags and mysqli_real_escape_string.
    $title = strip_tags($_POST['title']);
    $content = strip_tags($_POST['content']);

    $title = mysqli_real_escape_string($db, $title);
    $content = mysqli_real_escape_string($db, $content);

    // Formatting the post date output - Prints the day, date, month, year, time, AM or PM.
    $date = date('l jS \of F Y h:i:s A');

    // Setup the sql query using UPDATE and SET to make the changes on the database.
    $sql = "UPDATE posts SET title='$title', content='$content', date='$date' WHERE id=$pid";

    // Conditional to check if title OR content exists; if not, send message response to complete post
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
      // Setup the sql query SELECTING from the table posts by the id and limiting the selection to just one
      $sql_get = "SELECT * FROM posts WHERE id=$pid LIMIT 1";

      // Set the 'res' (result variable) to assign it the results from the query.
      $res = mysqli_query($db, $sql_get);

      // Conditional to check the database for a row with the id value and when finds it echos the row post information out to the edit_post.php page for editing
      if(mysqli_num_rows($res) > 0) {
          // The mysqli_fetch_assoc() function fetches a result row as an associative array.
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