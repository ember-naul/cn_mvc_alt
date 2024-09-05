<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Endereco;
use Exception;

class ProfissionalController extends Controller
{   
    public function cliente_home()
    {
        return require_once __DIR__ . '/../Views/profissional/index.php';

    }

    public function novoProfissional()
    {

        $id_usuario = $_POST['id_usuario'] ?? null; 
        $cnpj = $_POST['cnpj'] ?? null;
        $cep = $_POST['cep'] ?? null;
        $endereco = $_POST['endereco'] ?? null;
        $bairro = $_POST['bairro'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $numero = $_POST['numero'] ?? null;

        try {
            $profissional = new Profissional();
            $profissional->id_usuario = $id_usuario; //$usuario->id; 
            $profissional->cnpj = $cnpj;
            $profissional->save();

            $endereco_a = new Endereco();
            $endereco_a->id_profissional = $profissional->id;
            $endereco_a->id_cliente = null;
            $endereco_a->cep = $cep;
            $endereco_a->bairro = $bairro;
            $endereco_a->cidade = $cidade;
            $endereco_a->endereco = $endereco;
            $endereco_a->numero = $numero;
            $endereco_a->save();
            $_SESSION['tipo_usuario'] = 'profissional'; 
            return redirect('/home')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/home')->erro($e->getMessage());
        }
    }
}
