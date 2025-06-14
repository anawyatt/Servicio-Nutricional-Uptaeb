<?php
namespace helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class csrfTokenHelper
{
    public static function generateCsrfToken(string $userId): string
    {
        $csrfSecret = $_ENV['CSRF_SECRET_KEY'] ?? $_ENV['SECRET_KEY'] ?? null;
        if (!$csrfSecret) {
            throw new \RuntimeException('Clave secreta CSRF no definida.');
        }

        $now = time();
        $payload = [
            'iat' => $now,
            'exp' => $now + 300, // 5 minutos
            'uid' => $userId,
            'type' => 'csrf',
            'iss' => 'mi-aplicacion',
            'aud' => 'mi-aplicacion-frontend'
        ];

        return JWT::encode($payload, $csrfSecret, 'HS256');
    }

    public static function validateAndRefreshCsrfToken(string $token, string $userId): array
    {
        if (empty($token) || !is_string($token) || empty($userId) || !is_string($userId)) {
            return ['valid' => false, 'newToken' => null];
        }

        try {
            $csrfSecret = $_ENV['CSRF_SECRET_KEY'] ?? $_ENV['SECRET_KEY'] ?? null;
            if (!$csrfSecret) {
                throw new \RuntimeException('Clave secreta CSRF no definida.');
            }

            $decoded = JWT::decode($token, new Key($csrfSecret, 'HS256'));

            if ($decoded->type !== 'csrf' || $decoded->uid !== $userId) {
                return ['valid' => false, 'newToken' => null];
            }

            $newToken = self::generateCsrfToken($userId);
            return ['valid' => true, 'newToken' => $newToken];

        } catch (\Throwable $e) {
            return ['valid' => false, 'newToken' => null];
        }
    }
}


?>
