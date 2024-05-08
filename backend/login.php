<?php
session_start();

function redir($url) {
  header("Location: $url");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  echo "Method not allowed";
  redir("/login");
}
if (isset($_SESSION["username"])) {
  redir("/");
}
if (!(isset($_POST["username"]) && isset($_POST["password"]))) {
  redir("/login");
}

$username = $_POST["username"];
$password = $_POST["password"];
$passwords = json_decode(file_get_contents("../data/passwords.json"), true);

if (password_verify($password, $passwords[$username])) {
  $_SESSION["username"] = $username;
  redir("/");
} else {
  echo "Username or password is incorrect. If you do not already have an account, please signup.";
}
?>