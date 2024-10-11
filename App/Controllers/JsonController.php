<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Habilidade;
use App\Models\Profissional;
use App\Models\ProfissionalHabilidade;
use Exception;
use Pusher\Pusher;

class JsonController
{

    public function buscarProfissionais($vars)
    {

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

    function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        $raioTerra = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $raioTerra * $c;
    }

    public function enviarHabilidades()
    {
        // Pega o corpo da requisição JSON
        $requestBody = json_decode(file_get_contents('php://input'), true);
        $habilidadesSelecionadas = $requestBody['habilidades'] ?? [];

        $cliente = Cliente::where('id_usuario', $_SESSION['id_usuario'])->first();
        if (!$cliente) {
            echo json_encode(['error' => 'ID Cliente não está definido!']);
            exit;
        }

        if (!empty($habilidadesSelecionadas)) {

            $profissionaisComDistancia = Profissional::whereHas('habilidades', function ($query) use ($habilidadesSelecionadas) {
                $query->whereIn('habilidades.id', $habilidadesSelecionadas);
            })
                ->get()
                ->filter(function ($profissional) use ($cliente) {
                    $distancia = $this->calcularDistancia($cliente->latitude, $cliente->longitude, $profissional->latitude, $profissional->longitude);
                    return $distancia <= 25; // Filtra por distância
                })
                ->map(function ($profissional) use ($cliente) {
                    $distancia = $this->calcularDistancia($cliente->latitude, $cliente->longitude, $profissional->latitude, $profissional->longitude);
                    return [
                        'id' => $profissional->id,
                        'nome' => $profissional->usuario->nome,
                        'latitude' => $profissional->latitude,
                        'longitude' => $profissional->longitude,
                        'celular' => $profissional->usuario->celular,
                        'habilidades' => $profissional->habilidades->pluck('nome')->toArray(),
                        'distancia' => $distancia,
                    ];
                });

            if ($profissionaisComDistancia->isEmpty()) {
                echo json_encode(['error' => "Nenhum profissional encontrado."]);
            } else {
                echo json_encode($profissionaisComDistancia->values()->all());
            }
        } else {
            echo json_encode(['error' => 'Nenhuma habilidade selecionada!']);
        }
    }





//        try {

//            $requestBody = json_decode(file_get_contents('php://input'), true);
//            $habilidadesSelecionadas = $requestBody['habilidades'] ?? [];
//
//            return json_encode($habilidadesSelecionadas);

//            echo("Habilidades selecionadas: " . json_encode($habilidadesSelecionadas));
//
//            $cliente = Cliente::where('id_usuario', $_SESSION['id_usuario'])->first();
//
//            if (!$cliente) {
//                throw new Exception("Cliente não encontrado");
////                echo json_encode(['error' => 'Cliente não encontrado.']);
////                return;
//            }
//
}
