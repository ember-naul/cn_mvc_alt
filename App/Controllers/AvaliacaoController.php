<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Endereco;
use App\Models\AvaliacaoCliente;
use Exception;

class AvaliacaoController extends Controller
{
    public function avaliacao_cliente()
    {
        $id_cliente = $_SESSION['id_cliente'];
        $id_servico = $_POST['id_servico'];
        $nota = $_POST['rating'];
        $comentario = $_POST['comentario'];

        try {
            $avaliacao_cliente = new AvaliacaoCliente();
            $avaliacao_cliente->id_cliente = $id_cliente;
            $avaliacao_cliente->id_servico = $id_servico;
            $avaliacao_cliente->nota = $nota;
            $avaliacao_cliente->comentario = $comentario;
            $avaliacao_cliente->save();
            return redirect('/cliente/home')->sucesso("Deu certo!");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function avaliacao_profissional()
    {
        $id_cliente = $_SESSION['id_cliente'];
        $id_servico = $_POST['id_servico'];
        $nota = $_POST['rating'];
        $comentario = $_POST['comentario'];

        try {
            $avaliacao_cliente = new AvaliacaoCliente();
            $avaliacao_cliente->id_cliente = $id_cliente;
            $avaliacao_cliente->id_servico = $id_servico;
            $avaliacao_cliente->nota = $nota;
            $avaliacao_cliente->comentario = $comentario;
            $avaliacao_cliente->save();
            return redirect('/profissional/home')->sucesso("Deu certo!");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}