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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css"/>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <link rel="stylesheet" href="/assets/css/indexprofissional.css">
</head>
<body>
<div class="container-mapa">
    <div id="map"></div>
    <div class="aceitar-container">
        <div id="aceitar-cliente" class="aceitar-cliente hidden">
            <div class="user-container">
                <img width="150px" style="margin:auto; justify-content: center;" height="150px" src="/assets/img/perfilicon.png" alt="Descrição da Imagem">
            </div>
            <div class="user-container"><h2>Você recebeu um chamado de Luan</h2>
            </div>

            <div class="imagem-container">
                <img src="/assets/img/profissionalgif.gif" alt="Descrição da Imagem">
            </div>
            <div class="container-bottom">
                <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"  onclick="responderSolicitacao('aceitar')">Aceitar</button>
                <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"  onclick="responderSolicitacao('recusar')">Recusar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var map;
    var marker;
    var routingControl;
    var firstUpdate = true;
    var profissionalId = '<?php echo $_SESSION['profissional_id']; ?>';
    var tempoEmSegundos = 0;

    var pusher = new Pusher('8702b12d1675f14472ac', {
        cluster: 'sa1',
        useTLS: true
    });

    var channel = pusher.subscribe('contratos');

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

    function enviarLocalizacao(lat, lon) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/enviar_profissional', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Localização enviada com sucesso");
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

        if (!map) {
            map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            marker = L.marker([lat, lon]).addTo(map);
        } else {
            marker.setLatLng([lat, lon]);
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

    document.addEventListener("DOMContentLoaded", function() {
        const aceitarClienteElement = document.getElementById('aceitar-cliente');

        // Oculta o elemento ao carregar a página
        addHidden();

        function addHidden() {
            if (aceitarClienteElement) {
                aceitarClienteElement.classList.add('hidden');
            }
        }

        function removeHidden() {
            if (aceitarClienteElement) {
                aceitarClienteElement.classList.remove('hidden');
            } else {
                console.error('Elemento não encontrado: aceitar-cliente');
            }
        }

        channel.bind('nova-solicitacao', function (data) {
            console.log("ID do profissional logado:", profissionalId);
            console.log("ID do cliente recebido:", data.cliente_id);

            if (parseInt(data.profissional_id) === parseInt(profissionalId)) {
                removeHidden();
            } else {
                addHidden();
            }
        });
    });



    function responderSolicitacao(acao) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/responder_solicitacao', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Resposta enviada com sucesso: " + acao);
                addHidden(); // Esconder o aviso após resposta
            }
        };
        var params = 'acao=' + acao + '&profissional_id=' + profissionalId;
        xhr.send(params);
    }

    iniciarContagem();
    atualizarLocalizacao();
</script>
</body>

