<?php
require_once __DIR__ . "/../../../vendor/autoload.php";
require_once __DIR__ . "/server.php";
use App\Models\Profissional;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profissionalId = $_SESSION['profissional_id'];

    $lat = $_POST['latitude'];
    $lon = $_POST['longitude'];

    $profissional = Profissional::find($profissionalId);
    if ($profissional) {
        $profissional->latitude = $lat;
        $profissional->longitude = $lon;
        $profissional->save();

        $options = [
            'cluster' => 'sa1',
            'useTLS' => true
        ];
        $pusher = new Pusher\Pusher(
            '8702b12d1675f14472ac',
            '0e7618b4f23dcfaf415c',
            '1863692',
            $options
        );

        $data['latitude'] = $lat;
        $data['longitude'] = $lon;
        $pusher->trigger('profissional-channel', 'localizacao-atualizada', $data);

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
