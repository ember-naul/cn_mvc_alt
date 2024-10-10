<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Habilidade;
use App\Models\Profissional;
use App\Models\ProfissionalHabilidade;
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

        return $raioTerra * $c; // retorna valor em km's
    }

    public function enviarHabilidades($vars)
    {
        // Fetch raw input and decode if JSON is sent
        $requestBody = json_decode(file_get_contents('php://input'), true);
        $habilidadesSelecionadas = $requestBody['habilidades'] ?? [];

        // Log as habilidades selecionadas
        error_log("Habilidades selecionadas: " . json_encode($habilidadesSelecionadas));

        // Attempt to find the client
        $cliente = Cliente::where('id_usuario', $_SESSION['id_usuario'])->first();

        if (!$cliente) {
            echo json_encode(['error' => 'Cliente não encontrado.']);
            return;
        }

        if (!empty($habilidadesSelecionadas)) {
            // Consulta os profissionais com as habilidades selecionadas
            $profissionais = Profissional::with('habilidades')
                ->whereHas('habilidades', function ($query) use ($habilidadesSelecionadas) {
                    $query->whereIn('habilidades.id', $habilidadesSelecionadas);
                })
                ->where('id_usuario', '!=', $_SESSION['id_usuario'])
                ->get();

            // Log do número de profissionais encontrados
            error_log("Número de profissionais encontrados: " . count($profissionais));

            if ($profissionais->isEmpty()) {
                echo json_encode(['error' => 'Nenhum profissional encontrado para as habilidades selecionadas.']);
                return;
            }

            // Prepara os dados para retornar
            $profissionaisComDistancia = [];
            foreach ($profissionais as $profissional) {
                $distancia = $this->calcularDistancia(
                    $cliente->latitude,
                    $cliente->longitude,
                    $profissional->latitude,
                    $profissional->longitude
                );

                // Filtra por distância (se necessário)
                if ($distancia <= 20) {
                    $profissionaisComDistancia[] = [
                        'id' => $profissional->id,
                        'nome' => $profissional->usuario->nome,
                        'latitude' => $profissional->latitude,
                        'longitude' => $profissional->longitude,
                        'distancia' => $distancia
                    ];
                }
            }

            // Ordena por distância
            usort($profissionaisComDistancia, function ($a, $b) {
                return $a['distancia'] <=> $b['distancia'];
            });

            // Retorna os dados dos profissionais
            echo json_encode($profissionaisComDistancia);
        } else {
            echo json_encode(['error' => 'Nenhuma habilidade selecionada.']);
        }
    }


}
