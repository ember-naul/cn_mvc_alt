<!DOCTYPE html>
<html>
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
    </style>
</head>
<body>
    <gmpx-api-loader key="AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4" solution-channel="GMP_GE_mapsandplacesautocomplete_v1"></gmpx-api-loader>
    <gmp-map center="40.749933,-73.98633" zoom="13" map-id="DEMO_MAP_ID">
        <div slot="control-block-start-inline-start" class="place-picker-container">
            <gmpx-place-picker placeholder="Enter an address"></gmpx-place-picker>
        </div>
        <gmp-advanced-marker></gmp-advanced-marker>
    </gmp-map>

    <script>
        async function init() {
            await customElements.whenDefined('gmp-map');
            await customElements.whenDefined('gmpx-place-picker');
            await customElements.whenDefined('gmp-advanced-marker');

            const map = document.querySelector('gmp-map');
            const marker = document.querySelector('gmp-advanced-marker');
            const placePicker = document.querySelector('gmpx-place-picker');
            const infowindow = new google.maps.InfoWindow();

            map.innerMap.setOptions({
                mapTypeControl: false
                
            });

            placePicker.addEventListener('gmpx-placechange', () => {
                const place = placePicker.value;

                if (!place.location) {
                    window.alert("No details available for input: '" + place.name + "'");
                    infowindow.close();
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
                infowindow.setContent(
                    `<strong>${place.displayName}</strong><br>
                     <span>${place.formattedAddress}</span>`
                );
                infowindow.open(map.innerMap, marker);
            });

            // Check for Geolocation
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        const userLocation = { lat: latitude, lng: longitude };
                        map.center = userLocation;
                        map.zoom = 15;
                        marker.position = userLocation;
                    },
                    (error) => {
                        console.error("Error obtaining location: " + error.message);
                    }
                );
            } else {
                window.alert("Esse navegador não suporta o mapa.");
            }
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>
