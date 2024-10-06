<?php

use App\Models\Contrato;
use App\Models\Usuario;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se o corpo da requisição é JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['cliente_id']) && isset($data['profissional_id'])) {
        $clienteId = $data['cliente_id'];
        $profissionalId = $data['profissional_id'];

        $contrato = new Contrato();
        $contrato->cliente_id = $clienteId;
        $contrato->profissional_id = $profissionalId;
        $contrato->status_contrato = 1;
        $contrato->save();

        echo json_encode(['message' => 'Solicitação de contrato enviada com sucesso!']);
        exit;
    } else {
        // Resposta de erro se os parâmetros não estiverem corretos
        http_response_code(400);
        echo json_encode(['error' => 'Dados insuficientes.']);
        exit;
    }
} else {
    // Resposta de erro se não for uma requisição POST
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
    exit;
}
