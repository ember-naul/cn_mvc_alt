<?php

namespace App\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Profissional;
use Exception;
use Pusher\Pusher;
use Pusher\PusherException;

class PareamentoController extends Controller
{
    /**
     * @throws PusherException
     */
    public function solicitar_contrato()
    {

        $clienteId = $_POST['cliente_id'];
        $profissionalId = $_POST['profissional_id'];
        $pusher = new Pusher(
            '8702b12d1675f14472ac',
            '0e7618b4f23dcfaf415c',
            '1863692',
            [
                'cluster' => 'sa1',
                'useTLS' => true
            ]
        );

        try {
            $verificar = Contrato::where(['id_cliente', '!=', $clienteId], ['id_profissional', '!=', $profissionalId])->first();
            if (!$verificar) {
                throw new Exception('Contrato já existe ou deu outro erro');
            }

            $cliente = Cliente::find($clienteId);
            $profissional = Profissional::find($profissionalId);
            if ($cliente && $profissional) {
                $contrato = new Contrato();
                $contrato->cliente_id = $clienteId;
                $contrato->profissional_id = $profissionalId;
                $contrato->status_contrato = 1;
                $contrato->save();
                $data = [
                    'message' => 'Você recebeu uma nova solicitação de contrato!',
                    'cliente_id' => $_POST['cliente_id'],
                    'profissional_id' => $_POST['profissional_id']
                ];
                $pusher->trigger('contratos', 'nova-solicitacao', $data);
            } else {
                var_dump($pusher);
                throw new Exception("Não existe profissional ou cliente com este ID");
            }

            return redirect('cliente/avalie')->sucesso("teste foi");
        } catch (Exception $e) {
            return redirect('/')->erro("O pusher não enviou nada");
        }

    }
}

