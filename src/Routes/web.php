<?php
use Slim\App;
use App\Controllers\AuthController;

return function (App $app) {
    $app->get('/test', function ($request, $response) {
        $response->getBody()->write("API funciona");
        return $response;
    });
    $app->post('/login', [AuthController::class, 'login']);
};

