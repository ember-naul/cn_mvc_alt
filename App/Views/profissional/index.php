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

$_SESSION['pareando'] = "nao-pareando";

?>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/indexprofissional.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css"/>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
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
                <button class="btn btn-outline-custom btn-block" onclick="responderSolicitacao('aceitar')">Aceitar
                </button>
                <button class="btn btn-outline-custom btn-block" onclick="responderSolicitacao('recusar')">Recusar
                </button>
            </div>
        </div>

        <div id="background" class="hidden">

            <div class="container">
                <h3 class="hidden">Esperando por clientes...</h3>
                <div class="circle-wrapper hidden">
                    <div class="circle"></div>
                    <div class="gif-container">
                        <img src="/assets/img/waiting.gif" style="margin-bottom:16.5%" alt="Loading">
                        <div class="counter" id="counter">00:00</div>
                        <div class="cancel-wrapper" onclick="cancelarPareamento()">
                            <img src="/assets/img/cancelar.png" alt="Cancelar">
                            <div class="cancel-text">Cancelar</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($_SESSION['pareando'] != "pareando") : ?>
            <button id="iniciar-pareamento" class="btn btn-outline-custom" onclick="iniciarPareamento()">Iniciar
                Pareamento
            </button>
        <?php endif; ?>
    </div>
</div>

<script>
    var profissionalId = '<?php echo $_SESSION['profissional_id']; ?>';
</script>
<script src="/assets/js/profissional.js"></script>
</body>

