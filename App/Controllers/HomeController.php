<?php

namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Usuario;

class HomeController extends Controller {
        
    public function index() {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['id_usuario'])) {
            return redirect('/login')->erro("Você precisa estar logado para acessar essa página.");
        }
    
        $usuario = Usuario::find($_SESSION['id_usuario']);
        $cliente = Cliente::where('id_usuario', $usuario->id)->first();
        $profissional = Profissional::where('id_usuario', $usuario->id)->first();
    
        // Se o usuário tem os dois perfis e ainda não escolheu, redireciona para a escolha de perfil
        if ($cliente && $profissional) {
            return require_once __DIR__ . '/../Views/escolha.php';;
        }
    
        // Caso já tenha feito a escolha, redireciona para a home correta
        if ($cliente && $_SESSION['cliente']) {
            return require_once __DIR__ .'/../Views/cliente/index.php';
        }
    
        if ($profissional && $_SESSION['profissional']) {
            return require_once __DIR__ .'/../Views/profissional/index.php';
        }
    
        // Caso o usuário não tenha nenhum dos perfis, exibe a home geral
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
    
}