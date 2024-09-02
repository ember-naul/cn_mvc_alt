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
    public function esqueci_senha() {
        return require_once __DIR__ . '/../Views/esqueci_senha.php';
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
            echo($e->getMessage());
        }
    }
    public function deslogar(){
        try{

            DefaultServices::deslogar();

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    // É DAQUI PRA BAIXO O ESQUECI A SENHA!!!
    //
    //

    private function enviar_email_recuperacao($email, $codigo) {
        $mail = new PHPMailer(true);
    
        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thoeralivro@gmail.com'; 
            $mail->Password = 'thoeralivro123'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; 
    
            // Configurações do e-mail
            $mail->setFrom('thoeralivro@gmail.com', 'Thoera | Casa & Negócios');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de Senha';
            $mail->Body = "Seu código de verificação é: <strong>$codigo</strong><br>Este código é válido por 15 minutos.";
    
            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Não foi possível enviar o e-mail. Mailer Error: {$mail->ErrorInfo}");
        }
    }



    public function esqueciSenha() {
        try {
            $email = $_POST['email'] ?? null;
    
            if (empty($email)) {
                throw new Exception('Email vazio!');
            }
    
            // Validação do e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Formato de e-mail inválido!');
            }

            var_dump($email);
            
            $usuario = Usuario::where('email', $email)->first();
            var_dump($usuario->email);
            if (!$usuario) {
                throw new Exception('E-mail não encontrado!');
            }
    
            // Gerar um código de verificação
            $codigo_verificacao = $this->gerar_codigo_verificacao();
            $this->armazenar_codigo($email, $codigo_verificacao);
    
            // Enviar o código por e-mail
            $this->enviar_email_recuperacao($email, $codigo_verificacao);
    
            echo 'Código de verificação enviado para seu e-mail!';
            // header('Location: /validar_senha');
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }
    
    private function gerar_codigo_verificacao() {

        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }
    
    private function armazenar_codigo($email, $codigo) {

        $usuario = Usuario::where('email', $email)->first();
        $usuario->codigo_verificacao = $codigo;
        $usuario->codigo_expiracao = date('Y-m-d H:i:s', strtotime('+15 minutes')); // Expira em 15 minutos
        $usuario->save();
    }

    public function validar_codigo() {
        try {
            $email = $_POST['email'] ?? null;
            $codigo = $_POST['codigo'] ?? null;
    
            if (empty($email) || empty($codigo)) {
                throw new Exception('Email ou código não fornecidos!');
            }
    
            $usuario = Usuario::where('email', $email)
                              ->where('codigo_verificacao', $codigo)
                              ->where('codigo_expiracao', '>', date('Y-m-d H:i:s'))
                              ->first();
    
            if (!$usuario) {
                throw new Exception('Código inválido ou expirado!');
            }
    
            // Código válido, exibir formulário para redefinir a senha
            echo '
            <form method="post" action="redefinir_senha.php">
                <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
                <input type="hidden" name="codigo" value="' . htmlspecialchars($codigo) . '">
                Nova Senha: <input type="password" name="nova_senha">
                <button type="submit">Atualizar Senha</button>
            </form>';
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }
    
}