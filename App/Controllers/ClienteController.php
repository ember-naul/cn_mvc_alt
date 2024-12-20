<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Endereco;
use Exception;


class ClienteController extends Controller
{

    public function cliente_home()
    {
        return require_once __DIR__ . '/../Views/cliente/index.php';

    }

    public function cadastro()
    {
        return require_once __DIR__ . '/../Views/cliente/cadastro_clientes.php';

    }

    public function avaliar()
    {
        return require_once __DIR__ . '/../Views/cliente/avaliacao_cliente.php';

    }

    private function geocodeAddress($address)
    {
        $apiKey = 'AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4';

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            return [
                'latitude' => $location['lat'],
                'longitude' => $location['lng']
            ];
        } else {
            throw new Exception('Geocoding failed: ' . $data['status']);
        }
    }

    public function enderecoCadastro()
    {
        $enderecoCompleto = $_POST['enderecoCompleto'] ?? null;
        $rua = $_POST['rua'] ?? null;

        $usuario = Usuario::find($_SESSION['id_usuario']);
        $cliente = Cliente::where("id_usuario", $usuario->id)->first();

        if (!$cliente) {
            return redirect('/home')->erro('Cliente não encontrado.');
        }

        try {
            if (empty($enderecoCompleto)) {
                throw new Exception('O endereço completo deve ser preenchido.');
            }

            $partes = explode(',', $enderecoCompleto);

            if (count($partes) < 2) {
                throw new Exception("Formato de endereço inválido. $enderecoCompleto");
            }

            $enderecoComNumero = trim($partes[1]);

            preg_match('/(\d+)/', $enderecoComNumero, $matches);
            $numero = $matches[1] ?? null; // O número está no primeiro grupo de captura

            if (!$numero) {
                throw new Exception("Número não encontrado no endereço. $enderecoCompleto");
            }

            // Obtém o CEP e coordenadas
            $coordenadas_c = $this->geocodeAddress($enderecoCompleto);
            $cep = $this->buscarCepPeloEndereco($enderecoCompleto);

            // Valida se o CEP foi encontrado
            if (!$cep) {
                throw new Exception('CEP não encontrado para o endereço.');
            }
            // Salva o endereço
            $endereco_c = new Endereco();
            $endereco_c->id_cliente = $cliente->id;
            $endereco_c->rua = $rua;
            $endereco_c->cep = $cep;
            $endereco_c->numero = $numero;
            $endereco_c->latitude = $coordenadas_c['latitude'];
            $endereco_c->longitude = $coordenadas_c['longitude'];
            $endereco_c->save();

            return redirect('/cliente/home')->sucesso('Seu endereço foi cadastrado com sucesso');
        } catch (Exception $e) {
            return redirect('/enderecos')->erro('Erro ao cadastrar seu endereço! '. $e->getMessage());
        }
    }


    private function buscarCepPeloEndereco($enderecoCompleto)
    {
        $apiKey = 'AIzaSyBV2RbCH4G9_X8i1sxWKAtdwiCkYFg44ig';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($enderecoCompleto) . "&key=" . $apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {
            $components = $data['results'][0]['address_components'];
            return $components[6]['long_name'];
        } else {
            throw new Exception('Erro ao obter o CEP pelo endereço.');
        }
    }


    public function novoCliente()
    {
        $usuario = Usuario::find($_SESSION['id_usuario']);

        try {
            $cliente = new Cliente();
            $cliente->id_usuario = $usuario->id;
            $cliente->save();
            $_SESSION['cliente'] = true;
            $_SESSION['profissional'] = false;
            $this->enderecoCadastro();
            return redirect('/cliente/home')->sucesso('Você se cadastrou como cliente.');

        } catch (Exception $e) {
            return redirect('/enderecos')->erro($e->getMessage());
        }
    }

    public function update(array $data)
    {
        // Validação dos campos
        if (!isset($data['field']) || !in_array($data['field'], ['nome', 'email', 'celular'])) {
            throw new Exception("Campo inválido.");
        }

        if (empty($data['value'])) {
            throw new Exception("O novo valor não pode estar vazio.");
        }

        $usuarioId = $_SESSION['id_usuario'];
        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            // Atualiza o campo correspondente
            $usuario->{$data['field']} = $data['value'];
            $usuario->save();

            // Armazena uma mensagem de sucesso na sessão
            $_SESSION['message'] = 'Informação atualizada com sucesso!';
            return redirect("/")->sucesso("Alteração realizada com sucesso!");
        } else {
            $_SESSION['message'] = 'Usuário não encontrado.';
            return redirect("/")->erro("Alteração realizada com sucesso!");
        }
    }

    public function updateUser()
    {
        $this->update($_POST);
    }


}
