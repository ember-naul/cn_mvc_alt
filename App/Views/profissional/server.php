<?php
require_once __DIR__ . "/../../../vendor/autoload.php";

// Configurações do Pusher
$options = [
    'cluster' => 'sa1',
    'useTLS' => true,
];

$pusher = new Pusher\Pusher(
    '8702b12d1675f14472ac',
    '0e7618b4f23dcfaf415c',
    '1863692',
    $options
);

function pairUsers($clientLocation)
{
    // Lógica para encontrar profissionais mais próximos com base na localização
    // Suponha que você tenha uma função que retorna profissionais próximos

    $matchedProfessionals = findNearbyProfessionals($clientLocation);

    // Envie as informações de pareamento para os clientes via Pusher
    $data = [
        'professionals' => $matchedProfessionals,
    ];

    $pusher->trigger('pairing-channel', 'new-pairing', $data);
}

// Exemplo de chamada da função de pareamento
if (isset($_POST['location'])) {
    $clientLocation = $_POST['location'];
    pairUsers($clientLocation);
}
