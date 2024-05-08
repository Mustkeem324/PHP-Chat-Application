<?php
session_start();

function redir($url) {
  header("Location: $url");
  exit();
}

if (isset($_SESSION["username"])) {
  redir("/");
}
?>
<html>
  <head>
    <title>Chat - Sign Up</title>
    <link rel="stylesheet" href="/css/login.css" />
    <link rel="stylesheet" href="/css/global.css" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

  </head>
  <body>

    <div id="login-container">
      <h1>Welcome to Chat!</h1>
      <form action="/backend/signup.php" method="post" autocomplete="off">
        <input type="text" name="username" placeholder="Username" autocomplete="off">
        <input type="password" name="password" placeholder="Password" autocomplete="off">
        <input type="password" name="confirm_password" placeholder="Confirm Password" autocomplete="off">
        <input type="submit" value="Sign Up">
      </form>
      <div id="other-login">
        Already have an account? <a href="/login">Log In</a>
      </div>
    </div>

  </body>
</html>