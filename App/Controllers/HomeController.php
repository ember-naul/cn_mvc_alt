<?php

namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Usuario;
use Exception;
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Client as GuzzleHttpClient;


class HomeController extends Controller {
    public $validarLogin = false;
    public function index() {
        if (isset($_SESSION['profissonal']) || isset($_SESSION['cliente'])){
        $usuario = Usuario::find($_SESSION['id_usuario']);
        $cliente = Cliente::where('id_usuario', $usuario->id)->first();
        $profissional = Profissional::where('id_usuario', $usuario->id)->first();
        
        // Se o usuário tem os dois perfis e ainda não escolheu, redireciona para a escolha de perfil
        if ($cliente && $profissional) {
            return require_once __DIR__ . '/../Views/escolha.php';
        }
    
        // Caso já tenha feito a escolha, redireciona para a home correta
        if ($cliente && $_SESSION['cliente']) {
            $_SESSION['profissional'] = false;
            return require_once __DIR__ .'/../Views/cliente/index.php';
//             return require_once __DIR__ . '/../Views/home.php';
        }
    
        if ($profissional && $_SESSION['profissional']) {
            $_SESSION['cliente'] = false;
            return require_once __DIR__ .'/../Views/profissional/index.php';
        }
     }

        return require_once __DIR__ . '/../Views/home.php';
}   

    public function mapa(){
        return require_once __DIR__ . '/../Views/mapa.php';
    }

    public function chat_teste(){
        return require_once __DIR__ . '/../Views/chat/index.php';
    }

    public function gravardados(){
        return require_once __DIR__ . '/../Views/gravarDados.php';
    }
    
    public function pareando(){
        return require_once __DIR__ . '/../Views/waiting.php';
    }
    public function enderecos(){
        return require_once __DIR__ . '/../Views/enderecos.php';
    }

    public function enviarImagem(){
        return require_once __DIR__ . '/../Views/editar_imagem.php';
    }
    public function updateImagem() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $projectId = 'elevated-patrol-438816-m7';
            $bucketName = 'profilepics-cn';
            $keyFilePath = 'C:/Users/aluno/Desktop/cn_mvc_alt/config/key.json';

            // Inicializa o cliente do Storage
            $storage = new StorageClient([
                'projectId' => $projectId,
                'keyFilePath' => $keyFilePath,
                'httpHandler' => function ($request) {
                    return (new GuzzleHttpClient(['verify' => false]))->send($request);
                },
            ]);

            $bucket = $storage->bucket($bucketName);
            $croppedImageData = $_POST['croppedImage']; // Obtém a imagem cortada do campo oculto

            if ($croppedImageData) {
                // Remove o prefixo "data:image/png;base64," se existir
                if (preg_match('/^data:image\/(png|jpg|jpeg);base64,/', $croppedImageData, $type)) {
                    $data = substr($croppedImageData, strlen($type[0]));
                    $data = base64_decode($data);
                    $fileName = 'profile_' . uniqid() . '.png'; // Gera um nome único para o arquivo

                    // Faz o upload do arquivo
                    try {
                        $object = $bucket->upload(
                            fopen('data://application/octet-stream;base64,' . base64_encode($data), 'r'),
                            ['name' => $fileName]
                        );

                        // Atualiza a imagem do usuário no banco de dados
                        $usuario = Usuario::where('id', $_SESSION['id_usuario'])->first();
                        $usuario->imagem = $fileName;
                        $usuario->save();

                        return redirect("/home")->sucesso("Arquivo enviado com sucesso.");
                    } catch (Exception $e) {
                        return redirect('/enviar_imagem')->erro('Erro ao enviar o arquivo: ' . $e->getMessage());
                    }
                } else {
                    echo 'Formato de imagem inválido.';
                }
            } else {
                echo 'Nenhuma imagem cortada foi enviada.';
            }
        }
    }

}