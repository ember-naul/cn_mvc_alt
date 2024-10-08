<?php

namespace App\Views\cliente;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;
use App\Models\Endereco;
$usuario = Usuario::find($_SESSION['id_usuario']);
$cliente = Cliente::where('id_usuario', $usuario->id)->first();
// Supondo que você já tenha as coordenadas do cliente
$clienteLatitude = $cliente->latitude; // Latitude do cliente
$clienteLongitude = $cliente->longitude; // Longitude do cliente

$raioTerra = 6371;

$profissionais = Profissional::with('habilidades')
    ->where('id_usuario', '!=', $usuario->id)
    ->get()
    ->filter(function ($profissional) use ($clienteLatitude, $clienteLongitude, $raioTerra) {
        $profissionalLatitude = $profissional->latitude; // Latitude do profissional
        $profissionalLongitude = $profissional->longitude; // Longitude do profissional

        // Converter para radianos
        $lat1 = deg2rad($clienteLatitude);
        $lat2 = deg2rad($profissionalLatitude);
        $deltaLat = deg2rad($profissionalLatitude - $clienteLatitude);
        $deltaLon = deg2rad($profissionalLongitude - $clienteLongitude);

        // Fórmula de Haversine
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * asin(sqrt($a));
        $distance = $raioTerra * $c; // Distância em km

        // Retorna true se a distância for menor ou igual a 5 km
        return $distance <= 5;
    });

function calcularDistancia($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Raio da Terra em km

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c; // Distância em km
}

// Suponha que você tenha a latitude e longitude do cliente
$lat_cliente = $cliente->latitude;
$lon_cliente = $cliente->longitude;

$profissional_mais_proximo = null;
$menor_distancia = PHP_INT_MAX; // Inicia com um valor muito alto

foreach ($profissionais as $profissional) {
    $distancia = calcularDistancia($lat_cliente, $lon_cliente, $profissional->latitude, $profissional->longitude);

    if ($distancia < $menor_distancia) {
        $menor_distancia = $distancia;
        $profissional_mais_proximo = $profissional;
        // Atualiza as coordenadas do profissional mais próximo
        $lat_prox = $profissional->latitude;
        $lon_prox = $profissional->longitude;

        // Coloque os valores de latitude e longitude no JavaScript
        echo "<input type='hidden' id='lathidden' value='{$lat_prox}'>";
        echo "<input type='hidden' id='lonhidden' value='{$lon_prox}'>";

    }
}

$_SESSION['cliente_id'] = $cliente->id;
?>


<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"/>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <style>
    .modal {
    z-index: 1050; /* ou um valor maior */
    }

    .modal-backdrop {
    z-index: 1040; /* ou um valor inferior ao do modal */
    }
    </style>
    <link href="/assets/css/index.css" rel="stylesheet">
</head>


<body>



