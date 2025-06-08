<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Usuario;

class AuthController
{
    public function login(Request $request, Response $response): Response
    {
        $params = (array) $request->getParsedBody();
        $usuario = $params['login'] ?? '';
        $clave = $params['pswd'] ?? '';

        $user = Usuario::where('login', $usuario)
                       //->where('pswd', md5($clave)) // Usar hashing real en producción
                       ->where('pswd', $clave) // Dev
                       ->first();

        if ($user) {
            $data = ['status' => 'ok', 'mensaje' => 'Bienvenido', 'name' => $user];
        } else {
            $data = ['status' => 'error', 'mensaje' => 'Usuario o Contraseña Incorrectas'];
        }

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
