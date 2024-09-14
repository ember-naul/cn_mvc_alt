let conn = new WebSocket('ws://localhost:8080/chat');
const chatBox = document.getElementById('chat-box');
const form = document.getElementById('chat-form');
const messageInput = document.getElementById('message');

// Defina um nome de usuário ou identificador
const username = 'User' + Math.floor(Math.random() * 1000); // Gerar um nome de usuário aleatório para o exemplo

// Receber mensagens do servidor
conn.onmessage = function(e) {
    let message = JSON.parse(e.data); // Parse JSON para obter a mensagem e o remetente
    let messageElement = document.createElement('div');
    messageElement.textContent = `${message.user}: ${message.text}`;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight; // Scroll automático
};

// Enviar mensagens para o servidor
form.addEventListener('submit', function(e) {
    e.preventDefault();
    let message = messageInput.value;
    let outgoingMessage = JSON.stringify({ user: username, text: message });
    conn.send(outgoingMessage);
    
    // Exibir a mensagem localmente
    let messageElement = document.createElement('div');
    messageElement.textContent = `Você: ${message}`;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight; 
    messageInput.value = '';
});
