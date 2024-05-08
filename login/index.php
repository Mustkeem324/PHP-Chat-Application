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
    <title>Chat - Log In</title>
    <link rel="stylesheet" href="/css/login.css" />
    <link rel="stylesheet" href="/css/global.css" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

  </head>
  <body>

    <div id="login-container">
      <h1>Welcome Back!</h1>
      <form action="/backend/login.php" method="post" autocomplete="off">
        <input type="text" name="username" placeholder="Username" autocomplete="off">
        <input type="password" name="password" placeholder="Password" autocomplete="off">
        <input type="submit" value="Login">
      </form>
      <div id="other-login">
        Don't have an account? <a href="/signup">Sign up</a>
      </div>
    </div>

  </body>
</html>