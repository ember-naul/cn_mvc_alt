<?php
namespace App\Controllers;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Controllers\Controller;
use App\Services\DefaultServices;
use App\Services\RedirectServices;
use PHPMailer\PHPMailer\PHPMailer;
use Exception;

class LoginController extends Controller
{

    public $validarLogin = false;

    public function index()
    {
        if ($_SESSION['logado'] == false) {
            return require_once __DIR__ . '/../Views/login.php';
        } else {
            header('Location: /home');
        }
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
            ['cpf', '=', $cpf],
            ['rg', '=', $rg]
        ])->first();

        if ($usuario){
            throw new Exception("Email já cadastrado");
        }

        if ($senha != $confirmar_senha) {
            throw new Exception("As senhas digitadas não correspondem");
        }

        try {
            $usuario = new Usuario();
            $usuario->nome = $nome;
            $usuario->email = $email;
            $usuario->celular = $celular;
            $usuario->rg = $rg;
            $usuario->cpf = $cpf;
            $usuario->senha = $senha;
            $usuario->save();

            return redirect('/login')->sucesso('Operação realizada com sucesso');
        } catch (Exception $e) {
            return redirect('/cadastro')->erro($e->getMessage());
        }
    }

    public function login()
    {
        try {
            // Coleta os dados do POST
            $email = $_POST['email'] ?? null;
            $senha = $_POST['senha'] ?? null;

            // Valida se email e senha foram fornecidos
            if (!$email || !$senha) {
                throw new Exception("Obrigatório inserir email e senha");
            }

            // Busca o usuário com base no email e senha
            $usuario = Usuario::where([
                ['email', '=', $email],
                ['senha', '=', sha1(md5($senha))]
            ])->first();

            // Verifica se o usuário foi encontrado
            if (!$usuario) {
                throw new Exception("Credenciais incorretas");
            }

            // Configura as variáveis de sessão
            $_SESSION['logado'] = true;
            $_SESSION['id_usuario'] = $usuario->id;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['nome'] = $usuario->nome;
            $_SESSION['celular'] = $usuario->celular;
            $_SESSION['rg'] = $usuario->rg;
            $_SESSION['cpf'] = $usuario->cpf;

            // Verifica se o usuário é um cliente
            $cliente = Cliente::where('id_usuario', $usuario->id)->first();
            // Verifica se o usuário é um profissional
            $profissional = Profissional::where('id_usuario', $usuario->id)->first();

            if ($cliente && $profissional) {
                return redirect('/escolha_conta')->sucesso('Operação realizada com sucesso! Você tem contas de cliente e profissional.');
            } elseif ($cliente) {
                return redirect('/cliente/home')->sucesso('Operação realizada com sucesso! Você entrou como cliente.');
            } elseif ($profissional) {
                return redirect('/profissional/home')->sucesso('Operação realizada com sucesso! Você entrou como profissional.');
            } else {
                return redirect('/home')->sucesso('Operação realizada com sucesso.');
            }
        } catch (Exception $e) {
            return redirect('/login')->erro($e->getMessage());
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