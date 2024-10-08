<?php
// public/index.php
ob_start();
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../config/functions.php';

use App\Services\DefaultServices;

$_SESSION['logado'] ??= false;

$dispatcher = FastRoute\simpleDispatcher(require __DIR__ . '/../config/routes.php');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$uri = rawurldecode(parse_url($uri, PHP_URL_PATH));

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 - A Página que você tentou acessar não encontrada no nosso sistema';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 - Método não permitido. Tente alternar entre GET e POST.';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;

        // Se for uma rota que retorna JSON, não inclua HTML
        if (strpos($uri, '/api/') === 0) {
            (new $controller)->$method($vars);
            exit;
        }

        // Para rotas que não são API, carregar cabeçalho e rodapé
        require_once __DIR__ . '/../App/views/template/header.php';
        (new $controller)->$method($vars);
        require_once __DIR__ . '/../App/views/template/footer.php';
        break;
}

?>
