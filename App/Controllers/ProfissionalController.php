<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ProfissionalHabilidade;
use App\Models\Profissional;
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

    public function cadastro()
    {
        return require_once __DIR__ . '/../Views/profissional/cadastro_profissionais.php';

    }

    public function novoProfissional()
    {
        $cnpj = $_POST['cnpj'] ?? null;

        // Validação básica do CNPJ
        if (!$this->validarCNPJ($cnpj)) {
            return redirect('/profissional/cadastro')->erro("CNPJ inválido.");
        }

        try {
            $existeProfissional = Profissional::where('cnpj', $cnpj)->first();

            if ($existeProfissional) {
                return redirect('/profissional/cadastro')->erro("Já existe um profissional cadastrado com este CNPJ.");
            }
            // API CNPJ
            $url = "https://publica.cnpj.ws/cnpj/$cnpj";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . '/../../config/certifications/cacert.pem');

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($curl);
            curl_close($curl);
            if ($resp === false) {
                throw new Exception(curl_error($curl));
            }
            $data = json_decode($resp, true);
            if (isset($data['status']) && $data['status'] !== 'OK') {
                throw new Exception("Erro na consulta ao CNPJ: " . $data['message']);
            }
            //

            $profissional = new Profissional();
            $profissional->id_usuario = user()->id_usuario;
            $profissional->cnpj = $cnpj;
            $profissional->save();

            $_SESSION['cliente'] = false;
            $_SESSION['profissional'] = true;

            return redirect('/profissional/home')->sucesso("Você se cadastrou como profissional");
        } catch (Exception $e) {
            return redirect('/home')->erro($e->getMessage());
        }
    }

    private function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }
        $soma = 0;
        $mult = 5;

        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $mult;
            $mult = ($mult == 2) ? 9 : $mult - 1;
        }

        $resto = $soma % 11;
        $primeiroDV = ($resto < 2) ? 0 : 11 - $resto;

        // Cálculo do segundo dígito verificador
        $soma = 0;
        $mult = 6;

        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $mult;
            $mult = ($mult == 2) ? 9 : $mult - 1;
        }

        $resto = $soma % 11;
        $segundoDV = ($resto < 2) ? 0 : 11 - $resto;

        // Verifica se os dígitos verificadores estão corretos
        return $cnpj[12] == $primeiroDV && $cnpj[13] == $segundoDV;
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
            $habilidades_post = $_POST['habilidades'] ?? [];
            $data_cadastro = date("Y-m-d");

            if (empty($id_profissional)) {
                return redirect("/home")->erro("Dados incompletos.");
            }

            try {
                $habilidades_cadastradas = ProfissionalHabilidade::where('id_profissional', $id_profissional)
                    ->pluck('id_habilidade')
                    ->toArray();

                $habilidades_para_remover = array_diff($habilidades_cadastradas, $habilidades_post);
                foreach ($habilidades_para_remover as $id_habilidade) {
                    ProfissionalHabilidade::where('id_profissional', $id_profissional)
                        ->where('id_habilidade', $id_habilidade)
                        ->delete();
                }

                foreach ($habilidades_post as $id_habilidade) {
                    if (!in_array($id_habilidade, $habilidades_cadastradas)) {
                        $prof_habilidade = new ProfissionalHabilidade();
                        $prof_habilidade->id_profissional = $id_profissional;
                        $prof_habilidade->id_habilidade = $id_habilidade;
                        $prof_habilidade->data_cadastro = $data_cadastro;
                        $prof_habilidade->save();
                    }
                }

                return redirect("/home")->sucesso("Habilidades atualizadas com sucesso.");
            } catch (Exception $e) {
                return redirect("/home")->erro("Erro ao atualizar habilidades: " . $e->getMessage());
            }
        } else {
            return redirect("/home")->erro("Método de requisição inválido.");
        }
    }
}
