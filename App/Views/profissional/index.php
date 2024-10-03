<?php
namespace App\Views\profissional;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;

require_once __DIR__ . "/server.php";

$usuario = Usuario::find($_SESSION['id_usuario']);
$profissional = Profissional::where('id_usuario', $usuario->id)->first();
$_SESSION['profissional_id'] = $profissional->id;
?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        html ::-webkit-scrollbar {
            width: 10px;
        }

        html ::-webkit-scrollbar-thumb {
            border-radius: 50px;
            background: #3d4d6a;
        }

        html ::-webkit-scrollbar-track {
            background: #ededed;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            background-color: #e1e1e1;
        }

        .container-mapa {
            display: flex;
            height: 87vh;
            width: 80vw;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        #map {
            flex: 1;
            height: 100%;
            width: 100%;
            margin: 0;
            border: 2px solid #ddd;
            border-radius: 10px;
            z-index: 4;
        }


        .prestadores-container {
            display: flex;
            flex-direction: column;
            width: 35%;
            max-height: 45rem;
            overflow-y: auto;
            overflow-x: hidden;
            box-sizing: border-box;
            margin: auto;

        }

        .prestador {
            display: flex;
            align-items: center;
            background-color: white;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .prestador:hover {
            transform: scale(1.02);
        }

        .prestador img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .h5-prestador {
            flex-grow: 1;
            font-family: 'Inter', sans-serif;
            text-align: left;
        }

        .p-prestador {
            margin-right: 8%;
            font-size: 0.9em;
            color: #888;
            margin-top: 4%
        }

        .distancia {
            font-size: 0.9em;
            color: #888;
            text-align: right;
            margin-left: 10px;
        }

        .search {
            display: flex;
            margin: auto;
            align-items: center;
        }

        @media (max-width: 768px) {

            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden;
                /* Desativa a rolagem geral */
            }

            .container-mapa {
                flex-direction: column;
                width: 768px;
                height: 45%;
                /*height: calc(100% - 100px);*/
                margin: 0;
                /* Usa a altura total da tela */
                margin-bottom: 100%;
            }


            #map {
                height: 50vh;
                width: 100vw;
                margin: 0;
                order: 2;
            }

            .prestadores-container {
                width: 100%;
                max-height: 26rem;
                /* Adjust height for mobile */
                margin: 0;
                /* Remove margin */
                border-radius: 20px 20px 0 0;
                /* Rounded corners on top */
                position: fixed;
                /* Fixed at bottom */
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 10;
                overflow-y: auto;
                background-color: rgba(255, 255, 255, 0.9);
                padding: 20px;
            }

            .prestador {
                margin-bottom: 10px;
                padding: 8px;
            }

            .prestador img {
                width: 40px;
                height: 40px;
            }

            .h5-prestador {
                font-size: 1em;
            }

            .p-prestador,
            .distancia {
                font-size: 0.8em;
            }
        }

        .zoom-controls {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }

        .zoom-controls button {
            margin: 3px;
            padding: 13px;
            background-color: #3d4d6a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .zoom-controls button:hover {
            background-color: #2b3a50;
        }
    </style>
</head>
<body>
<div class="container-mapa">
    <div id="map"></div>
    <script>
        var map;
        var marker;
        var firstUpdate = true; // Para centralizar o mapa apenas na primeira atualização
        const professionalId = '<?php echo $_SESSION['profissional_id']; ?>'; // ID do profissional

        function success(pos) {
            var lat = pos.coords.latitude;
            var lon = pos.coords.longitude;
            console.log(lat, lon);

            // Inicializa o mapa apenas uma vez
            if (!map) {
                map = L.map('map').setView([lat, lon], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Cria o marcador na localização inicial
                marker = L.marker([lat, lon]).addTo(map);
            } else {
                // Atualiza a posição do marcador
                marker.setLatLng([lat, lon]);
            }

            // Centraliza o mapa apenas na primeira vez
            if (firstUpdate) {
                map.setView([lat, lon], 13);
                firstUpdate = false;
            }

            // Envia a localização do profissional ao servidor
            sendProfessionalLocation(lat, lon);
        }

        function error(err) {
            console.log(err);
        }

        // Ativa o rastreamento da localização
        navigator.geolocation.watchPosition(success, error, {
            enableHighAccuracy: true,
            timeout: 5000
        });

        // Inicializa o Pusher para o Profissional
        const professionalPusher = new Pusher('8702b12d1675f14472ac', {
            cluster: 'sa1'
        });

        // Função para enviar a localização do profissional
        function sendProfessionalLocation(latitude, longitude) {
            fetch('server.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({latitude, longitude, type: 'professional', id: professionalId})
            }).then(response => {
                console.log('Status da resposta: [opt 1]:', response.status); // Verifique o status da resposta
                return response.text(); // Mude para .text() para depurar o conteúdo
            }).then(data => {
                console.log('Dados da resposta [opt 2]:', data); // Verifique a resposta
                try {
                    const jsonData = JSON.parse(data); // Tente analisar o JSON
                    console.log(jsonData);
                } catch (e) {
                    console.error('JSON Erro na conversão [opt 3]:', e);
                }
            }).catch(error => {
                console.error('Error:', error);
            });

            // Listener para atualizações de clientes
            const clientChannel = professionalPusher.subscribe('location-channel');
            clientChannel.bind('location-updated', function (data) {
                // Atualizar o mapa com as novas localizações dos clientes
                updateClientMap(data.clients);
            });

            // Função para atualizar o mapa com localizações de clientes
            function updateClientMap(clients) {
                // Aqui você pode implementar a lógica para adicionar marcadores de clientes no mapa
                console.log(clients);
            }
        } // Feche a função sendProfessionalLocation
    </script> <!-- Fechar a tag <script> -->
    <div class="prestadores-container">
        <?php
        // Exibir profissionais
        // foreach ($profissionais as $profissional):
        ?>
        <!-- <div class="prestador" onclick="handlePrestadorClick(1)"> -->
        <!-- Aqui você pode exibir informações dos profissionais -->
        <!-- </div> -->
        <?php // endforeach; ?>
    </div>
</div>
</body>