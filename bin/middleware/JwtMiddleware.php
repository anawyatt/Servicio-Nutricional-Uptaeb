<?php
// JwtMiddleware.php
namespace middleware;

use helpers\JwtHelpers;
use helpers\BlacklistHelper;

class JwtMiddleware
{
    public static function verificarToken()
    {
        $token = null;

        // Intentar obtener el token desde la cabecera Authorization
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                $token = $matches[1];
            }
        }

        // Si no se encontró en la cabecera, intentar desde la cookie
        if (!$token && isset($_COOKIE['jwt'])) {
            $token = $_COOKIE['jwt'];
        }

        // Si aún no hay token, responder con error
        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'Token no encontrado']);
            exit;
        }

        // Validar el token
        $decoded = JwtHelpers::validarToken($token);

        if (!$decoded) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit;
        }

        // Verificar si está en lista negra
        if (BlacklistHelper::isBlacklisted($decoded->jti)) {
            http_response_code(401);
            echo json_encode(['error' => 'Token revocado']);
            exit;
        }

        // Retornar el payload
        return $decoded;
    }

}
