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
    <link href="/assets/css/index.css" rel="stylesheet">
</head>

<body>
<div class="container-mapa">

    <div id="map"></div>
    <script>
        var map;
        var marker;
        var firstUpdate = true;

        function success(pos) {
            var lat = pos.coords.latitude;
            var lon = pos.coords.longitude;
            console.log(lat, lon);
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