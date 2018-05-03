<?php

  // Satrting session and calling the file "db.php" which contains our connection to the databas: 
  // $db = mysqli_connect("localhost", "root", "", "blog");
  session_start();
  include_once("db.php");

  // Check if a session exits with a username at login.php
  if(!isset($_SESSION['username'])) {
    header("location: login.php");
    return;
  }

  // Conditionalusing the isset () function to check whether a variable is set or not. If a variable is already unset with unset() function, it will no longer be set. The isset() function return false if testing variable contains a NULL value. Return value: The return value is TRUE if variable (variable1,variable2..) exists and has value not equal to NULL, FALSE otherwise.Value Type: Boolean.

  if(isset($_POST['post'])) {
      // SQL injection prevention methods: strip_tags and mysqli_real_escape_string
      $title = strip_tags($_POST['title']);
      $content = strip_tags($_POST['content']);

      $title = mysqli_real_escape_string($db, $title);
      $content = mysqli_real_escape_string($db, $content);

      // Formatting the post date output - Prints the day, date, month, year, time, AM or PM
      $date = date('l jS \of F Y h:i:s A');

      // Prepare the SQL Statement ($sql) to store the post data into the database
      $sql = "INSERT into posts (title, content, date) VALUES ('$title', '$content', '$date')";

      // Conditional to check if title OR content exists; if not, send message response to complete post
      if($title == "" || $content == "") {
          echo "Please complete your post!";
          return;
      }

      // If either condition above is true, pass the input data into the database
      mysqli_query($db, $sql);

      // Make header to riderect traffic to the index.php file when done with the post or posts
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

  <!-- Form that displays and contains the title of the post, a text area for the post content and a submit POST button to submit the form with the post data bak to the post.php page -->
  <form action="post.php" method="post" enctype="multipart/form-data">
      <input placeholder="Title" name="title" type="text" autofocus size="48"><br /><br />
      <textarea placeholder="Content" name="content" rows="20" cols="50"></textarea><br />
      <input name="post" type="submit" value="Post">
  </form>

</body>
</html>