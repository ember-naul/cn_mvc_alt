<?php

require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $users;

    public function __construct() {
        $this->users = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Adiciona o cliente conectado
        $this->users->attach($conn);
        echo "Nova conexão: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Transmite a mensagem para todos os clientes conectados
        foreach ($this->users as $user) {
            if ($user !== $from) {
                $user->send($msg);
            } else {
                // Enviar a mensagem para o cliente que a enviou
                $user->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove o cliente desconectado
        $this->users->detach($conn);
        echo "Conexão {$conn->resourceId} fechada\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Inicia o servidor WebSocket
$app = new Ratchet\App('localhost', 8080, '0.0.0.0');
$app->route('/chat', new Chat, ['*']);
$app->run();
