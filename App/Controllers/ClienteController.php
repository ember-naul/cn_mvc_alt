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
    public function avaliacao()
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
    


    public function novoCliente()
    {
        $cep        = $_POST['cep'] ?? null;
        $endereco   = $_POST['endereco'] ?? null;
        $bairro     = $_POST['bairro'] ?? null;
        $cidade     = $_POST['cidade'] ?? null;
        $numero     = $_POST['numero'] ?? null;

        try {
            $cliente = new Cliente();
            $cliente->id_usuario = user()->id_usuario;
            $cliente->save();
            
            $endereco_completo = sprintf('%s, %s, %s, %s', $endereco, $bairro, $cidade, $numero);
            $coordenadas_c = $this->geocodeAddress($endereco_completo);

            $endereco_c = new Endereco();
            $endereco_c->id_cliente = $cliente->id;
            $endereco_c->id_profissional = null;
            $endereco_c->cep = $cep;
            $endereco_c->bairro = $bairro;
            $endereco_c->cidade = $cidade;
            $endereco_c->endereco = $endereco;
            $endereco_c->numero = $numero;
            $endereco_c->latitude = $coordenadas_c['latitude'];
            $endereco_c->longitude = $coordenadas_c['longitude'];
            $endereco_c->save();
            $_SESSION['cliente'] = true;
            return redirect('/cliente/home')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/home')->erro($endereco_completo);
        }
    }
}
