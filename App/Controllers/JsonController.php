<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Habilidade;
use App\Models\Profissional;
use App\Models\ProfissionalHabilidade;
use App\Models\Usuario;
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
                echo json_encode(['error' => 'Profissional não encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID do profissional não fornecido']);
        }
    }


    function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {

        if ($lat1 === null || $lon1 === null || $lat2 === null || $lon2 === null) {
            return 0;
        }

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
                        'imagem' => $profissional->usuario->imagem,
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

    public function responderSolicitacao()
    {
        $acao = $_POST['acao'] ?? null;
        $profissionalId = $_POST['profissional_id'] ?? null;
        $usuario = Usuario::find($_SESSION['id_usuario']);
        $profissional = Profissional::find($profissionalId);
        $cliente = Cliente::where("id_usuario", "!=", $usuario->id)->first();

        $pusher = new Pusher(
            '8702b12d1675f14472ac',
            '0e7618b4f23dcfaf415c',
            '1863692',
            [
                'cluster' => 'sa1',
                'useTLS' => false
            ]
        );


        if ($acao) {
            $contrato = Contrato::where('id_profissional', $profissional->id)
                ->where('id_cliente', $cliente->id)
                ->first();

            if (!$cliente) {
                echo json_encode(['error' => 'Cliente não encontrado.']);
                return;
            }
            if (!$profissional) {
                echo json_encode(['error' => 'Profissional não encontrado.']);
                return;
            }
            if (!$contrato) {
                echo json_encode(['error' => 'Contrato não encontrado.']);
                return;
            }

            if ($acao === 'aceitar') {
                $contrato->status_contrato = 3; // 3 é o status "aceito"
                $contrato->save();

                $data = [
                    'success' => 'Solicitação aceita com sucesso!',
                    'contrato_id' => $contrato->id,
                    'cliente_id' => $contrato->id_cliente,
                    'chat_url' => '/chat?id=' . $contrato->id . '&cliente_id=' . $contrato->id_cliente . '&profissional_id=' . $profissional->id
                ];

                // Disparar o evento correto
                $pusher->trigger('clientes_' . $cliente->id, 'client:solicitacao_aceita', [
                    'contrato_id' => $contrato->id,
                    'cliente_id' => $cliente->id,
                    'profissional_id' => $profissional->id
                ]);

                $pusher->trigger('contratos', 'solicitacao-resposta', $data);
                echo json_encode($data); // Retorne a URL do chat
            } elseif ($acao === 'recusar') {
                $contrato->status_contrato = 5; // 5 é o status "recusado"
                $contrato->save();
                $data = [
                    'message' => 'O profissional recusou a solicitação.',
                    'contrato_id' => $contrato->id,
                    'profissional_id' => $profissional->id,
                    'cliente_id' => $cliente->id
                ];
                $pusher->trigger('contratos', 'solicitacao-resposta', $data);

                echo json_encode(['success' => 'Solicitação recusada com sucesso!']);
            } else {
                echo json_encode(['error' => 'Ação inválida.']);
            }
        } else {
            echo json_encode(['error' => 'Dados incompletos.']);
        }
    }

}
