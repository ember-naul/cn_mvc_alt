<?php
namespace App\Controllers;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Controllers\Controller;
use App\Services\DefaultServices;
use Exception;

class LoginController extends Controller
{

    public $validarLogin = false;

    public function index()
    {
        if ($_SESSION['logado'] == false) {
            return require_once __DIR__ . '/../Views/login.php';
        } //else {
          //  header('Location: /home');
        //}
    }

    public function escolha_conta()
    {
        return require_once __DIR__ . '/../Views/escolha_conta.php';
    }

    public function cadastro()
    {
        return require_once __DIR__ . '/../Views/cadastro_usuarios.php';
    }

    public function novoUsuario()
    {
        $nome = $_POST['nome'] ??= null;
        $email = $_POST['email'] ??= null;
        $celular = $_POST['celular'] ??= null;
        $rg = $_POST['rg'] ??= null;
        $cpf = $_POST['cpf'] ??= null;
        $senha = sha1(md5($_POST['senha']));
        $confirmar_senha = sha1(md5($_POST['confirmar_senha']));



        $usuario = Usuario::where([
            ['email', '=', $email],
            ['celular', '=', $celular],
            ['cpf', '=', $cpf],
            ['rg', '=', $rg]
        ])->first();

        if ($usuario) {
            return redirect('/cadastro')->erro(mensagem: "Já há um usuário cadastrado com algum dos seguintes dados: E-mail, Celular, RG ou CPF.");
        }

        if ($senha != $confirmar_senha) {
            return redirect('/cadastro')->erro(mensagem: "As senhas não correspondem!");
        }

        try {
            $usuario = new Usuario();
            $usuario->nome = $nome;
            $usuario->email = $email;
            $usuario->celular = $celular;
            $usuario->rg = $rg;
            $usuario->cpf = $cpf;
            $usuario->senha = $senha;
            $usuario->tipo = 1;
            $usuario->save();

            return redirect('/login')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/cadastro')->erro($e->getMessage());
        }
    }

    public function login()
{
    try {
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;

        if (!$email || !$senha) {
            throw new Exception("Obrigatório inserir email e senha");
        }

        // 12345
        // 12345

        $usuario = Usuario::where([
            ['email', '=', $email],
            ['senha', '=', sha1(md5($senha))]
        ])->first();

        if (!$usuario) {
            throw new Exception("Credenciais incorretas");
        }

        $_SESSION['logado'] = true;
        $_SESSION['id_usuario'] = $usuario->id;
        $_SESSION['email'] = $usuario->email;
        $_SESSION['nome'] = $usuario->nome;
        $_SESSION['celular'] = $usuario->celular;
        $_SESSION['rg'] = $usuario->rg;
        $_SESSION['cpf'] = $usuario->cpf;

        // Verificar se o usuário é cliente ou profissional
        $cliente = Cliente::where('id_usuario', $usuario->id)->first();
        $profissional = Profissional::where('id_usuario', $usuario->id)->first();

        if ($cliente && !$profissional) {
            $_SESSION['cliente'] = true;
            $_SESSION['profissional'] = false;
            return redirect('/cliente/home')->sucesso('Operação realizada com sucesso! Você entrou como cliente.');
        } else if ($profissional && !$cliente) {
            $_SESSION['cliente'] = false;
            $_SESSION['profissional'] = true;
            return redirect('/profissional/home')->sucesso('Operação realizada com sucesso! Você entrou como profissional.');
        } else if ($cliente && $profissional) {
            $_SESSION['cliente'] = true;
            $_SESSION['profissional'] = true;
            $_SESSION['escolha'] = true;
            return redirect('/home')->sucesso('Você foi redirecionado para escolher seu perfil!');
        } else {
           return redirect('/home')->sucesso('Você foi redirecionado para escolher seu perfil!');
        }

    } catch (Exception $e) {
        return redirect('/login')->erro($e->getMessage());
    }
}

    public function redirect_login(){
        $_SESSION['escolha'] = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['area']) && $_POST['area'] === 'cliente') {
                $_SESSION['cliente'] = true;
                $_SESSION['profissional'] = false;
                header('Location: /cliente/home');
                exit();
            }
            if (isset($_POST['area']) && $_POST['area'] === 'profissional') {
                $_SESSION['cliente'] = false;
                $_SESSION['profissional'] = true;
                header('Location: /profissional/home');
                exit();
            }
        }
    }
    public function deslogar()
    {
        try {

            DefaultServices::deslogar();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}