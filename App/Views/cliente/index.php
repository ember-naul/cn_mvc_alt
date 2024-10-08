<?php

namespace App\Views\cliente;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;
use App\Models\Endereco;

$usuario = Usuario::find($_SESSION['id_usuario']);
$cliente = Cliente::where('id_usuario', $usuario->id)->first();

$clienteLatitude = $cliente->latitude;
$clienteLongitude = $cliente->longitude;

$profissionais = Profissional::with('habilidades')
    ->where('id_usuario', '!=', $usuario->id)
    ->get()
    ->filter(function ($profissional) use ($clienteLatitude, $clienteLongitude) {
        if ($profissional->latitude !== null && $profissional->longitude !== null) {
            $distancia_P = calcularDistancia($clienteLatitude, $clienteLongitude, $profissional->latitude, $profissional->longitude);
            return $distancia_P <= 250;
        }
        return false;
    });

function calcularDistancia($lat1, $lon1, $lat2, $lon2)
{
    $raioTerra = 6371;

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $raioTerra * $c; // retorna valor em km's
}

$habilidades = Habilidade::all();
$usuario = Usuario::find($_SESSION['id_usuario']);
$_SESSION['cliente_id'] = $cliente->id;
?>
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
<style>
    .btn-custom {
        background-color: #3e4c69;
        color: white;
        border: none; /* Remove borda se necessário */
        padding: 10px 20px; /* Ajuste o padding conforme desejado */
        cursor: pointer; /* Muda o cursor para indicar que é clicável */
        transition: background-color 0.3s; /* Efeito suave na transição */
    }

    .btn-custom:hover {
        background-color: #2c3e50; /* Cor ao passar o mouse */
    }

    .btn-submit {
        display: block;
        width: 100%;
        margin-top: 1rem;
        background-color: #3e4c69;
        border: none;
    }

    .img-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .text-center-top {
        text-align: center;
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }
</style>
<link href="/assets/css/index.css" rel="stylesheet">
<body>
<div class="container-mapa">
    <div id="map"></div>
    <div class="prestadores-container">
        <div class="container mb-5">
            <form action="#" method="get" class="d-flex flex-column">
                <div class="form-group">
                    <label for="dynamic-select"></label><select id="dynamic-select"
                                                                class="form-control js-example-tags"
                                                                name="habilidades[]" multiple="multiple">
                        <?php foreach ($habilidades as $habilidade): ?>
                            <option value="<?= htmlspecialchars($habilidade['id']) ?>" <?= $habilidade->nome ?>>
                                <?= htmlspecialchars($habilidade['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-primary btn-submit btn-custom" type="submit">Prosseguir</button>
            </form>
        </div>

        <?php
        $profissionaisComDistancia = [];

        foreach ($profissionais as $profissional):
            if ($profissional && $_SESSION['cliente'] && $profissional->id_usuario != $_SESSION['id_usuario']):
                $distancia = calcularDistancia($profissional->latitude, $profissional->longitude, $cliente->latitude, $cliente->longitude);
                $profissionaisComDistancia[] = [
                    'profissional' => $profissional,
                    'distancia' => $distancia
                ];
            endif;
        endforeach;

        // Ordena os profissionais pela distância
        usort($profissionaisComDistancia, function ($a, $b) {
            return $a['distancia'] <=> $b['distancia'];
        });

        // Exibe os profissionais ordenados
        foreach ($profissionaisComDistancia as $item):
            $profissional = $item['profissional'];
            $valor = $item['distancia'];
            ?>
            <a data-toggle="modal" onclick="teste(<?= $profissional->id ?>)"
               data-target="#prof<?= $profissional->id ?>"
               style="border:none;">
                <div class="prestador">
                    <div class="h5-prestador">
                        <h5><?= $profissional->usuario->nome ?></h5>
                    </div>
                    <div class="p-prestador">
                        <p>Clique para ver mais</p>
                    </div>
                    <span class="distancia"><?= round($valor, 2) ?> km</span>
                </div>
            </a>

            <div class="modal modalprofissional" id="prof<?= $profissional->id ?>" tabindex="-1"
                 aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content rounded-lg">
                        <div class="modal-header justify-content-center">
                            <h4 class="modal-title" id="modalLabel">Perfil Profissional</h4>
                            <button type="button" class="close position-absolute" style="right: 15px;"
                                    data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="card-body box-profile text-center">
                                    <img style="padding-bottom: 1.1%" width="130px" height="130px"
                                         class="profile-user-img img-fluid img-circle"
                                         src="/assets/img/perfilicon.png" alt="User profile picture">
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <b>Nome</b>
                                            <h4 class="profile-username"><?= $profissional->usuario->nome ?></h4>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <b>Celular</b>
                                            <span class="float-right"><?= $profissional->usuario->celular ?></span>
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
                                            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
                                                    onclick="testarJson(<?= $profissional->id ?>)">
                                                <img src="/assets/img/celular.png" alt="Sobre" width="24"
                                                     class="mr-2">Chamar
                                            </button>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <a class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
                                               data-dismiss="modal" aria-label="Close">
                                                <img src="/assets/img/recusar.png" alt="Sobre" width="24"
                                                     class="mr-2">
                                                Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
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


    var pusher = new Pusher('8702b12d1675f14472ac', {
        cluster: 'sa1',
        useTLS: true
    });

    function iniciarContagem() {
        setInterval(function () {
            tempoEmSegundos++; // Incrementa o contador a cada segundo
            console.log("Tempo: " + tempoEmSegundos + " segundos");

            // Envie a localização a cada 10 segundos
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
        xhr.open('POST', '/enviar_cliente', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Localização enviada com sucesso"); // Exibe o contador
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
            // var destination = L.latLng(v1, v2); // Usa as coordenadas do profissional mais próximo
            // calcularRota([lat, lon], destination);
        }
        if (firstUpdate) {
            map.setView([lat, lon], 13);
            firstUpdate = false;
        }
        setTimeout(() => {
            enviarLocalizacao(lat, lon);
        }, 15000);

    }

    function error(err) {
        console.error("Erro ao obter localização:", err);
    }

    // function calcularRota(origem, destino) {
    //     if (routingControl) {
    //         map.removeControl(routingControl);
    //     }
    //
    //     routingControl = L.Routing.control({
    //         waypoints: [
    //             L.latLng(origem[0], origem[1]),
    //             destino
    //         ],
    //         router: L.Routing.osrmv1({
    //             serviceUrl: 'https://router.project-osrm.org/route/v1/'
    //         }),
    //         routeWhileDragging: true
    //     }).addTo(map);
    // }

    iniciarContagem();
    atualizarLocalizacao();

    // Adiciona um canal para escutar as atualizações de localização
    var channel = pusher.subscribe('localizacao_cliente_' + clienteId);
    channel.bind('atualizar_localizacao', function (data) {
        console.log("Recebido nova localização:", data);
    });
</script>
<script>
    function testarJson(id) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/profissionais/' + id, true);
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
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="/assets/plugins/select2/js/select2.full.js"></script>
<script>
    $(document).ready(function () {
        $(".js-example-tags").select2({
            tags: true,
            placeholder: "Quais serviços você está buscando?",
            allowClear: true
        });

        $('#dynamic-select').on('change', function () {
            var selectedOptions = $(this).find('option:selected').map(function () {
                return $(this).text();
            }).get().join(', ');

            $('.selected-skills').html('<p><strong>Habilidades Selecionadas:</strong> ' + selectedOptions + '</p>');
        });
    });
</script>
</body>



