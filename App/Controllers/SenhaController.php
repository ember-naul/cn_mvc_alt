<?php 
namespace App\Controllers;
use App\Models\Usuario;
use App\Controllers\Controller;
use App\Services\DefaultServices;
use App\Services\RedirectServices;
use PHPMailer\PHPMailer\PHPMailer;
use Exception;

class SenhaController extends Controller{

    public $validarLogin = false;

    public function esqueci_senha() {
        return require_once __DIR__ . '/../Views/esqueci_senha.php';
    }
    

public function esqueciSenha() {
    try {
        $email = $_POST['email'] ?? null;

        if (empty($email)) {
            throw new Exception('Email vazio!');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Formato de e-mail inválido!');
        }
        
        $usuario = Usuario::where('email', $email)->first();

        if (!$usuario) {
            throw new Exception('E-mail não encontrado!');
        }

        $codigo_verificacao = $this->gerar_codigo_verificacao();
        $this->armazenar_codigo($email, $codigo_verificacao);

        $this->enviar_email_recuperacao($email, $codigo_verificacao);

        echo '
        <div class="hold-transition login-page">
            <div class="login-box">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                    <a href="/login" class="h1"><b>Casa &</b>Negócios</a>
                    </div>
                    <div class="card-body">
                    <p class="login-box-msg">Digite o código de 6 dígitos que foi enviado no seu email.</p>
                    <form action="/validar_codigo" method="post">
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" name="codigo" placeholder="Digite o código de 6 dígitos">
                        <input type="hidden" class="form-control" name="email" value="' . htmlspecialchars($email) .'">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Enviar o código</button>
                        </div>
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="/login">Login</a>
                    </p>
                    </div>
                </div>
            </div>
        </div>
        ';
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
    $usuario->codigo_expiracao = date('Y-m-d H:i:s', strtotime('+15 minutes')); 
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

        echo '
        <div class="hold-transition login-page">
            <div class="login-box">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                    <a href="/login" class="h1"><b>Casa & </b> Negócios</a>
                    </div>
                    <div class="card-body">
                    <p class="login-box-msg">Seu código foi verificado com sucesso! Digite sua nova senha</p>
                    <form action="/enviar" method="post">
                        <div class="input-group mb-3">
                        <input type="hidden" class="form-control" name="email" value="' . $email . '">
                        <input type="hidden" class="form-control" name="codigo" value="' . $codigo . '">
                        <input type="password" class="form-control" name="nova_senha" placeholder="Digite sua nova senha">
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Atualizar a senha</button>
                        </div>
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="/login">Login</a>
                    </p>
                    </div>
                </div>
            </div>
        </div>
        ';
    } catch (Exception $e) {
        echo ($e->getMessage());
    }
}

public function enviar() {
    try {
        $email = $_POST['email'] ?? null;
        $codigo = $_POST['codigo'] ?? null;
        $nova_senha = $_POST['nova_senha'] ?? null;

        if (empty($email) || empty($codigo) || empty($nova_senha)) {
            throw new Exception('Email, código ou nova senha não fornecidos!');
        }

        $usuario = Usuario::where('email', $email)
                          ->where('codigo_verificacao', $codigo)
                          ->where('codigo_expiracao', '>', date('Y-m-d H:i:s'))
                          ->first();

        if (!$usuario) {
            throw new Exception('Código inválido ou expirado!');
        }

        // Atualiza a senha
        $usuario->senha = sha1(md5($nova_senha));
        $usuario->codigo_verificacao = null; 
        $usuario->codigo_expiracao = null; 
        $usuario->save();

        echo 'Senha atualizada com sucesso!';
        return redirect('/login')->sucesso('Senha atualizada com sucesso!');
    } catch (Exception $e) {
        echo ($e->getMessage());
    }
}

private function enviar_email_recuperacao($email, $codigo) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'thoeralivro@gmail.com'; 
        $mail->Password = 'eyexqsxxessowwbu'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465; 

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
}
?>