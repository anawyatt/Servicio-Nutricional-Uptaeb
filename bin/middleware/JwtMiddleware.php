<?php
// JwtMiddleware.php
namespace middleware;

use helpers\JwtHelpers;
use helpers\encryption as encryption;
use helpers\BlacklistHelper;
class JwtMiddleware
{

    public static function verificarToken()
    {
        $sistem = new encryption();
        $token = $_COOKIE['jwt'] ?? null;

        if (!$token) {
            http_response_code(401);
            header('Location: ?url=' . urlencode($sistem->encryptURL('login')));
            echo json_encode(['error' => 'Token no encontrado']);
            exit;
        }

        $decoded = JwtHelpers::validarToken($token);

        if (!$decoded) {
            http_response_code(401);
            header('Location: ?url=' . urlencode($sistem->encryptURL('login')));
            echo json_encode(['error' => 'Token inválido o expirado']);
            exit;
        }
        
        if (BlacklistHelper::isBlacklisted($decoded->jti)) {
            header('Location: ?url=' . urlencode($sistem->encryptURL('login')));
            http_response_code(401);
            echo json_encode(['error' => 'Token revocado']);
            exit;
        }

        // Retornar el payload para que se use en controlador si hace falta
        return $decoded;
    }
}
