<?php
session_start();

function redir($url) {
  header("Location: $url");
  exit();
}

if (!isset($_SESSION["username"])) {
  redir("/login");
}
?>

<html>
  <head>
    <title>Chat</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/global.css" />
    <link rel="stylesheet" href="/css/chat.css" />
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  </head>
  <body>
  

  <div id="chat-container"></div>
  <img src="/assets/images/waves.svg" id="waves" />

  <div id="scroll-to-bottom-elem" class="box"><img src="/assets/images/icons/arrow-down.svg" /></div>
  
    <div id="message-input-container">
      <input id="message-input" />

    </div>

  
    
<script src="/js/chat.js"></script>
    <script>const username = `<?php echo $_SESSION["username"]?>`;</script>
  </body>
</html>