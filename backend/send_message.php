<?php
session_start();

function redir($url) {
  header("Location: $url");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  echo "Method not allowed";
  redir("/index.php");
}
if (!isset($_SESSION["username"])) {
  echo "You are not logged in. Please log in to send a message.";
  redir("/login/index.php");
}
if (!isset($_POST["message"]) || !isset($_POST["hash"])) {
  echo "Message not found or requires hash";
  redir("/index.php");
}

$chatFilePath = "../data/chat.json";

$message = $_POST["message"];
$username = $_SESSION["username"];
$hash = $_POST["hash"];
$messages = json_decode(file_get_contents($chatFilePath), true);
array_push($messages, array(
  "username" => $username,
  "message" => $message,
  "hash" => $hash
));

file_put_contents($chatFilePath, json_encode($messages, JSON_PRETTY_PRINT));
redir("/index.php");
echo "Message sent";
?>