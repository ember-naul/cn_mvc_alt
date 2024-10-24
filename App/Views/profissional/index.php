<?php
namespace App\Views\profissional;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;
use Pusher\Pusher;

$usuario = Usuario::find($_SESSION['id_usuario']);
$profissional = Profissional::where('id_usuario', $usuario->id)->first();
$_SESSION['profissional_id'] = $profissional->id;

?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/indexprofissional.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css"/>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    
    <style>
        .hidden {
            display: none !important;
        }

        .circle-wrapper {
            position: relative;
            width: 40vmin;
            height: 40vmin;
            margin: 0 auto;
        }
        .circle {
            position: absolute;
            width: 80%;
            height: 80%;
            border-radius: 50%;
            border: 5px solid #60c5ff;
            border-top: 5px solid transparent;
            animation: spin 2s linear infinite;
        }
        .gif-container {
            margin:auto;
        }
        .gif-container img {
            margin-top:8%;
            width: 80%;
            height: 80%;
            object-fit: cover;
        }
        .counter {
            font-size: 2vw;
            margin-top: 1rem;
        }
        .cancel-wrapper {
            display: inline-block;
            margin-top: 2rem;
            cursor: pointer;
            text-align: center;
            width: 10%;
        }
        .cancel-wrapper img {
            width: 50%;
            height: 50%;
        }
        .cancel-wrapper img:hover {
            opacity: 0.7;
        }
        .cancel-text {
            margin-top: 0.5rem;
            font-size: 1vw;
            color: #ff0000;
        }
        h3 {
            font-size: 1.5vw;
            margin-bottom: 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @media screen and (max-width: 768px) {
            .container {
                padding: 5%; /* Diminui o padding em telas pequenas */
            }

            .circle-wrapper {
                width: 70vmin; /* Ajusta o tamanho em telas pequenas */
                height: 70vmin;
            }

            .counter {
                font-size: 5vw; /* Aumenta ainda mais em dispositivos móveis */
            }

            .cancel-wrapper {
                width: 30%; /* Ajusta a largura */
            }

            h3 {
                font-size: 6vw; /* Ajusta o tamanho da fonte */
            }
            .cancel-text {
                font-size: 2.5vw;
            }
        }
    </style>
</head>
<body>
<div class="container-mapa">
    <div id="map"></div>
    <div class="aceitar-container">
        <div id="aceitar-cliente" class="aceitar-cliente hidden">
            <div class="user-container">
                <img width="150px" height="150px" src="/assets/img/perfilicon.png" alt="Descrição da Imagem">
            </div>
            <div class="user-container calltext">
                <h2></h2>
            </div>
            <div class="imagem-container">
                <img src="/assets/img/profissionalgif.gif" alt="Descrição da Imagem">
            </div>
            <div class="container-bottom">
                <button class="btn btn-outline-custom btn-block" onclick="responderSolicitacao('aceitar')">Aceitar</button>
                <button class="btn btn-outline-custom btn-block" onclick="responderSolicitacao('recusar')">Recusar</button>
            </div>
        </div>
        <div id="background" class="hidden">
            <div class="container">
                <h3 class="hidden">Esperando por clientes...</h3>
                <div class="circle-wrapper hidden">
                    <div class="circle"></div>
                    <div class="gif-container">
                    <img src="/assets/img/waiting.gif" style="margin-bottom:16.5%" alt="Loading">
                    <div class="counter hidden" id="counter">00:00</div>   
                        <div class="cancel-wrapper hidden" onclick="cancelarPareamento()">
                        <img src="/assets/img/cancelar.png" alt="Cancelar">
                        <div class="cancel-text">Cancelar</div>
                        </div>
                    </div>
                </div>
                <div class='bghidden'>
                    
                    
                </div>
            </div>
        </div>
        <button id="iniciar-pareamento" class="btn btn-outline-custom" onclick="iniciarPareamento()">Iniciar Pareamento</button>
    </div>
</div>

<script>
    var map;
    var marker;
    var routingControl;
    var firstUpdate = true;
    var profissionalId = '<?php echo $_SESSION['profissional_id']; ?>';
    var tempoEmSegundos = 0;
    let startTime;
    const counterElement = document.getElementById('counter');

    function updateCounter() {
        const elapsed = Math.floor((Date.now() - startTime) / 1000);
        const minutes = String(Math.floor(elapsed / 60)).padStart(2, '0');
        const seconds = String(elapsed % 60).padStart(2, '0');
        counterElement.textContent = `${minutes}:${seconds}`;
    }

    function iniciarPareamento() {
        startTime = Date.now();
        document.getElementById('background').classList.remove('hidden');
        
        // Remover a classe hidden dos elementos de timer e cancelamento
        document.querySelector('#background h3').classList.remove('hidden');
        document.querySelector('#background .circle-wrapper').classList.remove('hidden');
        document.querySelector('.counter').classList.remove('hidden'); // Mostrar o contador
        document.querySelector('.cancel-wrapper').classList.remove('hidden'); // Mostrar o botão de cancelar

        document.getElementById('iniciar-pareamento').classList.add('hidden');
        setInterval(updateCounter, 1000);
        switchParear();
        iniciarContagem(); // Iniciar contagem de tempo
    }

    function cancelarPareamento() {
        document.getElementById('background').classList.add('hidden');
        document.getElementById('iniciar-pareamento').classList.remove('hidden');

        // Adicionar a classe hidden aos elementos de timer e cancelamento
        document.querySelector('#background h3').classList.add('hidden');
        document.querySelector('#background .circle-wrapper').classList.add('hidden');
        document.querySelector('.counter').classList.add('hidden'); // Ocultar o contador
        document.querySelector('.cancel-wrapper').classList.add('hidden'); // Ocultar o botão de cancelar

        pararTimer(); // Parar a contagem
        switchParear();
    }


    var pusher = new Pusher('8702b12d1675f14472ac', {
        cluster: 'sa1',
        useTLS: true
    });

    var channel = pusher.subscribe('contratos');

    function switchParear() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/retornar_estado', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log("Raw response:", xhr.responseText);

                    var response = JSON.parse(xhr.responseText);
                    console.log("Estado do profissional: " + response.status);
                } else {
                    console.error("Erro ao recuperar o estado: " + xhr.status);
                }
            }
        };
        xhr.send();
    }

    function iniciarContagem() {
        timerInterval = setInterval(function () {
            tempoEmSegundos++;
            if (tempoEmSegundos % 5 === 0) {
                atualizarLocalizacao();
            }
        }, 1000);
    }
    function pararTimer() {
        clearInterval(timerInterval);
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
        iniciarContagem();
        const aceitarClienteElement = document.getElementById('aceitar-cliente');
        const background = document.getElementById('background');
        const cancelWrapper = document.querySelector('.cancel-wrapper');
        addHidden();

        function addHidden() {
            if (aceitarClienteElement) {
                aceitarClienteElement.classList.add('hidden');
                background.classList.remove('hidden'); // Mostrar o background
                cancelWrapper.classList.remove('hidden'); // Mostrar o botão de cancelar
            }
        }

        function removeHidden() {
            if (aceitarClienteElement) {
                aceitarClienteElement.classList.remove('hidden');
                background.classList.add('hidden'); // Ocultar o background
                cancelWrapper.classList.add('hidden');
                pararTimer();
            } else {
                console.error('Elemento não encontrado: aceitar-cliente');
            }
        }

        channel.bind('nova-solicitacao', function (data) {
            if (parseInt(data.profissional_id) === parseInt(profissionalId)) {
                removeHidden();

                const clienteNome = data.cliente_nome ? `Você recebeu um chamado de(a) ${data.cliente_nome}` : '';
                const clienteImg = data.cliente_img ? `https://storage.googleapis.com/profilepics-cn/${data.cliente_img}` : '/assets/img/perfilicon.png';

                const imgElement = document.querySelector('#aceitar-cliente .user-container img');
                const nameElement = document.querySelector('#aceitar-cliente .user-container h2');

                if (imgElement && nameElement) {
                    imgElement.src = clienteImg;
                    nameElement.textContent = clienteNome;
                }
            } else {
                addHidden();
            }
        });

    });

    function responderSolicitacao(acao) {
            const params = new URLSearchParams();
            params.append('acao', acao);
            params.append('profissional_id', profissionalId);

            fetch('/api/responder_solicitacao', {
                method: 'POST',
                body: params,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then(response => {
                    return response.text()
                })
                .then(data => {
                    try {
                        const jsonData = JSON.parse(data);
                        if (acao === 'aceitar') {
                            window.location.href = '/chat?id=' + jsonData.contrato_id + '&cliente_id=' + jsonData.cliente_id + '&profissional_id=' + profissionalId;
                        } else if (acao === 'recusar'){
                            const aceitarClienteElement = document.getElementById('aceitar-cliente');
                            aceitarClienteElement.classList.add('hidden');
                        }
                    } catch (e) {
                        console.error('Erro ao analisar JSON:', e);
                    }
                })
                .catch(error => console.error('Error:', error));

        }
    atualizarLocalizacao();
</script>
</body>

