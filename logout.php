<?php

  session_start();

  // Remove all global session variables and destroy the session using session_destroy().
  session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Blog Logout</title>
</head>
<body>
  <meta http-equiv="refresh" content="1; url=login.php" />
</body>
</html>