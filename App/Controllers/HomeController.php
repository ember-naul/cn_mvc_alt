<?php

namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Profissional;
use App\Models\Usuario;

class HomeController extends Controller {
    
    public function index() {
        // $cliente = Cliente::where('id_usuario', $usuario->id)->first();
        // $profissional = Profissional::where('id_usuario', $usuario->id)->first();
        // if ($cliente && $profissional) {
        //     if ($_SESSION['tipo_usuario' == 'cliente']){
        //         return require_once __DIR__ . '/../Views/cliente/index.php';
        //     }if ($_SESSION['tipo_usuario' == 'profissional']){
        //         return require_once __DIR__ . '/../Views/profissional/index.php';
        //     }
        // } else {  
        // }
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