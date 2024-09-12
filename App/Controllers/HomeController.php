<?php

namespace App\Controllers;
use App\Controllers\Controller;

class HomeController extends Controller {

    public function index() {
        return require_once __DIR__ . '/../Views/home.php';
    }
    
    public function mapa(){
        return require_once __DIR__ . '/../Views/mapa.php';
    }

    public function gravardados(){
        return require_once __DIR__ . '/../Views/gravarDados.php';
    }
    
    public function pareando(){
        return require_once __DIR__ . '/../Views/waiting.php';
    }
    
}