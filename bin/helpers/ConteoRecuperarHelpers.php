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

    private static function leerArchivo()
    {
        if (!file_exists(self::$filePath)) {
            return [];
        }

        $fp = fopen(self::$filePath, 'r');
        if (!$fp) {
            return [];
        }

        flock($fp, LOCK_SH);
        $content = stream_get_contents($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        return json_decode($content, true) ?? [];
    }

    private static function guardarArchivo($data)
    {
        $fp = fopen(self::$filePath, 'c+');
        if (!$fp) {
            throw new \Exception("No se pudo abrir el archivo para guardar los intentos.");
        }

        flock($fp, LOCK_EX);

        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));

        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    private static function limpiezaAutomatica()
    {
        $data = self::leerArchivo();
        $tiempoActual = time();
        $unDia = 24 * 60 * 60;
        $cambios = false;

        foreach ($data as $hash => $info) {
            if (isset($info['bloqueado_hasta']) && $tiempoActual >= $info['bloqueado_hasta']) {
                unset($data[$hash]);
                $cambios = true;
                continue;
            }

            if (isset($info['exitosos']['bloqueado_hasta']) && $tiempoActual >= $info['exitosos']['bloqueado_hasta']) {
                unset($data[$hash]['exitosos']);
                $cambios = true;
            }

            if (!isset($info['bloqueado_hasta']) && (!isset($info['exitosos']['bloqueado_hasta']))) {
                if (isset($info['primer_intento']) && ($tiempoActual - $info['primer_intento'] > $unDia)) {
                    unset($data[$hash]);
                    $cambios = true;
                }
            }
        }

        if ($cambios) {
            self::guardarArchivo($data);
        }
    }

    public static function verificarBloqueo($correo)
    {
        self::limpiezaAutomatica();
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);

        if (!isset($data[$hash])) {
            return ['bloqueado' => false, 'mensaje' => ''];
        }

        if (isset($data[$hash]['bloqueado_hasta']) && time() < $data[$hash]['bloqueado_hasta']) {
            $minutos = ceil(($data[$hash]['bloqueado_hasta'] - time()) / 60);
            return ['bloqueado' => true, 'mensaje' => "Usuario bloqueado por intentos fallidos. Intente en $minutos minutos."];
        }

        return ['bloqueado' => false, 'mensaje' => ''];
    }

    public static function registrarIntento($correo)
    {
        self::limpiezaAutomatica();
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);
        $now = time();

        if (isset($data[$hash]['bloqueado_hasta']) && $now >= $data[$hash]['bloqueado_hasta']) {
            unset($data[$hash]);
        }

        if (!isset($data[$hash])) {
            $data[$hash] = [
                'intentos' => 1,
                'primer_intento' => $now,
                'bloqueado_hasta' => null,
            ];
        } else {
            if ($now - $data[$hash]['primer_intento'] > 300) { 
                $data[$hash]['intentos'] = 1;
                $data[$hash]['primer_intento'] = $now;
                $data[$hash]['bloqueado_hasta'] = null;
            } else {
                $data[$hash]['intentos']++;
            }
        }

        if ($data[$hash]['intentos'] >= 2) {
            $data[$hash]['bloqueado_hasta'] = $now + 300; 
            self::guardarArchivo($data);
            return ['bloqueado' => true, 'mensaje' => 'Usuario bloqueado por múltiples intentos fallidos. Intente en 5 minutos.'];
        }

        self::guardarArchivo($data);
        return ['bloqueado' => false, 'mensaje' => "Intento fallido registrado. Le quedan " . (2 - $data[$hash]['intentos']) . " intentos."];
    }

    public static function resetearIntentos($correo)
    {
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);

        if (isset($data[$hash])) {

            unset($data[$hash]['intentos']);
            unset($data[$hash]['primer_intento']);
            unset($data[$hash]['bloqueado_hasta']);

            if (empty($data[$hash])) {
                unset($data[$hash]);
            }
            self::guardarArchivo($data);
        }
    }

    public static function verificarLimiteDiarioExitoso($correo)
    {
        self::limpiezaAutomatica();
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);
        $hoy = date('Y-m-d');
        $now = time();

        if (!isset($data[$hash]['exitosos'])) {
            return ['bloqueado' => false, 'mensaje' => '', 'registro' => true];
        }

        $registro = $data[$hash]['exitosos'];

        if (isset($registro['bloqueado_hasta']) && $now < $registro['bloqueado_hasta']) {
            $horas = ceil(($registro['bloqueado_hasta'] - $now) / 3600);
            return ['bloqueado' => true, 'mensaje' => "Ha superado el número de solicitudes permitidas. Intente nuevamente en $horas horas."];
        }

        if ($registro['fecha'] !== $hoy) {
            $data[$hash]['exitosos'] = [
                'contador' => 0,
                'fecha' => $hoy,
                'bloqueado_hasta' => null,
            ];
            self::guardarArchivo($data);
            return ['bloqueado' => false, 'mensaje' => '', 'registro' => true];
        }

        if ($registro['contador'] >= 2) {
            $data[$hash]['exitosos']['bloqueado_hasta'] = $now + (24 * 60 * 60); // 24 horas
            self::guardarArchivo($data);
            return ['bloqueado' => true, 'mensaje' => "Ha superado el número de solicitudes permitidas. Intente nuevamente mañana."];
        }

        return ['bloqueado' => false, 'mensaje' => '', 'registro' => true];
    }

    public static function registrarIntentoExitoso($correo)
    {
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);
        $hoy = date('Y-m-d');
        $now = time();

        if (!isset($data[$hash]['exitosos'])) {
            $data[$hash]['exitosos'] = [
                'contador' => 1,
                'fecha' => $hoy,
                'bloqueado_hasta' => null,
            ];
        } else {
            if ($data[$hash]['exitosos']['fecha'] !== $hoy) {
                $data[$hash]['exitosos']['contador'] = 1;
                $data[$hash]['exitosos']['fecha'] = $hoy;
                $data[$hash]['exitosos']['bloqueado_hasta'] = null;
            } else {
                $data[$hash]['exitosos']['contador']++;

                if ($data[$hash]['exitosos']['contador'] > 2) {
                    $data[$hash]['exitosos']['bloqueado_hasta'] = $now + (24 * 60 * 60);
                }
            }
        }

        self::guardarArchivo($data);
    }

    public static function restarIntentoExitoso($correo)
    {
        $data = self::leerArchivo();
        $hash = self::hashCorreo($correo);
        $hoy = date('Y-m-d');

        if (isset($data[$hash]['exitosos']) && isset($data[$hash]['exitosos']['fecha']) && $data[$hash]['exitosos']['fecha'] === $hoy) {
            if ($data[$hash]['exitosos']['contador'] > 0) {
                $data[$hash]['exitosos']['contador']--;
                self::guardarArchivo($data);
            }
        }
    }
}
