


<?php

use App\Models\Endereco;

$id_cliente = 3;

$endereco = Endereco::where('id_cliente', $id_cliente)->first();

if ($endereco){

$coordenada = sprintf("%s, %s",$endereco->latitude, $endereco->longitude);
}
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
            width: 35%;
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
</head>
<body>
<div class='container-mapa'>
    <ul class="list-group">
      <li class="list-group-item disabled" aria-disabled="true">Cras justo odio</li>
      <li class="list-group-item">Dapibus ac facilisis in</li>
      <li class="list-group-item">Morbi leo risus</li>
      <li class="list-group-item">Porta ac consectetur ac</li>
      <li class="list-group-item">Vestibulum at eros</li>
    </ul>
    <gmpx-api-loader key="AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4" solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
    <gmp-map center="<?= $coordenada ?>" zoom="17" map-id="DEMO_MAP_ID">
        <div slot="control-block-start-inline-start" class="place-picker-container">
            <gmpx-place-picker placeholder="Enter an address"></gmpx-place-picker>
        </div>
        <gmp-advanced-marker></gmp-advanced-marker>
    </gmp-map>
</div>

<script>
    async function init() {
        await customElements.whenDefined('gmp-map');
        await customElements.whenDefined('gmpx-place-picker');
        await customElements.whenDefined('gmp-advanced-marker');

        const map = document.querySelector('gmp-map');
        const marker = document.querySelector('gmp-advanced-marker');
        const placePicker = document.querySelector('gmpx-place-picker');

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
            // High accuracy geolocation
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

    document.addEventListener('DOMContentLoaded', init);
</script>
</body>
