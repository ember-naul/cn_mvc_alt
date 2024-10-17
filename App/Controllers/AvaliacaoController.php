<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Avaliacao;
use Exception;

class AvaliacaoController extends Controller
{
    public function avaliacao()
    {
        $id_cliente = $_POST['id_cliente'];
        $id_profissional = $_POST['id_profissional'];
        $id_servico = $_POST['id_servico'];
        $nota = $_POST['rating'];
        $comentario = $_POST['comentario'];

        try {
            $avaliacao = new Avaliacao();
            $avaliacao->id_cliente = $id_cliente;
            $avaliacao->id_profissional = $id_profissional;
            $avaliacao->id_servico = $id_servico;
            $avaliacao->nota = $nota;
            $avaliacao->comentario = $comentario;
            $avaliacao->save();
            return redirect('/cliente/home')->sucesso("Deu certo!");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

}