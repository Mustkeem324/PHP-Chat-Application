<?php
session_start();

function redir($url) {
  header("Location: $url");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  redir("/login");
}
if (isset($_SESSION["username"])) {
  redir("/");
}
if (!(isset($_POST["username"]) && isset($_POST["password"]))) {
  redir("/signup");
}

$username = $_POST["username"];
$password = $_POST["password"];
$password_confirm = $_POST["confirm_password"];
$passwords = json_decode(file_get_contents("../data/passwords.json"), true);

if (isset($passwords[$username])) {
  redir("/signup");
  echo "An account with this username already exists. Contact admins if you think this is a mistake.";
}
if ($password != $password_confirm) {
  redir("/signup");
  echo "Passwords do not match";
}

$passwords[$username] = password_hash($password, PASSWORD_DEFAULT);

file_put_contents("../data/passwords.json", json_encode($passwords, JSON_PRETTY_PRINT));

$_SESSION["username"] = $username;

redir("/");
exit()
?>