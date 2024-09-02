<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Endereco;
use Exception;

class ContasController extends Controller
{
    public function index()
    {
        return require_once __DIR__ . '/../Views/cadastro_clientes.php';
    }
    
    public function novoCliente()
    {
        $id_usuario = $_POST['id_usuario'] ?? null; 
        $cep = $_POST['cep'] ?? null;
        $endereco = $_POST['endereco'] ?? null;
        $bairro = $_POST['bairro'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $numero = $_POST['numero'] ?? null;

        try {
            // Cria o cliente
            $cliente = new Cliente();
            $cliente->id_usuario = $id_usuario;
            $cliente->save();

            // Cria o endereço associado ao cliente
            $endereco_a = new Endereco();
            $endereco_a->id_cliente = $cliente->id;
            $endereco_a->id_profissional = 0;  // Associa o endereço ao cliente criado
            $endereco_a->cep = $cep;
            $endereco_a->bairro = $bairro;
            $endereco_a->cidade = $cidade;
            $endereco_a->endereco = $endereco;
            $endereco_a->numero = $numero;
            $endereco_a->save();
            echo '
            <script>
                window.location.href = "/home";
            </script>
            ';
            // return redirect('/home')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/homes')->erro($e->getMessage());
        }
    }
    public function novoProfissional()
    {
        $id_usuario = $_POST['id_usuario'] ?? null; 
        $cep = $_POST['cep'] ?? null;
        $endereco = $_POST['endereco'] ?? null;
        $bairro = $_POST['bairro'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $numero = $_POST['numero'] ?? null;

        try {
            $profissional = new Profissional();
            $profissional->id_usuario = $id_usuario;
            $profissional->save();

            $endereco_a = new Endereco();
            $endereco_a->id_profissional = $profissional->id;
            $endereco_a->id_cliente = 0;
            $endereco_a->cep = $cep;
            $endereco_a->bairro = $bairro;
            $endereco_a->cidade = $cidade;
            $endereco_a->endereco = $endereco;
            $endereco_a->numero = $numero;
            $endereco_a->save();

            //isso é gambiarra, mas funciona.
            echo '
            <script>
                window.location.href = "/home";
            </script>
            ';
            // return redirect('/home')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/homes')->erro($e->getMessage());
        }
    }
}
