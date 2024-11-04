<?php

namespace App\Controllers;

use App\Models\Chat;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Habilidade;
use App\Models\Profissional;
use App\Models\ProfissionalHabilidade;
use App\Models\Usuario;
use App\Models\Mensagem;
use Exception;
use Pusher\Pusher;

class JsonController
{

    public function buscarProfissionais($vars)
    {

        $id = $vars['id'] ?? null;

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
                    $data = [
                        'message' => 'Você recebeu uma nova solicitação de contrato!',
                        'cliente_id' => $cliente->id,
                        'cliente_nome' => $cliente->usuario->nome,
                        'profissional_id' => $profissional->id,
                        'cliente_img' => $cliente->usuario->imagem,
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

    public function retornarEstado()
    {
        $profissionalId = $_SESSION['profissional_id'] ?? null;
        $acao = $_POST['acao'] ?? null;

        if ($profissionalId && $acao) {
            $profissional = Profissional::find($profissionalId);

            if (!in_array($acao, ['pareando', 'nao-pareando'])) {
                echo json_encode(['error' => 'Ação inválida']);
                return;
            }

            if ($profissional) {
                if ($acao === 'pareando') {
                    $profissional->status = 'pareando'; // Forçar o estado para 'pareando'
                } elseif ($acao === 'nao-pareando') {
                    $profissional->status = 'nao-pareando'; // Forçar o estado para 'nao-pareando'
                }

                $profissional->save();
                echo json_encode(['status' => $profissional->status]);
            } else {
                echo json_encode(['error' => 'Profissional não encontrado']);
            }
        } else {
            echo json_encode(['error' => 'Dados insuficientes']);
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
                    return $profissional->status == 'pareando' && $distancia <= 25;
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
        $data_inicio = date('Y-m-d H:i:s');

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
            if (!$cliente) {
                echo json_encode(['error' => 'Cliente não encontrado.']);
                return;
            }
            if (!$profissional) {
                echo json_encode(['error' => 'Profissional não encontrado.']);
                return;
            }

            if ($acao === 'aceitar') {
                $contrato = new Contrato();
                $contrato->id_cliente = $cliente->id;
                $contrato->id_profissional = $profissional->id;
                $contrato->data_inicio = $data_inicio;
                $contrato->status_contrato = 'aceito';
                $contrato->save(); // Salva a atualização do status

                $data = [
                    'success' => 'Solicitação aceita com sucesso!',
                    'contrato_id' => $contrato->id,
                    'cliente_id' => $contrato->id_cliente,
                    'chat_url' => '/chat?id=' . $contrato->id . '&cliente_id=' . $contrato->id_cliente . '&profissional_id=' . $profissional->id
                ];
                $chat = new Chat();
                $chat->id_contrato = $contrato->id;
                $chat->save();
                // Dispara eventos para notificação
                $pusher->trigger('clientes_' . $cliente->id, 'client:solicitacao_aceita', [
                    'contrato_id' => $contrato->id,
                    'cliente_id' => $cliente->id,
                    'profissional_id' => $profissional->id,
                    'chat_id' => $chat->id,
                ]);


                $pusher->trigger('contratos', 'solicitacao-resposta', $data);
                echo json_encode($data);
            } elseif ($acao === 'recusar') {
                $data = [
                    'message' => 'O profissional recusou a solicitação.',
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
    public function enviarMensagem() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id_chat = $data['id_chat'] ?? null;
        $mensagem = $data['mensagem'] ?? null;

        if ($id_chat && $mensagem) {
            $novaMensagem = new Mensagem();
            $novaMensagem->id_chat = $id_chat;
            $novaMensagem->mensagem = $mensagem; 
            if ($_SESSION['cliente' == true]){
                $novaMensagem->tipo_usuario = 'cliente'; 
            } 
            if ($_SESSION['profissional'] == true) {
                $novaMensagem->tipo_usuario = 'profissional'; 
            }
            if ($novaMensagem->save()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Falha ao salvar a mensagem.']);
            }
        } else {
            echo json_encode(['error' => 'Dados incompletos.']);
        }
    }

    public function concluirContrato() {
        $options = array(
            'cluster' => 'sa1',
            'useTLS' => false
        );

        $pusher = new Pusher(
            '8702b12d1675f14472ac',
            '0e7618b4f23dcfaf415c',
            '1863692',
            $options
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username'])) {
                $username = $_POST['username'];
                $role = $_POST['role'];

                try {
                    $pusher->trigger('chat-conc', 'user-aceitou', [
                        'username' => $username,
                        'role' => $role
                    ]);

                    echo json_encode(['status' => 'success']);
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Username não fornecido.']);
            }
            exit;
        } else {

            echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
            exit;
        }
    }


}