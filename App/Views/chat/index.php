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
        <div style="display:flex; justify-content: space-evenly">
            <button class="btn btn-success"> Aceitar </button>
            <button class="btn btn-danger"> Recusar </button>
        </div>

        <div id="chat-box"></div>
        <form id="chat-form" method='post' action='/api/enviar_mensagem'>
            <input type="text" id="message" placeholder="Digite sua mensagem..." required>
            <input type="submit"></input>
        </form>
    </div>

    <?php

    use Pusher\Pusher;

    $pusher = new Pusher(
        '8702b12d1675f14472ac',
        '0e7618b4f23dcfaf415c',
        '1863692',
        [
            'cluster' => 'sa1',
            'useTLS' => false
        ]
    );

    $contratoId = $_GET['id'] ?? null;
    $clienteId = $_GET['cliente_id'] ?? null;
    $profissionalId = $_GET['profissional_id'] ?? null;


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

        fetch('/api/enviar_mensagem', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_chat: '<?php echo $contratoId; ?>',
                mensagem: message
            })
        });

        // Exibir a mensagem na interface
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
