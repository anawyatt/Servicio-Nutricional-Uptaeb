<?php
namespace helpers;

class ConteoRecuperarHelpers
{
    private static $filePath = __DIR__ . '/../cache/recuperacion_intentos.json';
    private static $secretKey = null;

    public static function getKey(): string
    {
        if (self::$secretKey === null) {
            self::$secretKey = getenv('SECRET_KEY_SISIRVE') ?: 'default_key';
        }
        return self::$secretKey;
    }

    private static function hashCorreo($correo)
    {
        return hash('sha256', strtolower(trim($correo)) . self::getKey());
    }

    public static function verificarBloqueo($correo)
    {
        self::limpiezaAutomatica();

        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);

        if (!isset($data[$hash])) {
            return ['bloqueado' => false, 'mensaje' => ''];
        }

        if ($data[$hash]['bloqueado_hasta'] && time() < $data[$hash]['bloqueado_hasta']) {
            $minutos = ceil(($data[$hash]['bloqueado_hasta'] - time()) / 60);
            return ['bloqueado' => true, 'mensaje' => "Usuario bloqueado. Intente nuevamente en $minutos minutos."];
        }

        if ($data[$hash]['bloqueado_hasta'] && time() >= $data[$hash]['bloqueado_hasta']) {
            unset($data[$hash]);
            self::guardarArchivo($data);
        }

        return ['bloqueado' => false, 'mensaje' => ''];
    }

    public static function registrarIntento($correo)
    {
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);

        if (isset($data[$hash]) && $data[$hash]['bloqueado_hasta'] && time() >= $data[$hash]['bloqueado_hasta']) {
            unset($data[$hash]);
        }

        if (!isset($data[$hash])) {
            $data[$hash] = [
                'intentos' => 0,
                'bloqueado_hasta' => null,
                'primer_intento' => time(),
            ];
        }

        if ($data[$hash]['intentos'] < 4 && !$data[$hash]['bloqueado_hasta']) {
            $data[$hash]['intentos']++;
        }

        if ($data[$hash]['intentos'] >= 4) {
            $data[$hash]['intentos'] = 4;
            $data[$hash]['bloqueado_hasta'] = time() + 300; // Bloqueo 5 minutos
            self::guardarArchivo($data);
            return ['bloqueado' => true, 'mensaje' => 'Usuario bloqueado por múltiples intentos fallidos.'];
        }

        self::guardarArchivo($data);
        return ['bloqueado' => false, 'mensaje' => "Intento registrado. Le quedan " . (4 - $data[$hash]['intentos']) . " intentos."];
    }

    public static function resetearIntentos($correo)
    {
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);

        if (isset($data[$hash])) {
            unset($data[$hash]);
        }

        self::guardarArchivo($data);
    }

    private static function limpiezaAutomatica()
    {
        $data = self::leerArchivo();
        $tiempoActual = time();
        $unDia = 24 * 60 * 60;
        $cambios = false;

        foreach ($data as $hash => $info) {
            if ($info['bloqueado_hasta'] && $tiempoActual >= $info['bloqueado_hasta']) {
                unset($data[$hash]);
                $cambios = true;
                continue;
            }
            if (!$info['bloqueado_hasta'] && isset($info['primer_intento'])) {
                if ($tiempoActual - $info['primer_intento'] > $unDia) {
                    unset($data[$hash]);
                    $cambios = true;
                }
            }
        }

        if ($cambios) {
            self::guardarArchivo($data);
        }
    }

    private static function leerArchivo()
    {
        if (!file_exists(self::$filePath)) {
            return [];
        }
        $content = file_get_contents(self::$filePath);
        return json_decode($content, true) ?? [];
    }

    private static function guardarArchivo($data)
    {
        file_put_contents(self::$filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
