<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Profissional;
use Pusher\Pusher;

class JsonController
{

    public function buscarProfissionais($vars)
    {
        // Captura o ID da variável de rota

        $id = $vars['id'] ?? null;
        $data_inicio = date('Y-m-d H:i:s');
        if ($id !== null) {
            $cliente = Cliente::where("id_usuario", "=", $_SESSION["id_usuario"])->first();
            $profissional = Profissional::where("id", "=", $id)->first();

            // Configurar o cabeçalho da resposta
            header('Content-Type: application/json');
            $pusher = new Pusher(
                '8702b12d1675f14472ac',
                '0e7618b4f23dcfaf415c',
                '1863692',
                [
                    'cluster' => 'sa1',
                    'useTLS' => false
                ]
            );
            if ($cliente && $profissional) {
                $contrato = new Contrato();
                $contrato->id_cliente = $cliente->id;
                $contrato->id_profissional = $profissional->id;
                $contrato->data_inicio = $data_inicio;
                $contrato->status_contrato = 1;
                $contrato->save();
                $data = [
                    'message' => 'Você recebeu uma nova solicitação de contrato!',
                    'cliente_id' => $contrato->id_cliente,
                    'profissional_id' => $contrato->id_profissional
                ];
                $pusher->trigger('contratos', 'nova-solicitacao', $data);
                echo json_encode($data);
            } else {
                // Retornar um erro se não encontrar
                echo json_encode(['error' => 'Profissional não encontrado']);
            }
        } else {
            // Retornar um erro se o ID não for fornecido
            echo json_encode(['error' => 'ID do profissional não fornecido']);
        }
    }
}
