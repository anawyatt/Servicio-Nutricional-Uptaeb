<?php
namespace helpers;

class PostRateLimiter
{
    private static $cacheDir = __DIR__ . '/../cache/post_rate/';
    private static $limites = [
        'registrar' => 10,
        'modificar' => 10,
        'anular'    => 10,
        'consultar' => 10,
        'verificar' => 5,
    ];

    public static function verificar(string $accion, string $usuarioId): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset(self::$limites[$accion])) {
            return ['bloqueado' => false, 'intentos' => 0, 'espera' => 0];
        }

        if (!file_exists(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0777, true);
        }

        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $limiteUsuario = self::$limites[$accion];    
        $limiteIP = 300;                             
        $bloqueoMaximo = 300;                         
        $ahora = time();

 
        $fileUsuario = self::$cacheDir . 'user_' . $usuarioId . '_' . $accion . '.json';
        $fileIP = self::$cacheDir . 'ip_' . md5($ip) . '_' . $accion . '.json';

   
        $dataUsuario = self::leerData($fileUsuario);
        $dataIP = self::leerData($fileIP);

    
        if ($ahora - $dataUsuario['ultimo'] > $limiteUsuario) {
            @unlink($fileUsuario);
            $dataUsuario = ['ultimo' => $ahora, 'intentos' => 1];
        } else {
            $dataUsuario['intentos']++;
        }


        if ($ahora - $dataIP['ultimo'] > $limiteIP) {
            @unlink($fileIP);
            $dataIP = ['ultimo' => $ahora, 'intentos' => 1];
        } else {
            $dataIP['intentos']++;
        }


        file_put_contents($fileUsuario, json_encode($dataUsuario, JSON_PRETTY_PRINT));
        file_put_contents($fileIP, json_encode($dataIP, JSON_PRETTY_PRINT));

  
        $usuarioIntentos = $dataUsuario['intentos'];
        $ipIntentos = $dataIP['intentos'];

        $usuarioBloqueado = $usuarioIntentos >= 10;
        $bloqueoExtendido = $usuarioIntentos > 15;
        $ipBloqueada = $ipIntentos > 20;

        if ($usuarioBloqueado || $ipBloqueada) {
            $esperaUsuario = $bloqueoExtendido
                ? max(0, $bloqueoMaximo - ($ahora - $dataUsuario['ultimo']))
                : max(0, $limiteUsuario - ($ahora - $dataUsuario['ultimo']));

            $esperaIP = max(0, $limiteIP - ($ahora - $dataIP['ultimo']));

            return [
                'bloqueado' => true,
                'mensaje' => $usuarioBloqueado
                    ? ($bloqueoExtendido
                        ? "Has superado los 15 intentos. Bloqueado por 5 minutos."
                        : "Demasiados intentos. Espera $esperaUsuario segundos.")
                    : "Demasiadas peticiones desde tu red. Espera $esperaIP segundos.",
                'intentos' => max($usuarioIntentos, $ipIntentos),
                'espera' => max($esperaUsuario, $esperaIP)
            ];
        }

        return [
            'bloqueado' => false,
            'intentos' => $usuarioIntentos,
            'espera' => 0
        ];
    }

    public static function reiniciarContador(string $accion, string $usuarioId): void
    {
        $file = self::$cacheDir . 'user_' . $usuarioId . '_' . $accion . '.json';
        if (file_exists($file)) {
            unlink($file);
        }

        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $fileIP = self::$cacheDir . 'ip_' . md5($ip) . '_' . $accion . '.json';
        if (file_exists($fileIP)) {
            unlink($fileIP);
        }
    }

    private static function leerData(string $file): array
    {
        $data = ['ultimo' => 0, 'intentos' => 0];
        if (file_exists($file)) {
            $contenido = file_get_contents($file);
            $json = json_decode($contenido, true);
            if (is_array($json)) {
                $data = $json;
            }
        }
        return $data;
    }
}
