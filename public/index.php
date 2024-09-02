<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../config/functions.php';

use App\Services\DefaultServices;

session_start();

$_SESSION['logado'] ??= false;

$dispatcher = FastRoute\simpleDispatcher(require __DIR__ . '/../config/routes.php');

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$uri = rawurldecode(parse_url($uri, PHP_URL_PATH));

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 - Página não encontrada';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 - Método não permitido';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;

        if ($method == 'deslogar'){
            DefaultServices::deslogar();
        }

        require_once __DIR__ . '/../App/views/template/header.php';

        (new $controller)->$method($vars);

        require_once __DIR__ . '/../App/views/template/footer.php';
        break;
}
?>
