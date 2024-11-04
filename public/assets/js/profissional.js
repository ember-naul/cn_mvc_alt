var map;
var marker;
var firstUpdate = true;
var tempoEmSegundos = 0;
let startTime;
const counterElement = document.getElementById('counter');

let timerInterval;


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

function updateCounter() {
    const elapsed = Math.floor((Date.now() - startTime) / 1000);
    const minutes = String(Math.floor(elapsed / 60)).padStart(2, '0');
    const seconds = String(elapsed % 60).padStart(2, '0');
    counterElement.textContent = `${minutes}:${seconds}`;
}


window.addEventListener('beforeunload', function () {
    switchParear('nao-pareando');
});

function iniciarPareamento() {
    startTime = Date.now();
    const background = document.getElementById('background');
    if (background) {
        background.classList.remove('hidden');

        const header = document.querySelector('#background h3');
        if (header) {
            header.classList.remove('hidden');
        }

        const circleWrapper = document.querySelector('#background .circle-wrapper');
        if (circleWrapper) {
            circleWrapper.classList.remove('hidden');
        }

        const counter = document.querySelector('.counter');
        if (counter) {
            counter.classList.remove('hidden');
        }

        const cancelWrapper = document.querySelector('.cancel-wrapper');
        if (cancelWrapper) {
            cancelWrapper.classList.remove('hidden');
        }

        const iniciarButton = document.getElementById('iniciar-pareamento');
        if (iniciarButton) {
            iniciarButton.classList.add('hidden');
        }

        iniciarContagem(); // Inicia a contagem
        setInterval(updateCounter, 1000);
        switchParear('pareando');
    } else {
        console.error('Elemento background não encontrado');
    }
}

function cancelarPareamento() {
    document.getElementById('background').classList.add('hidden');
    document.getElementById('iniciar-pareamento').classList.remove('hidden');

    document.querySelector('#background h3').classList.add('hidden');
    document.querySelector('#background .circle-wrapper').classList.add('hidden');
    document.querySelector('.counter').classList.add('hidden');
    document.querySelector('.cancel-wrapper').classList.add('hidden');

    pararTimer(); // Para o temporizador
    switchParear('nao-pareando');
}


function switchParear(acao) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/retornar_estado', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    var params = 'acao=' + encodeURIComponent(acao);
    console.log(params);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log("Estado do profissional: " + response.status);
            } else {
                console.error("Erro ao recuperar o estado: " + xhr.status);
            }
        }
    };
    xhr.send(params);
}


var pusher = new Pusher('8702b12d1675f14472ac', {
    cluster: 'sa1',
    useTLS: true
});

var channel = pusher.subscribe('contratos');


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

document.addEventListener("DOMContentLoaded", function () {
    iniciarContagem();
    const aceitarClienteElement = document.getElementById('aceitar-cliente');
    const background = document.getElementById('background');
    const cancelWrapper = document.querySelector('.cancel-wrapper');
    const counterElement = document.getElementById('counter');

    // Função para adicionar a classe 'hidden' se o elemento existir
    function addHidden() {
        if (aceitarClienteElement) {
            aceitarClienteElement.classList.add('hidden');
        }
        if (background) {
            background.classList.remove('hidden'); // Mostrar o background
        }
        if (cancelWrapper) {
            cancelWrapper.classList.remove('hidden'); // Mostrar o botão de cancelar
        }
    }

    // Função para remover a classe 'hidden' se o elemento existir
    function removeHidden() {
        if (aceitarClienteElement) {
            aceitarClienteElement.classList.remove('hidden');
        }
        if (background) {
            background.classList.add('hidden'); // Ocultar o background
        }
        if (cancelWrapper) {
            cancelWrapper.classList.add('hidden');
        }
        pararTimer(); // Para o temporizador
    }

    addHidden(); // Chama para esconder os elementos inicialmente

    // Bind no canal do Pusher
    channel.bind('nova-solicitacao', function (data) {
        if (parseInt(data.profissional_id) === parseInt(profissionalId)) {
            removeHidden(); // Mostra os elementos quando uma nova solicitação for recebida

            // Atualiza os elementos de nome e imagem
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
                } else if (acao === 'recusar') {
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