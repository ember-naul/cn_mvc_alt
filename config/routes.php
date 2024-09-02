<?php

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ContasController;


use FastRoute\RouteCollector;

return function(RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/home', [HomeController::class, 'index']);

    $r->addRoute('GET', '/login', [LoginController::class, 'index']);
    $r->addRoute('POST', '/iniciarsessao', [LoginController::class, 'login']);
    $r->addRoute('GET', '/deslogar', [LoginController::class, 'deslogar']);

    $r->addRoute('GET', '/cadastro', [LoginController::class, 'cadastro']);
    $r->addRoute('POST', '/novousuario', [LoginController::class, 'novoUsuario']);
    
    $r->addRoute('GET', '/recuperarsenha', [LoginController::class, 'esqueci_senha']);
    $r->addRoute('POST', '/novasenha', [LoginController::class, 'esqueciSenha']);

    // $r->addRoute('GET', '/clientes_cadastro', [ContasController::class, 'index']);
    $r->addRoute('POST', '/novocliente', [ContasController::class, 'novoCliente']);
    
    
  

};