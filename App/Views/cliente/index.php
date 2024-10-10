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

<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
<style>
    /* Suas estilizações existentes... */
</style>
<link href="/assets/css/index.css" rel="stylesheet">

<body>
<div class="container-mapa">
    <div id="map" style="display:none"></div>
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
        </div>
    </div>
</div>

<script>
    var map;
    var userMarker;
    const clienteId = '<?php echo $_SESSION['cliente_id']; ?>';

    function initializeMap(lat, lon) {
        map = L.map('map').setView([lat, lon], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        userMarker = L.marker([lat, lon]).addTo(map);
        document.getElementById('map').style.display = 'block';
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
                if (response.error) {
                    console.error(response.error);
                    alert(response.error);
                    return;
                }
                mostrarProfissionaisNoMapa(response);
            },
            error: function (xhr, status, error) {
                console.error("Erro na requisição:", status, error);
            }
        });
    }

    function mostrarProfissionaisNoMapa(profissionais) {
        if (map) {
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker && layer !== userMarker) {
                    map.removeLayer(layer);
                }
            });
        }
        // Verifica se 'profissionais' é um array e não está vazio
        if (Array.isArray(profissionais) && profissionais.length > 0) {
            profissionais.forEach(item => {
                const profissional = item.profissional;
                const distancia = item.distancia;

                L.marker([profissional.latitude, profissional.longitude])
                    .addTo(map)
                    .bindPopup(`${profissional.usuario.nome} - ${distancia.toFixed(2)} km`);
            });

            // Ajusta a visão do mapa para incluir todos os marcadores
            var bounds = L.latLngBounds();
            profissionais.forEach(item => {
                bounds.extend([item.profissional.latitude, item.profissional.longitude]);
            });
            map.fitBounds(bounds);
        } else {
            console.log(profissionais + "a");
            // console.warn("Nenhum profissional encontrado para as habilidades selecionadas.");
        }
    }


    function start() {
        navigator.geolocation.getCurrentPosition(success, error);
    }

    function success(pos) {
        var lat = pos.coords.latitude;
        var lon = pos.coords.longitude;
        initializeMap(lat, lon);
    }

    function error(err) {
        console.error("Erro ao obter localização:", err);
    }

    start(); // Inicializa o mapa na carga da página
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
    });
</script>
</body>
