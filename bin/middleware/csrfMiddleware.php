<?php
namespace middleware;

use helpers\csrfTokenHelper;

class csrfMiddleware
{
    public static function verificarYRenovar(string $token, string $userId): array
    {
        $resultado = csrfTokenHelper::validateAndRefreshCsrfToken($token, $userId);

        if (!$resultado['valid']) {
            http_response_code(403);
            echo json_encode([
                'error' => 'Token CSRF inválido o expirado.',
                'newCsrfToken' => null
            ]);
            die();
        }

        return $resultado;
    }

    public static function verificarCsrfToken(string $userId, ?string $token = null): array
    {
        $token = $token ?? ($_POST['csrfToken'] ?? null);

        if (!$token || !$userId) {
            http_response_code(403);
            echo json_encode([
                'error' => 'Token CSRF no proporcionado o inválido.',
                'newCsrfToken' => null
            ]);
            die();
        }

        $resultado = csrfTokenHelper::validateAndRefreshCsrfToken($token, $userId);

        if (!$resultado['valid']) {
            http_response_code(403);
            echo json_encode([
                'error' => 'Token CSRF inválido o expirado.',
                'newCsrfToken' => null
            ]);
            die();
        }

        return $resultado;
    }
}
