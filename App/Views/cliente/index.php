<?php
namespace App\Views\cliente;

namespace App\Views\cliente;

use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Habilidade;
use App\Models\Usuario;
use App\Models\Endereco;

$usuario = Usuario::find($_SESSION['id_usuario']);
$cliente = Cliente::where('id_usuario', $usuario->id)->first();
$profissionais = Profissional::with('habilidades')->get();
$_SESSION['cliente_id'] = $cliente->id;
?>
<head>
    <meta charset="utf-8">
    <title>Google Maps Example</title>
    <script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6"></script>
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

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            /*overflow-y: hidden;*/
            overflow: auto; /* Alterado para auto */
        }

        .container-mapa {
            display: flex;
            height: 100%;
            width: 80%;
            margin: auto;
            flex-wrap: wrap;
        }

        gmp-map {
            flex: 1;
            height: 45rem;
            width: 100%;
            margin: auto;
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        .prestadores-container {
            display: flex;
            flex-direction: column;
            width: 28%;
            max-height: 45rem; /* Mesma altura do mapa */
            overflow-y: auto;
            overflow-x: hidden;
            box-sizing: border-box; /* Inclui padding e border no cálculo do tamanho */
            margin: auto;
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

        .prestador:hover {
            transform: scale(1.02);
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

        @media (max-width: 768px) {
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden; /* Desativa a rolagem geral */
            }

            .container-mapa {
                flex-direction: column;
                width: 768px;
                height: 45%;
                /*height: calc(100% - 100px);*/
                margin: 0; /* Usa a altura total da tela */
                margin-bottom: 100%;
            }


            gmp-map {
                height: 50%;
                width: 54%;
                margin: 0;
                order: 2;
            }

            .prestadores-container {
                width: 100%;
                max-height: 39.4%; /* Adjust height for mobile */
                margin: 0; /* Remove margin */
                border-radius: 20px 20px 0 0; /* Rounded corners on top */
                position: fixed; /* Fixed at bottom */
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

            .p-prestador, .distancia {
                font-size: 0.8em;
            }
        }

        .zoom-controls {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }

        .zoom-controls button {
            margin: 3px;
            padding: 13px;
            background-color: #3d4d6a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .zoom-controls button:hover {
            background-color: #2b3a50;
        }

    </style>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>
<div class="search">
    <gmpx-place-picker placeholder="Digite seu endereço."></gmpx-place-picker>
</div>

<div class="container-mapa">
    <gmpx-api-loader key="AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4"
                     solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
    <gmp-map center="37.4219983,-122.084" zoom="17" map-id="DEMO_MAP_ID" id="map">
        <div slot="control-block-start-inline-start" class="place-picker-container">
            <div class="zoom-controls">
                <button id="zoom-in">+</button>
                <button id="zoom-out">-</button>
            </div>
        </div>
        <gmp-advanced-marker></gmp-advanced-marker>
    </gmp-map>
    <?php
        
        // foreach ($profissionais as $profissional) {
        //     $cont = 1;
        //     $nomeUsuario = $profissional->usuario ? $profissional->usuario->nome : 'Usuário não encontrado';
        //     echo "Nome do Profissional: " . $nomeUsuario . "<br>";
        //     echo "Habilidades: \n";
        
        //     foreach ($profissional->habilidades as $habilidade) {
                
        //         echo " $cont- \n" . $habilidade->nome . " - \n"; // ajuste o campo 'nome' conforme sua tabela
        //         $cont++;
        //     }
            
        //     echo "<br>"; 
        // }
        ?>
    <div class="prestadores-container">
         <?php 
         foreach ($profissionais as $profissional):
            
         $nomeUsuario = $profissional->usuario ? $profissional->usuario->nome : 'Usuário não encontrado';?>
        <div class="prestador" onclick="handlePrestadorClick(1)">
            <img src="/assets/img/eletricista.jpg" alt="bruno">
            <div class="h5-prestador">
                <h5><?= $nomeUsuario ?></h5>
            </div>
            <div class="p-prestador">
                <?php foreach($profissional->habilidades as $habilidade):?>
                    
                <p><?= $habilidade->nome . " ";?></p>
                <?php endforeach; ?>
            </div>
            <span class="distancia">5.2 km</span>
        </div>
        <?php endforeach; ?>
        
        
        <div class="prestador" onclick="handlePrestadorClick(1)">
            <img src="/assets/img/eletricista.jpg" alt="bruno">
            <div class="h5-prestador">
                <h5>Bruninho</h5>
            </div>
            <div class="p-prestador">
                <p>50 anos - Jardinista</p>
            </div>
            <span class="distancia">5.2 km</span>
        </div>
        <div class="prestador" onclick="handlePrestadorClick(1)">
            <img src="/assets/img/eletricista.jpg" alt="bruno">
            <div class="h5-prestador">
                <h5>gdfgfdgfd</h5>
            </div>
            <div class="p-prestador">
                <p>50 anos - Jardinista</p>
            </div>
            <span class="distancia">5.2 km</span>
        </div>
        <div class="prestador" onclick="handlePrestadorClick(1)">
            <img src="/assets/img/eletricista.jpg" alt="bruno">
            <div class="h5-prestador">
                <h5>hgfhgfh</h5>
            </div>
            <div class="p-prestador">
                <p>50 anos - Jardinista</p>
            </div>
            <span class="distancia">5.2 km</span>
        </div>
        <div class="prestador" onclick="handlePrestadorClick(1)">
            <img src="/assets/img/eletricista.jpg" alt="bruno">
            <div class="h5-prestador">
                <h5>cxzczxc</h5>
            </div>
            <div class="p-prestador">
                <p>57 anos - Jardinista</p>
            </div>
            <span class="distancia">5.2 km</span>
        </div>
        
        
        <!-- Mais prestadores... -->

    </div>
</div>

<script>
    let map, marker, placePicker;
    document.getElementById('zoom-in').addEventListener('click', () => {
        map.zoom += 1;
    });

    document.getElementById('zoom-out').addEventListener('click', () => {
        map.zoom -= 1;
    });

    async function init() {
        await customElements.whenDefined('gmp-map');
        await customElements.whenDefined('gmpx-place-picker');
        await customElements.whenDefined('gmp-advanced-marker');

        map = document.querySelector('gmp-map');
        marker = document.querySelector('gmp-advanced-marker');
        placePicker = document.querySelector('gmpx-place-picker');

        map.innerMap.setOptions({
            mapTypeControl: false,
            gestureHandling: 'greedy'
        });

        placePicker.addEventListener('gmpx-placechange', () => {
            const place = placePicker.value;

            if (!place.location) {
                window.alert("No details available for input: '" + place.name + "'");
                marker.position = null;
                return;
            }

            if (place.viewport) {
                map.innerMap.fitBounds(place.viewport);
            } else {
                map.center = place.location;
                map.zoom = 24;
            }

            marker.position = place.location;
        });

        try {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        const userLocation = {lat: latitude, lng: longitude};
                        const correctedLocation = await verifyCoordinates(userLocation);

                        map.center = correctedLocation;
                        map.zoom = 16;
                        marker.position = correctedLocation;
                    },
                    (error) => {
                        console.error("Error obtaining location: " + error.message);
                    },
                    {enableHighAccuracy: true}
                );
            } else {
                window.alert("Esse navegador não suporta o mapa.");
            }
        } catch (error) {
            console.error("Error: " + error.message);
        }

        // Initialize Pusher
        initializePusher();
    }

    async function verifyCoordinates(location) {
        const apiKey = 'AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4';
        const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${location.lat},${location.lng}&key=${apiKey}`;

        const response = await fetch(url);
        const data = await response.json();

        if (data.status === 'OK') {
            const result = data.results[0].geometry.location;
            console.log("Geocoding result:", result);
            return {
                lat: result.lat,
                lng: result.lng
            };
        } else {
            throw new Error('Geocoding failed: ' + data.status);
        }
    }

    function initializePusher() {
        Pusher.logToConsole = true;

        var pusher = new Pusher('8702b12d1675f14472ac', {
            cluster: 'sa1'
        });

        var channel = pusher.subscribe('my-channel');

        channel.bind('my-event', function (data) {
            try {
                const {lat, lng} = data;
                updateMap(lat, lng);
            } catch (e) {
                console.error("Failed to parse JSON:", e.message);
            }
        });
    }

    function updateMap(lat, lng) {

        const newLocation = {lat, lng};

        if (typeof lat === 'number' && typeof lng === 'number') {
            map.center = newLocation;

            marker.position = newLocation;

            map.zoom = 16;
        } else {
            console.error("Invalid coordinates provided for the map update.");
        }
    }

    document.addEventListener('DOMContentLoaded', init);


</script>
<footer id="footer">
    <!-- conteúdo do footer -->
</footer>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var footer = document.getElementById('footer');
        if (footer) {
            footer.style.display = 'none'; // Oculta o footer
        }
    });
</script>
