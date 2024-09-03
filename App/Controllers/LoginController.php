<?php
namespace App\Controllers;
use App\Models\Usuario;
use App\Controllers\Controller;
use App\Services\DefaultServices;
use App\Services\RedirectServices;
use PHPMailer\PHPMailer\PHPMailer;
use Exception;

class LoginController extends Controller {
    
    public $validarLogin = false;

    public function index() {
        if ($_SESSION['logado'] == false) {
            return require_once __DIR__ . '/../Views/login.php';
        } else {
            header('Location: /home');
        }
    }
    public function cadastro() {
        return require_once __DIR__ . '/../Views/cadastro_usuarios.php';
    }
    
    public function novoUsuario(){
        $nome               = $_POST['nome'] ??= null;
        $email              = $_POST['email'] ??= null;
        $celular            = $_POST['celular'] ??= null;
        $rg                 = $_POST['rg'] ??= null;
        $cpf                = $_POST['cpf'] ??= null;
        $senha              = sha1(md5($_POST['senha']));
        $confirmar_senha    = sha1(md5($_POST['confirmar_senha']));
        
        

        $usuario = Usuario::where([
           ['email', '=', $email], 
           [ 'cpf', '=', $cpf],
           [ 'rg', '=', $rg]
        ])->first();

            // if ($usuario){
            //     throw new Exception("Email já cadastrado");
            // }

            if ($senha != $confirmar_senha){
                throw new Exception("As senhas digitadas não correspondem");
            }
            
        try{
            $usuario = new Usuario();
            $usuario->nome = $nome;
            $usuario->email = $email;
            $usuario->celular = $celular;
            $usuario->rg = $rg;
            $usuario->cpf = $cpf;
            $usuario->senha = $senha;
            $usuario->save();
    
            return redirect('/login')->sucesso('Operação realizada com sucesso');
        }catch(Exception $e){
            return redirect('/cadastro')->erro($e->getMessage());
    }}

    public function login(){
        try{

            $_POST['email'] ??= null;
            $_POST['senha'] ??= null;

            if(!$_POST['email'] || !$_POST['senha']){
                throw new Exception("Obrigatório inserir email e senha");
            }

            $usuario = Usuario::where([
                ['email', '=', $_POST['email']],
                ['senha', '=', sha1(md5($_POST['senha']))]
            ])->first();

            if(!$usuario){
                throw new Exception("Credenciais incorretas");
            }

            $_SESSION['logado']     = true;
            $_SESSION['email']      = $usuario->email;
            $_SESSION['nome']       = $usuario->nome;
            $_SESSION['celular']    = $usuario->celular;
            $_SESSION['rg']         = $usuario->rg;
            $_SESSION['cpf']        = $usuario->cpf;

            return redirect('/home')->sucesso('Operação realizada com sucesso');
        }catch(Exception $e){
            return redirect('/login')->erro($e->getMessage());
        }
    }
    public function deslogar(){
        try{

            DefaultServices::deslogar();

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    

    
    
}