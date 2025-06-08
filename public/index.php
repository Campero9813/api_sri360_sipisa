<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface as Response;

// Cargar .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Contenedor de dependencias
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// Detecta basePath automáticamente o lo defines fijo
$app->setBasePath('/api_sri_360_sipisa/public');

// 👉 Middleware CORS: ahora que $app ya existe, esto sí funciona
$app->add(function (Request $request, RequestHandlerInterface $handler): Response {
    error_log("👉 Middleware CORS ejecutado");
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Ruta OPTIONS para preflight CORS
$app->options('/{routes:.+}', function (Request $request, Response $response) {
    return $response;
});

// Config BD
require __DIR__ . '/../src/Config/database.php';

// Rutas
(require __DIR__ . '/../src/Routes/web.php')($app);

// Logging de URI
$app->add(function ($request, $handler) {
    error_log("Request URI: " . $request->getUri()->getPath());
    return $handler->handle($request);
});

$app->run();
