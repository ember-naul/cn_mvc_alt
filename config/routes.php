<?php

use App\Controllers\AvaliacaoController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\LocalizacaoController;
use App\Controllers\JsonController;
use App\Controllers\SenhaController;
use App\Controllers\ClienteController;
use App\Controllers\ProfissionalController;


use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/home', [HomeController::class, 'index']);
    $r->addRoute('GET', '/mapa', [HomeController::class, 'mapa']);
    $r->addRoute('GET', '/gravardados', [HomeController::class, 'gravardados']);
    $r->addRoute('GET', '/chat_teste', [HomeController::class, 'chat_teste']);
    $r->addRoute('GET', '/enderecos', [HomeController::class, 'enderecos']);
    $r->addRoute('POST', '/enviar_mensagem', [HomeController::class, 'enviar_mensagem']);

    $r->addRoute('GET', '/login', [LoginController::class, 'index']);
    $r->addRoute('POST', '/iniciarsessao', [LoginController::class, 'login']);
    $r->addRoute('POST', '/redirect', [LoginController::class, 'redirect_login']);
    $r->addRoute('GET', '/deslogar', [LoginController::class, 'deslogar']);
    $r->addRoute('GET', '/cadastro', [LoginController::class, 'cadastro']);
    $r->addRoute('POST', '/novousuario', [LoginController::class, 'novoUsuario']);

    $r->addRoute('GET', '/recuperarsenha', [SenhaController::class, 'esqueci_senha']);
    $r->addRoute('POST', '/esqueci_senha', [SenhaController::class, 'esqueciSenha']);
    $r->addRoute('POST', '/validar_codigo', [SenhaController::class, 'validar_codigo']);
    $r->addRoute('POST', '/enviar', [SenhaController::class, 'enviar']);

    $r->addRoute('POST', '/novocliente', [ClienteController::class, 'novoCliente']);
    $r->addRoute('POST', '/novoprofissional', [ProfissionalController::class, 'novoProfissional']);

    $r->addRoute('GET', '/cliente/home', [ClienteController::class, 'cliente_home']);
    $r->addRoute('GET', '/cliente/avalie', [CLienteController::class, 'avaliar']);
    $r->addRoute('POST', '/cliente/avaliou', [AvaliacaoController::class, 'avaliacao']);
    $r->addRoute('GET', '/cliente/cadastro', [CLienteController::class, 'cadastro']);
    $r->addRoute('GET', '/profissional/home', [ProfissionalController::class, 'profissional_home']);
    $r->addRoute('GET', '/profissional/cadastro', [ProfissionalController::class, 'cadastro']);
    $r->addRoute('GET', '/profissional/habilidades', [ProfissionalController::class, 'habilidades']);
    $r->addRoute('GET', '/profissional/avalie', [ProfissionalController::class, 'avaliar']);
    $r->addRoute('POST', '/profissional/avaliou', [AvaliacaoController::class, 'avaliacao']);
    $r->addRoute('POST', '/profissional/habilidades/inserir', [ProfissionalController::class, 'habilidades_inserir']);
    $r->addRoute('POST', '/update-usuario', [ClienteController::class, 'updateUser']);
    $r->addRoute('POST', '/upload-imagem', [HomeController::class, 'updateImagem']);
    $r->addRoute('POST', '/enviar_cliente', [LocalizacaoController::class, 'enviar_cliente']);
    $r->addRoute('GET', '/enviar_imagem', [HomeController::class, 'enviarImagem']);
    $r->addRoute('GET', '/api/profissionais/{id:\d+}', [JsonController::Class, 'buscarProfissionais']);
    $r->addRoute('POST', '/api/habilidades', [JsonController::class, 'enviarHabilidades']);


    $r->addRoute('POST', '/enviar_profissional', [LocalizacaoController::class, 'enviar_profissional']);


};