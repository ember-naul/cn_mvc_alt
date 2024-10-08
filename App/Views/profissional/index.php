<?php
namespace App\Views\profissional;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css"/>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>
<div class="container-mapa">
    <div id="map"></div>
    <script>
        var map;
        var marker;
        var routingControl;
        var firstUpdate = true;
        var profissionalId = '<?php echo $_SESSION['profissional_id']; ?>';
        var tempoEmSegundos = 0; // Inicializa o contador de tempo
        var contadorEnvios = 0; // Contador para o número de envio

        var pusher = new Pusher('8702b12d1675f14472ac', {
            cluster: 'sa1',
            useTLS: true // Atualizado para usar TLS
        });

        var channel = pusher.subscribe('contratos');

        function iniciarContagem() {
            setInterval(function () {
                tempoEmSegundos++; // Incrementa o contador a cada segundo
                // console.log("Tempo: " + tempoEmSegundos + " segundos");

                // Envie a localização a cada 10 segundos
                if (tempoEmSegundos % 10 === 0) {
                    navigator.geolocation.getCurrentPosition(success, error, {
                        enableHighAccuracy: true,
                        timeout: 5000
                    });
                }
            }, 1000);
        }

        function enviarLocalizacao(lat, lon) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/enviar_profissional', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Localização enviada com sucesso"); // Exibe o contador
                    console.log("Coordenadas: " + lat + ", " + lon); // Exibe as coordenadas
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
            contadorEnvios++;

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

            if (firstUpdate) {
                map.setView([lat, lon], 13);
                firstUpdate = false;
            }

            enviarLocalizacao(lat, lon);
        }

        function error(err) {
            console.error("Erro ao obter localização:", err);
        }

        function calcularRota(origem, destino) {
            if (routingControl) {
                map.removeControl(routingControl);
            }

            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(origem[0], origem[1]),
                    destino
                ],
                router: L.Routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1/'
                }),
                routeWhileDragging: true
            }).addTo(map);
        }

        iniciarContagem();
        atualizarLocalizacao();
    </script>
<!--    <div class="prestadores-container"></div>-->
    <div id="solicitacoes" class="solicitacoes"><?php include("requestCliente.php"); ?></div>
</div>
</body>
<script>
    channel.bind('nova-solicitacao', function (data) {
        console.log("ID do profissional logado:", profissionalId);
        console.log("ID do cliemte recebido:", data.cliente_id);

        if (parseInt(data.profissional_id) === parseInt(profissionalId)) {
            alert(data.message);
            document.getElementById('solicitacoes').innerHTML = "Nova solicitação recebida!";
</script>

