<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ProfissionalHabilidade;
use App\Models\Profissional;
use App\Models\Endereco;
use Exception;

class ProfissionalController extends Controller
{   
    public function profissional_home()
    {
        return require_once __DIR__ . '/../Views/profissional/index.php';

    }
    public function habilidades()
    {
        return require_once __DIR__ . '/../Views/profissional/habilidades.php';

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

    public function novoProfissional()
    {
        $cnpj       = $_POST['cnpj'] ?? null;
        $cep        = $_POST['cep_p'] ?? null;
        $endereco   = $_POST['endereco_p'] ?? null;
        $bairro     = $_POST['bairro_p'] ?? null;
        $cidade     = $_POST['cidade_p'] ?? null;
        $numero     = $_POST['numero_p'] ?? null;
    
        try {
            $profissional = new Profissional();
            $profissional->id_usuario = user()->id_usuario;
            $profissional->cnpj = $cnpj;
            $profissional->save();
            $_SESSION['profissional'] = true; 
            $endereco_completo = sprintf('%s, %s, %s, %s', $endereco, $bairro, $cidade, $numero);
            $coordenadas_p = $this->geocodeAddress($endereco_completo);
            
            $endereco_p = new Endereco();
            $endereco_p->id_profissional = $profissional->id;
            $endereco_p->id_cliente = null;
            $endereco_p->cep = $cep;
            $endereco_p->bairro = $bairro;
            $endereco_p->cidade = $cidade;  
            $endereco_p->endereco = $endereco;
            $endereco_p->numero = $numero;
            $endereco_p->latitude = $coordenadas_p['latitude'];
            $endereco_p->longitude = $coordenadas_p['longitude'];
            $endereco_p->save();
            
            return redirect('/profissional/home')->sucesso("Operação realizada com sucesso! Você se cadastrou como profissional");
        } catch (Exception $e) {
            return redirect('/home')->erro($e->getMessage());
        }
    }


   public function habilidades_inserir() 
   {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $usuario_id = $_SESSION['id_usuario'] ?? null;

        if (!$usuario_id) {
            return redirect("/home")->erro("Usuário não autenticado.");
        }

        $profissional = Profissional::where('id_usuario', $usuario_id)->first();

        if (!$profissional) {
            return redirect("/home")->erro("Profissional não encontrado.");
        }

        $id_profissional = $profissional->id;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $habilidades = $_POST['habilidades'] ?? [];
            $data_cadastro = date("Y-m-d");

            if (empty($id_profissional) || empty($habilidades)) {
                return redirect("/home")->erro("Dados incompletos.");
            }

            try {
                foreach ($habilidades as $id_habilidade) {
                    $prof_habilidade = new ProfissionalHabilidade();
                    $prof_habilidade->id_profissional = $id_profissional;
                    $prof_habilidade->id_habilidade = $id_habilidade;
                    $prof_habilidade->data_cadastro = $data_cadastro;
                    $prof_habilidade->save(); 
                }

                return redirect("/home")->sucesso("Habilidades cadastradas com sucesso.");
            } catch (Exception $e) {
                return redirect("/home")->erro("Erro ao cadastrar habilidades: " . $e->getMessage());
            }
        } else {
            return redirect("/home")->erro("Método de requisição inválido.");
        }
    }
}
