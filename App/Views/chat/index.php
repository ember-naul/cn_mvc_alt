<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat em Tempo Real</title>
    <link rel="stylesheet" href="/assets/css/chat.css">
</head>
<body>
    <div class="chat-container">
        <div id="chat-box"></div>
        <form id="chat-form">
            <input type="text" id="message" placeholder="Digite sua mensagem..." required>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <?php
    $username = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'UsuárioDesconhecido';
    ?>
    
    <script>
        let conn = new WebSocket('ws://localhost:8080/chat');
        const chatBox = document.getElementById('chat-box');
        const form = document.getElementById('chat-form');
        const messageInput = document.getElementById('message');

        const username = <?php echo json_encode($username); ?>;

        conn.onmessage = function(e) {
            let message = JSON.parse(e.data);
            let messageElement = document.createElement('div');
            if (message.user === username) {
                messageElement.classList.add('message-self');
                messageElement.textContent = `Você: ${message.text}`;
            } else {
                messageElement.classList.add('message-other');
                messageElement.textContent = `${message.user}: ${message.text}`;
            }
            
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let message = messageInput.value;
            let outgoingMessage = JSON.stringify({ user: username, text: message });
            conn.send(outgoingMessage);
            
            let messageElement = document.createElement('div');
            messageElement.classList.add('message-self');
            messageElement.textContent = `Você: ${message}`;
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight; 
            messageInput.value = '';
        });

    </script>
</body>
</html>
