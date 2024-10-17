<?php
// server.php
session_start();
$locations = [];

// Captura da localização via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $latitude = $input['latitude'];
    $longitude = $input['longitude'];

    // Atualiza a localização do usuário
    $locations[$_SESSION['user_id']] = ['latitude' => $latitude, 'longitude' => $longitude];

    // Aqui você poderia emitir um evento do Pusher
    // Pusher::trigger('location-channel', 'location-updated', $locations);

    echo json_encode(['status' => 'success']);
}

// Função para encontrar usuários próximos
function findNearbyUsers($userLatitude, $userLongitude, $maxDistance) {
    global $locations;
    $nearbyUsers = [];

    foreach ($locations as $userId => $coords) {
        $distance = haversineGreatCircleDistance($userLatitude, $userLongitude, $coords['latitude'], $coords['longitude']);
        if ($distance <= $maxDistance) {
            $nearbyUsers[] = $userId;
        }
    }
    return $nearbyUsers;
}
