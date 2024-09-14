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

        // Nome de usuário definido na sessão PHP
        const username = <?php echo json_encode($username); ?>;

        // Receber mensagens do servidor
        conn.onmessage = function(e) {
            let message = JSON.parse(e.data); // Parse JSON para obter a mensagem e o remetente
            let messageElement = document.createElement('div');

            // Adicionar classe com base no remetente
            if (message.user === username) {
                messageElement.classList.add('message-self');
                messageElement.textContent = `Você: ${message.text}`;
            } else {
                messageElement.classList.add('message-other');
                messageElement.textContent = `${message.user}: ${message.text}`;
            }
            
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
            messageElement.classList.add('message-self');
            messageElement.textContent = `Você: ${message}`;
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight; 
            messageInput.value = '';
        });

    </script>
</body>
</html>