<div class="container-mapa">
    <div id="map"></div>
    <form id="localizacaoForm" style="display:none;">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <script>
            var map;
            var marker;
            var routingControl;
            var firstUpdate = true;
            var v1 = null;
            var v2 = null;
            const clienteId = '<?php echo $_SESSION['cliente_id']; ?>';
            var tempoEmSegundos = 0; // Inicializa o contador de tempo
            var contadorEnvios = 0; // Contador para o número de envio

            window.onload = function () {
                v1 = parseFloat(document.getElementById("lathidden").value);
                v2 = parseFloat(document.getElementById("lonhidden").value);
            }

            var pusher = new Pusher('8702b12d1675f14472ac', {
                cluster: 'sa1',
                useTLS: true
            });

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
                }, 1000); // 1000 ms = 1 segundo
            }

            function enviarLocalizacao(lat, lon) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/enviar_cliente', true);
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
                contadorEnvios++; // Incrementa o contador de envios

                if (!map) {
                    map = L.map('map').setView([lat, lon], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                    marker = L.marker([lat, lon]).addTo(map);

                    <?php
                    foreach ($profissionais as $profissional) {
                        echo "L.marker([{$profissional->latitude}, {$profissional->longitude}]).addTo(map);";
                    }
                    ?>
                } else {
                    marker.setLatLng([lat, lon]);
                    var destination = L.latLng(v1, v2); // Usa as coordenadas do profissional mais próximo
                    calcularRota([lat, lon], destination);
                }
                if (firstUpdate) {
                    map.setView([lat, lon], 13);
                    firstUpdate = false;
                }
                enviarLocalizacao(lat, lon);
            }

            function error(err) {
                console.error("Erro ao obter localização:", err); // Adicionado tratamento de erro
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

            iniciarContagem(); // Inicia a contagem ao carregar a página
            atualizarLocalizacao(); // Chama a função para obter a localização do cliente

            // Adiciona um canal para escutar as atualizações de localização
            var channel = pusher.subscribe('localizacao_cliente_' + clienteId);
            channel.bind('atualizar_localizacao', function (data) {
                console.log("Recebido nova localização:", data);
                // Aqui você pode adicionar a lógica para atualizar a localização do profissional no mapa
                // Exemplo: adicionar um novo marcador ou atualizar um existente
            });
        </script>
    </form>


    <script>
        function testarJson(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/api/profissionais/' + id, true); // Usa o ID do profissional
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log("Resposta JSON: ", xhr.responseText);
                    } else {
                        console.error("Erro na requisição:", xhr.statusText);
                    }
                }
            };
            xhr.send();
        }

        function teste(profid){
            console.log(profid)
        }
    </script>

    <div class="prestadores-container">
        <?php
        foreach ($profissionais as $profissional):
            if ($profissional && $_SESSION['cliente'] && $profissional->id_usuario != $_SESSION['id_usuario']):
                $profissionalId = $profissional->id ? $profissional->id : "Profissional não encontrado";
                $idUsuario = $profissional->usuario ? $profissional->usuario->id : 'Id não encontrado';
                $nomeUsuario = $profissional->usuario ? $profissional->usuario->nome : 'Usuário não encontrado';
                $celularUsuario = $profissional->usuario ? $profissional->usuario->celular : 'Celular não encontrado';
                $valor = calcularDistancia($profissional->latitude, $profissional->longitude, $cliente->latitude, $cliente->longitude);
                ?>
                <a data-toggle="modal" onclick="teste(<?= $profissionalId ?>)" data-target="#prof<?= $profissionalId ?>" style= "border:none;">
                <div class="prestador">
                    <div class="h5-prestador">
                        <h5><?= $nomeUsuario ?></h5>
                    </div>
                    <div class="p-prestador">
                        <p> Clique para ver mais</p>
                    </div>
                    <span class="distancia"><?= round($valor, 2) ?> km</span>
                </div>
                </a>
                <div class="modal modalprofissional" id="prof<?= $profissionalId ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content rounded-lg">
                            <div class="modal-header justify-content-center">
                                <h4 class="modal-title" id="modalLabel">Perfil Profissional</h4>
                                <button type="button" class="close position-absolute" style="right: 15px;" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="container-fluid">
                                <div class="row mb-3">
                                    <div class="card-body box-profile text-center">
                                        <img style="padding-bottom: 1.1%" width="130px" height="130px" class="profile-user-img img-fluid img-circle"
                                             src="/assets/img/perfilicon.png" alt="User profile picture">
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <b>Nome</b>
                                                <h4 class="profile-username"><?= $nomeUsuario ?></h4>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <b>Celular</b>
                                                <span class="float-right"><?= $celularUsuario ?></span>

                                            </li>
                                        </ul>
                                        <div class="form-group">
                                            <h5>Habilidades:</h5>
                                            <div id="skills-container" class="d-flex flex-wrap justify-content-center">
                                                <?php foreach ($profissional->habilidades as $phabilidades): ?>
                                                    <span class="badge badge-info badge-custom m-1"><?= $phabilidades->nome ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="row text-center ml-5 mr-5">
                                            <div class="col-6 mb-2">
                                                <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" onclick="testarJson(<?= $profissional->id ?>)">
                                                <img src="/assets/img/celular.png" alt="Sobre" width="24" class="mr-2">Chamar
                                                </button>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <a class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" data-dismiss="modal" aria-label="Close">
                                                    <img src="/assets/img/recusar.png" alt="Sobre" width="24" class="mr-2"> Cancelar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>



</body>


