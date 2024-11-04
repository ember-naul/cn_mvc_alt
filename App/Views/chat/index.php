<?php

use App\Models\Endereco;
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
$enderecosBD = Endereco::where("id_cliente", $clienteId)->get();

$username = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'UsuárioDesconhecido';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat em Tempo Real</title>
    <link rel="stylesheet" href="/assets/css/chat.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"/>

</head>
<body>
<div class="container mt-5">
    <div class="row">
        <?php if ($_SESSION['cliente'] == true) : ?>
            <div class="col-md-4">
                <h2>Selecionar Endereço</h2>
                <select id="address-select" class="form-control mb-3">
                    <option value="">Selecione um endereço</option>
                    <?php
                    $apiKey = 'AIzaSyBV2RbCH4G9_X8i1sxWKAtdwiCkYFg44ig';
                    $enderecos = [];

                    foreach ($enderecosBD as $endereco) {
                        $cep = $endereco->cep;
                        $rua = $endereco->rua;
                        $numero = $endereco->numero;
                        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$cep&key=$apiKey";

                        $response = file_get_contents($url);
                        $data = json_decode($response, true);

                        if (isset($data['results'][0])) {
                            $fullAddress = htmlspecialchars($data['results'][0]['formatted_address']);
                            $isSimilar = false;
                            $ruaParts = explode(' ', $rua);

                            foreach ($ruaParts as $part) {
                                if (stripos($fullAddress, $part) !== false) {
                                    $isSimilar = true;
                                    break;
                                }
                            }

                            if (!$isSimilar) {
                                $fullAddress = "$rua, $numero - " . $fullAddress;
                            }

                            $enderecoJson = json_encode($endereco);
                            $enderecos[] = [
                                'endereco_completo' => htmlspecialchars($fullAddress),
                                'json' => $enderecoJson
                            ];
                        }
                    }

                    foreach ($enderecos as $endereco) {
                        $displayText = htmlspecialchars($endereco['endereco_completo']);
                        echo "<option value='" . htmlspecialchars($endereco['json']) . "'>$displayText</option>";
                    }
                    ?>
                </select>
                <div id="small-map"></div>
                <div class="d-flex justify-content-between mb-3">
                    <button id="accept-button-cliente" class="btn btn-success">Aceitar</button>
                    <button id="cancel-button-cliente" class="btn btn-danger">Recusar</button>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-8">
            <h2>Chat</h2>
            <div id="price-display" class="mt-3"></div>
            <div id="chat-box" class="border rounded p-3" style="overflow-y: auto;"></div>
            <form id="chat-form" method='post' action='/api/enviar_mensagem' class="mt-3">
                <input type="text" id="message" class="form-control" placeholder="Digite sua mensagem..." required>
                <input type="submit" class="btn btn-primary mt-2" style="background-color: #3e4c69;border: none; "
                       value="Enviar">
            </form>
        </div>
        <?php if ($_SESSION['profissional'] == true) : ?>
            <div class="col-md-4">
                <h2 class="padd">Definir Preço</h2>
                <div class="input-group mb-3">
                    <input type="number" id="price-input" class="form-control" placeholder="Defina o preço" required>
                    <div class="input-group-append">
                        <button id="set-price" class="btn btn-primary" style="background-color: #3e4c69; border: none;">
                            Definir Preço
                        </button>
                    </div>
                </div>
                <div id="small-map"></div>
                <div class="d-flex justify-content-between mb-3">
                    <button id="accept-button-profissional" class="btn btn-success">Aceitar</button>
                    <button id="cancel-button-profissional" class="btn btn-danger">Recusar</button>
                </div>
            </div>
        <?php endif; ?>
        <div id="accepted-users" class="d-flex align-items-center mt-3">
            <div id="cliente-accepted" class="accepted-user" style="display: none;">
                <img src="/assets/img/apple-touch-icon.png" alt="Cliente Aceitou" class="user-photo">
                <span class="accepted-icon">✔️</span>
            </div>
            <div id="profissional-accepted" class="accepted-user" style="display: none;">
                <img src="/assets/img/apple-touch-icon.png" alt="Profissional Aceitou" class="user-photo">
                <span class="accepted-icon">✔️</span>
            </div>
        </div>

        <div id="price-display" class="mt-3"></div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const username = <?php echo json_encode($username); ?>;
        console.log("Username:", username); // Para verificar se username está definido

        let userAcceptedCliente = false;
        let userAcceptedProfissional = false; // Status do profissional

        // Inicialização do Pusher
        var pusher = new Pusher('8702b12d1675f14472ac', {
            cluster: 'sa1',
            useTLS: true
        });

        // Inscrevendo-se no canal
        const channel = pusher.subscribe('chat-conc');

        channel.bind('user-aceitou', function(data) {
            if (data.role === 'cliente') {
                userAcceptedCliente = true;
                console.log("Cliente aceitou.");
            } else if (data.role === 'profissional') {
                userAcceptedProfissional = true;
                console.log("Profissional aceitou.");
            }

            // Verifica se ambos aceitaram
            if (userAcceptedCliente && userAcceptedProfissional) {
                console.log("Ambos aceitaram. Redirecionando...");
                window.location.href = '/pagina-contrato-aceito'; // Redirecionar ambos
            }
        });

        <?php if ($_SESSION['cliente']): ?>
        document.getElementById('accept-button-cliente').addEventListener('click', function () {
            if (userAcceptedCliente) {
                console.log("Você já aceitou.");
                return;
            }

            userAcceptedCliente = true;
            fetch('/api/concluir_contrato', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ username: username, role: 'cliente' })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        pusher.trigger('chat-conc', 'user-aceitou', { role: 'cliente' });
                    } else {
                        console.error('Erro:', data.message);
                    }
                });
        });
        <?php endif; ?>
        <?php if ($_SESSION['profissional']): ?>
        // Aceitar contrato - profissional
        document.getElementById('accept-button-profissional').addEventListener('click', function () {
            if (userAcceptedProfissional) {
                console.log("Você já aceitou.");
                return;
            }

            userAcceptedProfissional = true;
            // Aqui você faria a chamada fetch para o seu endpoint, assim como antes.
            fetch('/api/concluir_contrato', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ username: username, role: 'profissional' })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        pusher.trigger('chat-conc', 'user-aceitou', { role: 'profissional' });
                    } else {
                        console.error('Erro:', data.message);
                    }
                });
        });
        <?php endif; ?>
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let smallMap;
        let firstUpdate = true;
        let marker;
        let routingControl;
        let origem;
        let destino;

        function iniciarContagem() {
            setInterval(function () {
                tempoEmSegundos++;
                if (tempoEmSegundos % 5 === 0) {
                    navigator.geolocation.getCurrentPosition(success, error, {
                        enableHighAccuracy: true,
                        timeout: 5000
                    });
                }
            }, 1000);
        }

        let conn = new WebSocket('ws://localhost:8080/chat');
        const chatBox = document.getElementById('chat-box');
        const form = document.getElementById('chat-form');
        const messageInput = document.getElementById('message');
        const addressSelect = document.getElementById('address-select');
        const priceInput = document.getElementById('price-input');
        const priceDisplayCliente = document.getElementById('price-display');

        const username = <?php echo json_encode($username); ?>;

        conn.onopen = function () {
            console.log("Conectado ao WebSocket");
        };

        conn.onmessage = function (e) {
            let message = JSON.parse(e.data);
            let messageElement = document.createElement('div');

            if (message.user === username) {
                messageElement.classList.add('message-self');
                messageElement.textContent = `Você: ${message.text}`;
            } else if (message.address) {
                messageElement.classList.add('message-other');
                messageElement.textContent = `Endereço escolhido: ${message.address}`;

                // Calcular a rota para o profissional
                const destino = [parseFloat(message.lat), parseFloat(message.lon)];
                navigator.geolocation.getCurrentPosition(function (pos) {
                    const origem = [pos.coords.latitude, pos.coords.longitude];
                    calcularRota(origem, destino);
                });
            } else if (message.price) {
                priceDisplayCliente.textContent = `Preço definido: R$ ${message.price.toFixed(2)}`;
                messageElement.classList.add('message-other');
                messageElement.textContent = `Profissional definiu o preço: R$ ${message.price.toFixed(2)}`;
            } else {
                messageElement.classList.add('message-other');
                messageElement.textContent = `${message.user}: ${message.text}`;
            }

            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        };

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            let message = messageInput.value;
            let outgoingMessage = JSON.stringify({user: username, text: message});
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

            let messageElement = document.createElement('div');
            messageElement.classList.add('message-self');
            messageElement.textContent = `Você: ${message}`;
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
            messageInput.value = '';
        });

        // Verifique se o elemento de seleção de endereço existe
        if (addressSelect) {
            // Dentro do evento 'change' do select de endereços
            addressSelect.addEventListener('change', function () {
                let selectedAddress = addressSelect.value;
                if (selectedAddress) {
                    let addressData = JSON.parse(selectedAddress);
                    let formattedAddress = `Endereço: ${addressData.rua}, Nº ${addressData.numero}`;

                    let addressMessage = JSON.stringify({
                        user: username,
                        address: formattedAddress,
                        lat: addressData.latitude,
                        lon: addressData.longitude
                    });
                    conn.send(addressMessage);

                    let messageElement = document.createElement('div');
                    messageElement.classList.add('message-self');
                    messageElement.textContent = `Você escolheu o endereço: ${formattedAddress}`;
                    chatBox.appendChild(messageElement);
                    chatBox.scrollTop = chatBox.scrollHeight;

                    // Obtenha a localização atual e calcule a rota
                    navigator.geolocation.getCurrentPosition(function (pos) {
                        origem = [pos.coords.latitude, pos.coords.longitude];
                        destino = [parseFloat(addressData.latitude), parseFloat(addressData.longitude)];

                        // Calcular a rota imediatamente para o profissional
                        calcularRota(origem, destino);
                        console.log(origem, destino);
                    });
                }
            });
        }

        const setPriceButton = document.getElementById('set-price');
        console.log("Botão Definir Preço:", setPriceButton); // Debug

        if (setPriceButton) {
            setPriceButton.addEventListener('click', function () {
                let price = parseFloat(priceInput.value);
                if (!isNaN(price)) {
                    console.log("Preço definido:", price);
                    conn.send(JSON.stringify({user: username, price: price}));
                    priceInput.value = '';
                } else {
                    console.log("Preço inválido");
                }
            });
        } else {
            console.log("Botão 'Definir Preço' não encontrado. Verifique a sessão do profissional.");
        }

        function enviarLocalizacao(lat, lon) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/enviar_cliente', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Localização enviada com sucesso");
                }
            };
            var params = 'latitude=' + lat + '&longitude=' + lon;
            xhr.send(params);
        }

        function success(pos) {
            var lat = pos.coords.latitude;
            var lon = pos.coords.longitude;

            if (!smallMap) {
                smallMap = L.map('small-map').setView([lat, lon], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(smallMap);
                marker = L.marker([lat, lon]).addTo(smallMap);
                smallMapInitialized = true; // Marca que o mapa foi inicializado
            } else {
                marker.setLatLng([lat, lon]);
            }

            if (firstUpdate) {
                smallMap.setView([lat, lon], 13);
                firstUpdate = false;
            }

            if (addressSelect && addressSelect.value) {
                let selectedAddress = addressSelect.value;
                let addressData = JSON.parse(selectedAddress);
                const destino = [parseFloat(addressData.latitude), parseFloat(addressData.longitude)];
                calcularRota([lat, lon], destino);
            }
            enviarLocalizacao(lat, lon);
        }

        function calcularRota(origem, destino) {
            if (routingControl) {
                smallMap.removeControl(routingControl);
            }

            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(origem[0], origem[1]),
                    L.latLng(destino[0], destino[1]) // Certifique-se de usar L.latLng aqui
                ],
                router: L.Routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1/'
                }),
                routeWhileDragging: true
            }).addTo(smallMap);
        }

        function error(err) {
            console.error("Erro ao obter localização:", err);
        }

        function atualizarLocalizacao() {
            navigator.geolocation.getCurrentPosition(success, error, {
                enableHighAccuracy: true,
                timeout: 5000
            });
        }

        atualizarLocalizacao();
    });
</script>
</body>
</html>
