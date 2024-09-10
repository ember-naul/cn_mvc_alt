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

    private function geocodeAddress($address)
    {
        $apiKey = 'AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4'; // Substitua pela sua chave da API
    
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
    


    public function novoCliente()
    {
        $cep = $_POST['cep'] ?? null;
        $endereco = $_POST['endereco'] ?? null;
        $bairro = $_POST['bairro'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $numero = $_POST['numero'] ?? null;

        try {
            // Cria o cliente
            $cliente = new Cliente();
            $cliente->id_usuario = user()->id_usuario;
            $cliente->save();
            
            $endereco_completo = sprintf('%s, %s, %s, %s', $endereco, $bairro, $cidade, $numero);

            $coordenadas = $this->geocodeAddress($endereco_completo);

            $endereco_a = new Endereco();
            $endereco_a->id_cliente = $cliente->id;
            $endereco_a->id_profissional = null;
            $endereco_a->cep = $cep;
            $endereco_a->bairro = $bairro;
            $endereco_a->cidade = $cidade;
            $endereco_a->endereco = $endereco;
            $endereco_a->numero = $numero;
            $endereco_a->latitude = $coordenadas['latitude'];
            $endereco_a->longitude = $coordenadas['longitude'];
            $endereco_a->save();
            $_SESSION['tipo_usuario'] = 'cliente';
            return redirect('/home')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/home')->erro($endereco_completo);
        }
    }
}
