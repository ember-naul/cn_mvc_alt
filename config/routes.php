<?php

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ContasController;
use App\Controllers\SenhaController;


use FastRoute\RouteCollector;

return function(RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/home', [HomeController::class, 'index']);

    $r->addRoute('GET', '/login', [LoginController::class, 'index']);
    $r->addRoute('POST', '/iniciarsessao', [LoginController::class, 'login']);
    $r->addRoute('GET', '/deslogar', [LoginController::class, 'deslogar']);
    $r->addRoute('GET', '/cadastro', [LoginController::class, 'cadastro']);
    $r->addRoute('POST', '/novousuario', [LoginController::class, 'novoUsuario']);
    
    $r->addRoute('GET', '/recuperarsenha', [SenhaController::class, 'esqueci_senha']);
    $r->addRoute('POST', '/esqueci_senha', [SenhaController::class, 'esqueciSenha']);
    $r->addRoute('POST', '/validar_codigo', [SenhaController::class, 'validar_codigo']);
    $r->addRoute('POST', '/enviar', [SenhaController::class, 'enviar']);

    $r->addRoute('POST', '/novocliente', [ContasController::class, 'novoCliente']);
    $r->addRoute('POST', '/novoprofissional', [ContasController::class, 'novoProfissional']);

    $r->addRoute('GET', '/pareando', [HomeController::class, 'pareando']);
    
    
  

};