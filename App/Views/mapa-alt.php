<?php 
namespace App\Views;
use App\Models\Endereco;
use Pusher\Pusher;

// Configuração do Pusher
$options = array(
    'cluster' => 'sa1',
    'useTLS' => true
);
$pusher = new Pusher(
    '8702b12d1675f14472ac', 
    '0e7618b4f23dcfaf415c', 
    '1863692',              
    $options
);

// Coordenadas para simular o envio
$lat = $_GET['lat'] ?? -22.75018277640317;
$lng = $_GET['lng'] ?? -47.350570084675404;

// Cria os dados para enviar
$data = array(
    'lat' => $lat,
    'lng' => $lng
);

// Envia o evento para o Pusher
$pusher->trigger('location-channel', 'update-location', $data);

echo json_encode(['status' => 'success', 'lat' => $lat, 'lng' => $lng]);


// $latitude = $_GET['latitude'] ?? 'não fornecida';
// $longitude = $_GET['longitude'] ?? 'não fornecida';

// $endereco = new Endereco();

// $endereco->latitude = $latitude;
// $endereco->longitude = $longitude;
// $endereco->save();

// echo "A sua latitude é: $latitude, e a sua longitude é $longitude"; 
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
        }

        gmp-map {
            height: 40rem;
            width: 100%;
            margin: auto;
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        .place-picker-container {
            padding: 20px;
        }

        gmp-advanced-marker {
            border-radius: 50%;
        }

        .container-mapa {
            display: flex;
            width: 100%;
        }
    </style>
	<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
	 
</head>
<body>
<gmpx-api-loader key="AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4" solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
    <gmp-map center="37.4219983,-122.084" zoom="17" map-id="DEMO_MAP_ID" id="map">
        <div slot="control-block-start-inline-start" class="place-picker-container">
            <gmpx-place-picker placeholder="Enter an address"></gmpx-place-picker>
        </div>
        <gmp-advanced-marker></gmp-advanced-marker>
    </gmp-map>
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

    function sendCoordinates() {
    let lat = -22.75018277640317;
    let lng = -47.350570084675404;

    setInterval(() => {
        // Envia coordenadas por AJAX
        fetch(`send_coordinates.php?lat=${lat}&lng=${lng}`)
            .then(response => response.json())
            .then(data => {
                console.log('Coordenadas enviadas:', data);
                // Simular pequena variação nas coordenadas
                lat += 0.0001;
                lng += 0.0001;
            })
            .catch(error => console.error('Erro ao enviar coordenadas:', error));
    }, 3000); // Intervalo de 3 segundos
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
    // document.addEventListener('DOMContentLoaded', sendCoordinates);
</script>
</body>
