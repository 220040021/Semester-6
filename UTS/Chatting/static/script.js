const socket = io();
let username = "";

function setUsername() {
    const input = document.getElementById('username');
    if (input.value.trim()) {
        username = input.value.trim();
        document.getElementById('username-container').style.display = 'none';
        document.getElementById('chat-area').style.display = 'block';
    }
}

socket.on('message', function(data) {
    const chatBox = document.getElementById('chat-box');
    const user = data.username || "Anonim";
    const msg = data.message || "";
    chatBox.innerHTML += `<div class="msg"><strong>${user}:</strong> ${msg}</div>`;
    chatBox.scrollTop = chatBox.scrollHeight;
});

socket.on('file_uploaded', function(data) {
    const chatBox = document.getElementById('chat-box');
    chatBox.innerHTML += `<div class="msg"><a href="/uploads/${data.filename}" target="_blank">${data.filename}</a></div>`;
    chatBox.scrollTop = chatBox.scrollHeight;
});

function sendMessage() {
    const msgInput = document.getElementById('message');
    const msg = msgInput.value.trim();
    if (msg) {
        socket.emit('message', { username: username, message: msg });
        msgInput.value = '';
    }
}

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fileInput = document.getElementById('fileInput');
    if (fileInput.files.length > 0) {
        const formData = new FormData();
        formData.append("file", fileInput.files[0]);

        fetch('/upload', {
            method: 'POST',
            body: formData
        });
    }
});
