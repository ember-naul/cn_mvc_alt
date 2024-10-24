<?php

namespace App\Views\cliente;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;
use App\Models\Endereco;

$usuario = Usuario::find($_SESSION['id_usuario']);
$cliente = Cliente::where('id_usuario', $usuario->id)->first();
$habilidades = Habilidade::all();
$_SESSION['cliente_id'] = $cliente->id;

?>
<link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="/assets/css/leaflet.awesome-markers.css">
<script src="/assets/js/leaflet.awesome-markers.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"/>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
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
        height: 87vh; /* altura total do contêiner */
        width: 85vw;
        margin: 0 auto;
        flex-wrap: nowrap; /* Não quebre para uma nova linha */
    }

    #map {
        flex: 1; /* Mapa ocupa o espaço disponível */
        height: 100%; /* Altura total do contêiner */
        margin: 0;
        border: 2px solid #ddd;
        border-radius: 10px;
        z-index: 4;
    }

    .prestadores-container {
        display: flex;
        flex-direction: column;
        width: 30%;
        height: 100%;
        max-height: 60rem;
        overflow-y: auto;
        overflow-x: hidden;
        box-sizing: border-box;
        margin: 0;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
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

    .aceitar-cliente img {
        max-width: 100%;
        height: auto;
        border: 1px solid black;
    }

    .imagem-container {
        display: flex;
        justify-content: center;
        width: 50%;
        margin: auto;
        border: 1px solid black;
    }

    .botao-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: 20px;
        border: 1px solid black;
    }

    .botao {
        width: 100%;
        margin: 0 10px;
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
    }


    .modal-backdrop {
        z-index: 1040; /* ou um valor inferior ao do modal */
    }

    .modal {
        z-index: 1050; /* ou um valor maior */
    }

    @media (max-width: 768px) {

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .container-mapa {
            flex-direction: column;
            width: 768px;
            height: 45%;
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
            max-height: 20rem;
            margin: 0;
            position: fixed;
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

        .modal {
            z-index: 2000;
        }

        .modal-backdrop {
            z-index: 5;
        }

        .modalprofissional {
            margin-top: 23%;
        }
    }

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
<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/leaflet.awesome-markers.css">
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
    });
</script>
<body>


