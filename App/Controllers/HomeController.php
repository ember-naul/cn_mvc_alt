<?php

namespace App\Controllers;
use App\Controllers\Controller;

class HomeController extends Controller {

    public function index() {
        return require_once __DIR__ . '/../Views/home.php';
    }
    
}