<?php

namespace helpers;

class ConteoLoginHelpers
{
    private static $filePath = __DIR__ . '/../cache/login_attempts.json';
    private static $secretKey = null;

    public static function getKey(): string
    {
        if (self::$secretKey === null) {
            self::$secretKey = getenv('SECRET_KEY_SISIRVE') ?: 'default_key';
        }
        return self::$secretKey;
    }

    private static function hashCedula($cedula)
    {
        // Usando SHA256 con una clave secreta para mayor seguridad
        return hash('sha256', $cedula . self::getKey());
    }

    // Nuevo método para solo verificar bloqueo sin registrar intento
    public static function verificarBloqueo($cedula)
    {
        // Ejecutar limpieza automática antes de verificar
        self::limpiezaAutomatica();

        $data = self::leerArchivo();
        $cedulaHash = self::hashCedula($cedula);

        if (!isset($data[$cedulaHash])) {
            return ['bloqueado' => false, 'mensaje' => ''];
        }

        // Verificar si está bloqueado
        if ($data[$cedulaHash]['bloqueado_hasta'] && time() < $data[$cedulaHash]['bloqueado_hasta']) {
            $tiempoRestante = ceil(($data[$cedulaHash]['bloqueado_hasta'] - time()) / 60);
            return ['bloqueado' => true, 'mensaje' => "Usuario bloqueado. Intente nuevamente en $tiempoRestante minutos."];
        }

        // Si el bloqueo ya expiró, limpiar los datos del usuario
        if ($data[$cedulaHash]['bloqueado_hasta'] && time() >= $data[$cedulaHash]['bloqueado_hasta']) {
            unset($data[$cedulaHash]);
            self::guardarArchivo($data);
            error_log("Bloqueo expirado: Limpiados intentos para hash " . substr($cedulaHash, 0, 8));
        }

        return ['bloqueado' => false, 'mensaje' => ''];
    }

    // Este método ahora solo registra intentos fallidos
    public static function registrarIntento($cedula)
    {
        $data = self::leerArchivo();
        $cedulaHash = self::hashCedula($cedula);

        // Verificar si el usuario tenía un bloqueo que ya expiró
        if (isset($data[$cedulaHash]) && $data[$cedulaHash]['bloqueado_hasta'] && time() >= $data[$cedulaHash]['bloqueado_hasta']) {
            // El bloqueo ya expiró, limpiar los datos y empezar de nuevo
            unset($data[$cedulaHash]);
            error_log("Bloqueo expirado al registrar intento: Limpiados intentos para hash " . substr($cedulaHash, 0, 8));
        }

        if (!isset($data[$cedulaHash])) {
            $data[$cedulaHash] = [
                'intentos' => 0,
                'bloqueado_hasta' => null,
                'primer_intento' => time(), // Registrar cuándo fue el primer intento
                'hash_info' => substr($cedulaHash, 0, 8) // Solo los primeros 8 caracteres para debugging
            ];
        }

        // Incrementar intentos solo si no está bloqueado y el intento no es exitoso
        if ($data[$cedulaHash]['intentos'] < 4 && !$data[$cedulaHash]['bloqueado_hasta']) {
            $data[$cedulaHash]['intentos']++;
        }

        // Asegurarse de que los intentos no superen el límite de 4
        if ($data[$cedulaHash]['intentos'] >= 4) {
            $data[$cedulaHash]['intentos'] = 4; // Fijar el límite máximo
            $data[$cedulaHash]['bloqueado_hasta'] = time() + 300; // Bloquear por 5 minutos
            self::guardarArchivo($data);
            return ['bloqueado' => true, 'mensaje' => 'Usuario bloqueado por múltiples intentos fallidos.'];
        }

        self::guardarArchivo($data);
        return ['bloqueado' => false, 'mensaje' => "Intento registrado. Le quedan " . (3 - $data[$cedulaHash]['intentos']) . " intentos."];
    }

    public static function resetearIntentos($cedula)
    {
        $data = self::leerArchivo();
        $cedulaHash = self::hashCedula($cedula);

        if (isset($data[$cedulaHash])) {
            unset($data[$cedulaHash]);
        }

        self::guardarArchivo($data);
    }

    // Nueva función para limpieza automática
    public static function limpiezaAutomatica()
    {
        $data = self::leerArchivo();
        $tiempoActual = time();
        $unDiaEnSegundos = 24 * 60 * 60; // 24 horas en segundos
        $cambiosRealizados = false;

        foreach ($data as $cedulaHash => $info) {
            // Limpiar usuarios cuyo bloqueo ya expiró
            if ($info['bloqueado_hasta'] && $tiempoActual >= $info['bloqueado_hasta']) {
                unset($data[$cedulaHash]);
                $cambiosRealizados = true;
                error_log("Limpieza automática: Bloqueo expirado para hash " . substr($cedulaHash, 0, 8));
                continue; // Pasar al siguiente usuario
            }

            // Solo limpiar usuarios que NO están bloqueados actualmente por tiempo (24 horas)
            $estaBloqueado = $info['bloqueado_hasta'] && $tiempoActual < $info['bloqueado_hasta'];

            if (!$estaBloqueado && isset($info['primer_intento'])) {
                // Si han pasado más de 24 horas desde el primer intento
                $tiempoTranscurrido = $tiempoActual - $info['primer_intento'];

                if ($tiempoTranscurrido > $unDiaEnSegundos) {
                    unset($data[$cedulaHash]);
                    $cambiosRealizados = true;
                    error_log("Limpieza automática: Eliminados intentos antiguos para hash " . substr($cedulaHash, 0, 8) . " (más de 24 horas)");
                }
            }
        }

        if ($cambiosRealizados) {
            self::guardarArchivo($data);
        }
    }

  
    public static function limpiezaManual()
    {
        self::limpiezaAutomatica();
        return "Limpieza manual ejecutada correctamente.";
    }


    public static function obtenerEstadisticas()
    {
        $data = self::leerArchivo();
        $tiempoActual = time();
        $estadisticas = [
            'total_usuarios' => count($data),
            'usuarios_bloqueados' => 0,
            'usuarios_con_intentos' => 0,
            'intentos_antiguos' => 0
        ];

        $unDiaEnSegundos = 24 * 60 * 60;

        foreach ($data as $cedulaHash => $info) {
            
            if ($info['bloqueado_hasta'] && $tiempoActual < $info['bloqueado_hasta']) {
                $estadisticas['usuarios_bloqueados']++;
            } else {
                $estadisticas['usuarios_con_intentos']++;

              
                if (isset($info['primer_intento'])) {
                    $tiempoTranscurrido = $tiempoActual - $info['primer_intento'];
                    if ($tiempoTranscurrido > $unDiaEnSegundos) {
                        $estadisticas['intentos_antiguos']++;
                    }
                }
            }
        }

        return $estadisticas;
    }


    public static function existeCedula($cedula)
    {
        $data = self::leerArchivo();
        $cedulaHash = self::hashCedula($cedula);
        return isset($data[$cedulaHash]);
    }


    public static function obtenerInfoCedula($cedula)
    {
        $data = self::leerArchivo();
        $cedulaHash = self::hashCedula($cedula);

        if (isset($data[$cedulaHash])) {
            $info = $data[$cedulaHash];
            $info['cedula_hash'] = $cedulaHash;
            return $info;
        }

        return null;
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