<div class="container-mapa">
    <div id="map"></div>
    <div class="prestadores-container">
        <div class="container mb-5">
            <div class="form-group">
                <label for="dynamic-select"></label>
                <select id="dynamic-select" class="form-control js-example-tags" name="habilidades[]"
                        multiple="multiple">
                    <?php foreach ($habilidades as $habilidade): ?>
                        <option value="<?= htmlspecialchars($habilidade['id']) ?>">
                            <?= htmlspecialchars($habilidade['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-primary btn-submit btn-custom" onclick="enviarHabilidade()">Prosseguir</button>
            <p name="response"></p>
        </div>
        <div class="lista-container" style="display:none">
        </div>
    </div>
</div>

<script>
    var map;
    var routingControl;
    var firstUpdate = true;
    var userMarker;
    var tempoEmSegundos = 0;
    const clienteId = '<?php echo $_SESSION['cliente_id']; ?>';

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
            userMarker = L.marker([lat, lon]).addTo(map); // Armazena o marker na variável userMarker
        } else {
            userMarker.setLatLng([lat, lon]); // Atualiza o userMarker
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

    function enviarHabilidade() {
        var habilidadesSelecionadas = $('#dynamic-select').val();
        console.log("Habilidades selecionadas:", habilidadesSelecionadas);

        $.ajax({
            url: '/api/habilidades',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({habilidades: habilidadesSelecionadas}),
            success: function (response) {
                console.log("Resposta recebida:", response);
                try {
                    var jsonResponse = JSON.parse(response); // Converte a resposta em JSON
                    if (jsonResponse.error) {
                        console.error(jsonResponse.error);
                        alert(jsonResponse.error);
                        return;
                    }
                    mostrarProfissionaisNoMapa(jsonResponse);
                } catch (e) {
                    console.error("Erro ao processar a resposta:", e);
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro na requisição:", status, error);
            }
        });
    }

    function mostrarLista(profissionais) {
        const listaContainer = $('.lista-container');
        listaContainer.empty(); // Limpa a lista anterior
        listaContainer.show(); // Mostra a lista

        profissionais.forEach(profissional => {
            // Gerar o HTML para as habilidades
            let habilidadesHtml = '';
            if (profissional.habilidades && profissional.habilidades.length > 0) {
                profissional.habilidades.forEach(habilidade => {
                    habilidadesHtml += `<span class="badge badge-info badge-custom m-1">${habilidade}</span>`;
                });
            } else {
                habilidadesHtml = '<span class="badge badge-secondary m-1">Sem habilidades</span>';
            }

            const profissionalDiv = $(`
        <a data-toggle="modal" onclick="teste(${profissional.id})" data-target="#prof${profissional.id}" style="border:none;">
            <div class="prestador">
                <div class="h5-prestador">
                    <h5>${profissional.nome}</h5>
                </div>
                <div class="p-prestador">
                    <p>Clique para ver mais</p>
                </div>
                <span class="distancia">${profissional.distancia ? (Math.round(profissional.distancia * 100) / 100) + ' km' : 'Distância não disponível'}</span>
            </div>
        </a>
        <div class="modal modalprofissional" id="prof${profissional.id}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-lg">
                    <div class="modal-header justify-content-center">
                        <h4 class="modal-title" id="modalLabel">Perfil Profissional</h4>
                        <button type="button" class="close position-absolute" style="right: 15px;" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="card-body box-profile text-center">
                                <img style="margin-bottom:5%; border-radius:100%;" width="130px" height="130px"
                                     class="profile-user-img img-fluid img-circle" src="${profissional.imagem ? `https://storage.googleapis.com/profilepics-cn/${profissional.imagem}` : '/assets/img/perfilicon.png'}" alt="User profile picture">
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Nome</b>
                                        <h4 class="profile-username">${profissional.nome}</h4>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Celular</b>
                                        <span class="float-right">${profissional.celular ? profissional.celular : 'N/A'}</span>
                                    </li>
                                </ul>
                                <div class="form-group">
                                    <h5>Habilidades:</h5>
                                    <div id="skills-container" class="d-flex flex-wrap justify-content-center">
                                        ${habilidadesHtml}
                                    </div>
                                </div>
                                <div class="row text-center ml-5 mr-5">
                                    <div class="col-6 mb-2">
                                        <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" onclick="encontrarProfissional(${profissional.id})">
                                            <img src="/assets/img/celular.png" alt="Sobre" width="24" class="mr-2">Chamar
                                        </button>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <a class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" data-dismiss="modal" aria-label="Close">
                                            <img src="/assets/img/recusar.png" alt="Sobre" width="24" class="mr-2">Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `);

            listaContainer.append(profissionalDiv);
            let isPopupOpen = false;

            profissionalDiv.on('mouseover', function () {
                const marker = markers[profissional.id];
                if (marker && !isPopupOpen) {
                    marker.openPopup();
                    marker.setZIndexOffset(1000);
                    isPopupOpen = true;
                }
            });

            profissionalDiv.on('mouseout', function () {
                const marker = markers[profissional.id];
                if (marker && isPopupOpen) {
                    marker.closePopup();
                    marker.setZIndexOffset(0);
                    isPopupOpen = false;
                }
            });
        });
    }

    const markers = {}; // Objeto para armazenar os marcadores

    function mostrarProfissionaisNoMapa(response) {
        if (map) {
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker && layer !== userMarker) {
                    map.removeLayer(layer);
                }
            });
        }

        if (Array.isArray(response) && response.length > 0) {
            response.sort((a, b) => {
                return (a.distancia || Infinity) - (b.distancia || Infinity);
            });

            response.forEach(item => {
                const profissional = item;

                // Verifique se a latitude e a longitude não são nulas
                if (profissional.latitude !== null && profissional.longitude !== null) {
                    var color = 'red';
                    var awesomeIcon = 'star';
                    var geo = [profissional.latitude, profissional.longitude];

                    const marker = L.marker(geo, {
                        icon: L.AwesomeMarkers.icon({icon: awesomeIcon, prefix: 'fa', markerColor: color})
                    }).addTo(map)
                        .bindPopup(`${profissional.nome} - ${profissional.distancia ? profissional.distancia.toFixed(2) + ' km' : 'Distância não disponível'}`);

                    markers[profissional.id] = marker;
                }
            });

            mostrarLista(response);

            const clienteLatitude = userMarker.getLatLng().lat;
            const clienteLongitude = userMarker.getLatLng().lng;

            map.setView([clienteLatitude, clienteLongitude], 13);
        } else {
            console.warn("Nenhum profissional encontrado para as habilidades selecionadas.");
        }
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

    var pusher = new Pusher('8702b12d1675f14472ac', {
        cluster: 'sa1'
    });

    var channelCliente = pusher.subscribe('clientes_' + clienteId);
    console.log('Inscrito no canal: clientes_' + clienteId);

    channelCliente.bind('client:solicitacao_aceita', function(data) {
        console.log('Evento recebido:', data);
        window.location.href = '/chat?id=' + data.contrato_id + '&cliente_id=' + data.cliente_id + '&profissional_id=' + data.profissional_id;
    });




    function encontrarProfissional(id) {
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
    iniciarContagem();
    atualizarLocalizacao();
</script>
</body>
