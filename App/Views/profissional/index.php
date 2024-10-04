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
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>
<div class="container-mapa">
    <div id="map"></div>
    <script>
        var map;
        var marker;
        var routingControl; // Inicialize routingControl aqui
        var firstUpdate = true;
        var lastPosition = null; // Armazenar a última posição
        var distanceThreshold = 0.005; // Limite de distância em graus
        const professionalId = '<?php echo $_SESSION['profissional_id']; ?>'; // ID do profissional

        function calcularDistancia(lat1, lon1, lat2, lon2) {
            // Função para calcular a distância entre dois pontos (Haversine)
            const R = 6371; // Raio da Terra em km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // Retorna a distância em km
        }


        function enviarLocalizacao(lat, lon) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/at', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Localização enviada com sucesso. Distância em KM: ' + calcularDistancia(lat, lon, -22.753724112140812, -47.35141976953807).toFixed(2));
                }
            };

            var params = 'latitude=' + lat + '&longitude=' + lon;
            xhr.send(params);
        }

        function atualizarLocalizacao() {
            navigator.geolocation.getCurrentPosition(success, error, {
                enableHighAccuracy: true,
                timeout: 5000
            });
        }

        function success(pos) {
            var lat = pos.coords.latitude;
            var lon = pos.coords.longitude;
            console.log(lat, lon);
            lastPosition = { lat: lat, lon: lon };

            if (!map) {
                map = L.map('map').setView([lat, lon], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                marker = L.marker([lat, lon]).addTo(map);
            } else {
                marker.setLatLng([lat, lon]);
                var destination = L.latLng(-22.753724112140812, -47.35141976953807);
                calcularRota([lat, lon], destination);
            }

            // Centraliza o mapa apenas na primeira vez
            if (firstUpdate) {
                map.setView([lat, lon], 13);
                firstUpdate = false;
            }

            enviarLocalizacao(lat, lon);
        }

        function error(err) {
            console.log(err);
        }

        function calcularRota(origem, destino) {
            if (routingControl) {
                map.removeControl(routingControl);
            }

            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(origem[0], origem[1]),
                    destino // Use diretamente o objeto L.latLng
                ],
                router: L.Routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1/'
                }),
                routeWhileDragging: true
            }).addTo(map);
        }

        // Ativa o rastreamento da localização a cada 10 segundos
        setInterval(atualizarLocalizacao, 10000); // 10000 ms = 10 segundos

        // Faz a primeira chamada imediatamente
        atualizarLocalizacao();
    </script>
    <div class="prestadores-container"></div>
</div>
</body>