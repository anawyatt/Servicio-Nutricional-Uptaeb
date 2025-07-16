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

    public static function verificarLimiteDiarioExitoso($correo)
    {
        self::limpiezaAutomatica(); // Limpieza previa

        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);
        $hoy = date('Y-m-d');

        if (!isset($data[$hash]['exitosos'])) {
            return ['bloqueado' => false, 'mensaje' => '', 'registro' => true];
        }

        $registro = $data[$hash]['exitosos'];

        // Si es otro día, reiniciar
        if ($registro['fecha'] !== $hoy) {
            $data[$hash]['exitosos'] = [
                'contador' => 1,
                'fecha' => $hoy,
                'bloqueado_hasta' => null,
            ];
            self::guardarArchivo($data);
            return ['bloqueado' => false, 'mensaje' => '', 'registro' => true];
        }

        if (isset($registro['bloqueado_hasta']) && time() < $registro['bloqueado_hasta']) {
            $horas = ceil(($registro['bloqueado_hasta'] - time()) / 3600);
            return ['bloqueado' => true, 'mensaje' => "Ha superado el número de solicitudes permitidas. Intente nuevamente en $horas horas."];
        }

        if ($registro['contador'] >= 3) {
            $data[$hash]['exitosos']['bloqueado_hasta'] = time() + (24 * 60 * 60); // 24 horas
            self::guardarArchivo($data);
            return ['bloqueado' => true, 'mensaje' => "Ha superado el número de solicitudes permitidas. Intente nuevamente mañana."];
        }

        return ['bloqueado' => false, 'mensaje' => '', 'registro' => true];
    }

   public static function restarIntentoExitoso($correo)
    {
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);
        $hoy = date('Y-m-d');

        if (isset($data[$hash]['exitosos']) && $data[$hash]['exitosos']['fecha'] === $hoy) {
            if ($data[$hash]['exitosos']['contador'] > 0) {
                $data[$hash]['exitosos']['contador']--;
                self::guardarArchivo($data);
            }
        }
    }


}
