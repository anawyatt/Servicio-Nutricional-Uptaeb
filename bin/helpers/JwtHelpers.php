<?php
// JwtHelpers.php
namespace helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelpers
{
    private static $key = null; 
    private static $algo = 'HS256';
    private static $expTiempo = 3600*6; 

    public static function getKey(): string
    {
        if (self::$key === null) {
            self::$key = $_ENV['SECRET_KEY_JWT'] ?? $_ENV['SECRET_KEY'] ?? null;
        }
        return self::$key;
    }

    public static function generarToken(array $payload)
    {
        $time = time();

        // Añadir claims estándar
        $tokenPayload = array_merge($payload, [
            'iat' => $time,
            'exp' => $time + self::$expTiempo,
            'jti' => uniqid('jti_'),
        ]);

        return JWT::encode($tokenPayload, self::getKey(), self::$algo);
    }

    public static function validarToken(string $token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::getKey(), self::$algo));
            return $decoded; 
        } catch (\Exception $e) {
            return null;
        }
    }
}
