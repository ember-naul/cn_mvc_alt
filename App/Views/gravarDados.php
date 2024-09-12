<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['latitude']) && isset($_GET['longitude'])) {
        $latitude = $_GET['latitude'];
        $longitude = $_GET['longitude'];
        echo json_encode(['status' => 'success', 'message' => 'Dados recebidos com sucesso']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Parametros ausentes']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metodo de solicitacao invalido <br>']);
}
echo($latitude ." <br> ". $longitude);

if (isset($latitude) || isset($longitude)){
    echo($latitude ." <br> ". $longitude);
} else {
    echo " <br> Não está chegando nada <br>";
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "POST está chegando";
} else {
    echo " <br> POST não está chegando ou ele está vindo como um método diferente de POST <br>";
}


?>
