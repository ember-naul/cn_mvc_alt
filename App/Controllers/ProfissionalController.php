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
    public function profissional_home()
    {
        return require_once __DIR__ . '/../Views/profissional/index.php';

    }

    private function geocodeAddress($address){
        $apiKey = getenv('AIzaSyBfEk2DdoQkxXmDs39CRqgCnE-1TTSY6_4');
        $response = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey);
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

    public function novoProfissional()
    {
        $cnpj = $_POST['cnpj'] ?? null;
        $cep = $_POST['cep'] ?? null;
        $endereco = $_POST['endereco'] ?? null;
        $bairro = $_POST['bairro'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $numero = $_POST['numero'] ?? null;

        try {
            $profissional = new Profissional();
            $profissional->id_usuario = user()->id_usuario;
            $profissional->cnpj = $cnpj;
            $profissional->save();

            $endereco_completo = "{endereco}, {bairro}, {cidade}, {numero}";

            $coordenadas = $this->geocodeAddress($endereco_completo);

            $endereco_a = new Endereco();
            $endereco_a->id_profissional = $profissional->id;
            $endereco_a->id_cliente = null;
            $endereco_a->cep = $cep;
            $endereco_a->bairro = $bairro;
            $endereco_a->cidade = $cidade;
            $endereco_a->endereco = $endereco;
            $endereco_a->numero = $numero;
            $endereco_a->latitude = $coordenadas['latitude'];
            $endereco_a->longitude = $coordenadas['longitude'];
            $endereco_a->save();
            $_SESSION['tipo_usuario'] = 'profissional'; 
            return redirect('/home')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/home')->erro($e->getMessage());
        }
    }
}
