<?php 
namespace App\Views;
use App\Models\Endereco;

$latitude = $_GET['latitude'] ?? 'não fornecida';
$longitude = $_GET['longitude'] ?? 'não fornecida';

$endereco = new Endereco();

$endereco->latitude = $latitude;
$endereco->longitude = $longitude;
$endereco->save();

?>
<head>
    <meta charset="utf-8">
    <title>Google Maps Example</title>
    <script type="module" src="https://unpkg.com/@googlemaps/extended-component-library@0.6"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
           
        }

        .container-mapa {
            display: flex;
            height: 100%;
            width: 80%;
            margin: auto;
            
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
            width: 35%;
            background-color: #f9f9f9;
            padding: 10px;
            overflow-y: auto; 
            border-right: 1px solid #ddd;
            height: 100%; 
            max-height: 45rem; 
        }


        .prestador {
            display: flex;
            flex-direction: column;
            background-color: white;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            text-align: left;
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
            margin-bottom: 10px;
        }

        .prestador h3, .prestador p {
            margin: 0;
        }

        .prestador .distancia {
            margin-top: 5px;
            font-size: 0.9em;
            color: #888;
        }

            @media (max-width: 768px) {

            gmp-map{
                flex: 1;
                height: 29rem;
                width: 100%;
                margin: auto;
                border: 2px solid #ddd;
                border-radius: 10px;
            }
            .container-mapa {
                display: flex;
                height: 100%;
                width: 100%;
                margin: auto;
            }
            h3 {
                font-size: 1.4rem;
                margin: auto;
            }
            .prestadores-container {
                width: 100%;
                height: auto;
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 20px 20px 0 0;
                padding-bottom: 20px;
                max-height: 40%;
                z-index: 999;
            }
            .prestador {
                flex-direction: row;
                align-items: center;
            }

            .prestador img {
                margin-right: 10px;
            }
        }
    </style>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>
    <div class="container-mapa">
        <div class="prestadores-container">
            <div class="prestador" onclick="handlePrestadorClick(1)">
                <img src="/assets/img/florista.webp" alt="Maria Souza">
                <h3>Maria Souza</h3>
                <p>47 anos - Florista</p>
                <span class="distancia">5.2 km</span>
            </div>
            <div class="prestador" onclick="handlePrestadorClick(2)">
                <img src="/assets/img/eletricista.jpg" alt="Bruno Souza">
                <h3>Bruno Souza</h3>
                <p>32 anos - Eletricista</p>
                <span class="distancia">3.4 km</span>
            </div>
            <div class="prestador" onclick="handlePrestadorClick(3)">
                <img src="/assets/img/cozinheiro.jpg" alt="Kevin Matos">
                <h3>Kevin Matos</h3>
                <p>53 anos - Cozinheiro</p>
                <span class="distancia">8.2 km</span>
            </div>
            <div class="prestador" onclick="handlePrestadorClick(4)">
                <img src="/assets/img/jardineiro.jpg" alt="Wesley Silva">
                <h3>Wesley Silva</h3>
                <p>27 anos - Jardineiro</p>
                <span class="distancia">5.2 km</span>
            </div>
            <div class="prestador" onclick="handlePrestadorClick(5)">
                <img src="/assets/img/eletricista.jpg" alt="KOKIMOTO">
                <h3>Kokimoto SILVA</h3>
                <p>50 anos - Japones</p>
                <span class="distancia">5.2 km</span>
            </div>
        </div>

        <gmpx-api-loader key="AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4" solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
        <gmp-map center="37.4219983,-122.084" zoom="17" map-id="DEMO_MAP_ID" id="map">
            <div slot="control-block-start-inline-start" class="place-picker-container">
                <gmpx-place-picker placeholder="Enter an address"></gmpx-place-picker>
            </div>
            <gmp-advanced-marker></gmp-advanced-marker>
        </gmp-map>
    </div>
<script>
    let map, marker, placePicker;

    async function init() {
        await customElements.whenDefined('gmp-map');
        await customElements.whenDefined('gmpx-place-picker');
        await customElements.whenDefined('gmp-advanced-marker');

        map = document.querySelector('gmp-map');
        marker = document.querySelector('gmp-advanced-marker');
        placePicker = document.querySelector('gmpx-place-picker');

        map.innerMap.setOptions({
            mapTypeControl: false
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
                            
                        const userLocation = { lat: latitude, lng: longitude };
                        const correctedLocation = await verifyCoordinates(userLocation);

                        map.center = correctedLocation;
                        map.zoom = 16;
                        marker.position = correctedLocation;
                    },
                    (error) => {
                        console.error("Error obtaining location: " + error.message);
                    },
                    { enableHighAccuracy: true }
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

		channel.bind('my-event', function(data) {
			try {
				const { lat, lng } = data;
				updateMap(lat, lng);
			} catch (e) {
				console.error("Failed to parse JSON:", e.message);
			}
		});
	}

    function updateMap(lat, lng) {
	
		const newLocation = { lat, lng };

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
</body>