var curMessages = [];

function sendMessage(message) {
  if (message == "") {
    return;
  }
  const url = '/backend/send_message.php';
  const data = new URLSearchParams();
  const hash = window.crypto.randomUUID();
  data.append('message', message);
  data.append("hash", hash)
  
  const options = {
    method: 'POST',
    body: data
  };

  fetch(url, options)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.text();
    })
    .then(data => {
    })
    .catch(error => {
      console.error('There was a problem with the fetch operation:', error);
  });
}

function renderMessages(messages) {
  let chatContainer = $("#chat-container").get(0);
  const scrolledToBottom = chatContainer.scrollHeight - chatContainer.clientHeight <= chatContainer.scrollTop + 1;
  chatContainer.innerHTML = "";
  let prevSender = null;
  messages.forEach(message => {
    let messageElement = document.createElement("div");
    let messageUsername = document.createElement("div");
    let messageContent = document.createElement("div");
    let messagePfp = document.createElement("img");
    messageElement.classList.add("message");
    messageUsername.classList.add("message-username");
    messageContent.classList.add("message-content");
    messagePfp.classList.add("message-pfp");
    messageContent.innerText = message.message;
    messageUsername.innerText = message.username;
    messagePfp.src = "/data/users/" + message.username + "/pfp.png";
    let messageTopContainer = document.createElement("div");
    messageTopContainer.classList.add("message-top-container");
    messageTopContainer.appendChild(messagePfp);
    messageTopContainer.appendChild(messageUsername);
    if (prevSender != message.username) {
      messageElement.appendChild(messageTopContainer);
      prevSender = message.username;
    }
    messageElement.appendChild(messageContent);
    chatContainer.appendChild(messageElement)
  });
  if (scrolledToBottom) {
    chatContainer.scrollTop = chatContainer.scrollHeight;
  }
}

async function fetchAndDisplayMessages() {
    const url = "data/chat.json";
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (!curMessages || JSON.stringify(data) !== JSON.stringify(curMessages)) {
                curMessages = data;
                renderMessages(data);
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}


function deleteMessage(messageHash) {
  const url = '/backend/delete_message.php';
  const data = new URLSearchParams();
  data.append('hash', messageHash);
  const options = {
    method: 'POST',
    body: data
  };

  fetch(url, options)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.text();
    })
    .then(data => {
    })
    .catch(error => {
      console.error('There was a problem with the fetch operation:', error);
  });
}


$(document).ready(() => {
  let chatContainer = $("#chat-container");
  let scrollElement = $("#scroll-to-bottom-elem");
  scrollElement.get(0).addEventListener("click", () => {
    chatContainer.get(0).scrollTop = chatContainer.get(0).scrollHeight;
  })
  $("#message-input").on("keydown", (e) => {
    if (e.code == "Enter") {
      sendMessage($("#message-input").val());
      $("#message-input").val("");
    }
  });
  chatContainer.scroll(() => {
    const scrolledToBottom = chatContainer.get(0).scrollHeight - chatContainer.get(0).clientHeight <= chatContainer.get(0).scrollTop + 20;
    if (scrolledToBottom) {
      scrollElement.css("bottom", "24px");
    } else {
      scrollElement.css("bottom", "96px");
    }
  });

  setInterval(fetchAndDisplayMessages, 100);
});

