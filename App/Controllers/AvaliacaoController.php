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
    public function avaliacao_cliente(){
        $id_cliente = $_SESSION['id_cliente'];
        $avaliacao = $_POST['rating'];

        try{
            $avaliacao_cliente = new AvaliacaoCliente();
            $avaliacao->id_cliente = $id_cliente;
        } catch(Exception $e){
            
        }
    }

}
