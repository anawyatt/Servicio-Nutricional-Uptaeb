<?php
namespace middleware;

use helpers\PostRateLimiter;

class PostRateMiddleware
{
    
    public static function verificar(string $accion, array $payload): void
    {
        if (!isset($payload['cedula'])) {
            
            return;
        }

        $usuarioId = $payload['cedula'];
        $resultado = PostRateLimiter::verificar($accion, $usuarioId);

        if ($resultado['bloqueado']) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'estado' => 'bloqueado',
                'mensaje' => $resultado['mensaje'],
                'espera' => $resultado['espera'],
                'intentos' => $resultado['intentos']
            ]);
            exit;
        }
    }
}
