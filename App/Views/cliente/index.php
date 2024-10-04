<?php

namespace App\Views\cliente;

namespace App\Views\cliente;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;
use App\Models\Endereco;

$usuario = Usuario::find($_SESSION['id_usuario']);
$cliente = Cliente::where('id_usuario', $usuario->id)->first();
$profissionais = Profissional::with('habilidades')->get();
$_SESSION['cliente_id'] = $cliente->id;
?>

<head>
    <meta charset="utf-8">
    <title>Google Maps Example</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- <script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6"></script> -->
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
        var firstUpdate = true; // Variável de controle para centralizar apenas uma vez

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
        }

        function error(err) {
            console.log(err);
        }

        // Ativa o rastreamento da localização
        navigator.geolocation.watchPosition(success, error, {
            enableHighAccuracy: true,
            timeout: 5000
        });
    </script>
    <div class="prestadores-container">
        <?php
        foreach ($profissionais as $profissional):
            if ($profissional && $_SESSION['cliente'] && $profissional->id_usuario != $_SESSION['id_usuario']):
                $nomeUsuario = $profissional->usuario ? $profissional->usuario->nome : 'Usuário não encontrado'; ?>
                <div class="prestador" onclick="handlePrestadorClick(1)">
                    <img src="/assets/img/eletricista.jpg" alt="bruno">
                    <div class="h5-prestador">
                        <h5><?= $nomeUsuario ?></h5>
                    </div>
                    <div class="p-prestador">
                        <?php foreach ($profissional->habilidades as $habilidade): ?>
                            <p><?= $habilidade->nome . " "; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <span class="distancia">5.2 km</span>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>


    </div>
</div>
</body>
<!--<script>-->
<!--    // Inicializar o Pusher para o Cliente-->
<!--    const clientPusher = new Pusher('YOUR_APP_KEY', {-->
<!--        cluster: 'YOUR_APP_CLUSTER'-->
<!--    });-->
<!---->
<!--    // Função para enviar a localização do cliente-->
<!--    function sendClientLocation(latitude, longitude) {-->
<!--        fetch('/../../../server.php', {-->
<!--            method: 'POST',-->
<!--            headers: {-->
<!--                'Content-Type': 'application/json'-->
<!--            },-->
<!--            body: JSON.stringify({latitude, longitude, type: 'client'})-->
<!--        }).then(response => {-->
<!--            return response.json();-->
<!--        }).then(data => {-->
<!--            console.log(data);-->
<!--        }).catch(error => {-->
<!--            console.error('Error:', error);-->
<!--        });-->
<!--    }-->
<!---->
<!--    // Listener para atualizações de profissionais-->
<!--    const professionalChannel = clientPusher.subscribe('location-channel');-->
<!--    professionalChannel.bind('location-updated', function (data) {-->
<!--        // Atualizar o mapa com as novas localizações dos profissionais-->
<!--        updateProfessionalMap(data.professionals);-->
<!--    });-->
<!--</script>-->