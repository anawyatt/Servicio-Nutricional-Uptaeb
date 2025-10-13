<?php
namespace helpers;

class BlacklistHelper
{
    private static $file = __DIR__ . '/../cache/blacklist.json';
    private static $cacheDir = __DIR__ . '/../cache';
    
   
    private static function initializeCache(): bool
    {
        // Crear directorio cache si no existe
        if (!is_dir(self::$cacheDir)) {
            if (!mkdir(self::$cacheDir, 0755, true)) {
                error_log("No se pudo crear el directorio cache: " . self::$cacheDir);
                return false;
            }
        }
        
        // Verificar permisos del directorio
        if (!is_writable(self::$cacheDir)) {
            error_log("El directorio cache no tiene permisos de escritura: " . self::$cacheDir);
            return false;
        }
        
        return true;
    }
   
    private static function readBlacklist(): array
    {
        // Inicializar cache
        if (!self::initializeCache()) {
            return [];
        }
        
        // Crear archivo si no existe
        if (!file_exists(self::$file)) {
            if (file_put_contents(self::$file, json_encode([])) === false) {
                error_log("No se pudo crear el archivo blacklist.json. Verifica los permisos del directorio: " . self::$cacheDir);
                return [];
            }
            chmod(self::$file, 0644); 
        }

        // Verificar permisos de escritura
        if (!is_writable(self::$file)) {
            error_log("El archivo blacklist.json no tiene permisos de escritura: " . self::$file);
        
            if (!chmod(self::$file, 0644)) {
                error_log("No se pudieron corregir los permisos del archivo blacklist.json");
                return [];
            }
        }

        // Leer contenido
        $content = file_get_contents(self::$file);
        if ($content === false) {
            error_log("No se pudo leer el archivo blacklist.json");
            return [];
        }
        
        $list = json_decode($content, true);
        if ($list === null) {
            error_log("Error al decodificar JSON del archivo blacklist.json");
            $list = [];
        }

        // Limpiar tokens expirados
        $now = time();
        $cleaned = false;
        foreach ($list as $jti => $exp) {
            if ($exp < $now) {
                unset($list[$jti]);
                $cleaned = true;
            }
        }

        // Guardar lista limpia solo si se hicieron cambios
        if ($cleaned) {
            if (file_put_contents(self::$file, json_encode($list, JSON_PRETTY_PRINT)) === false) {
                error_log("No se pudo actualizar el archivo blacklist.json después de limpiar tokens expirados");
            } else {
                chmod(self::$file, 0644);
            }
        }
        
        return $list;
    }
    
    public static function addToBlacklist(string $jti, int $exp): bool
    {
        try {
            $list = self::readBlacklist();
            $list[$jti] = $exp;
            
            $result = file_put_contents(self::$file, json_encode($list, JSON_PRETTY_PRINT));
            if ($result === false) {
                error_log("No se pudo escribir en blacklist.json al agregar token: $jti");
                return false;
            }
            
            chmod(self::$file, 0644);
            return true;
            
        } catch (\Exception $e) {
            error_log("Error al agregar token a blacklist: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un jti está en blacklist
     */
    public static function isBlacklisted(string $jti): bool
    {
        try {
            $list = self::readBlacklist();
            return isset($list[$jti]) && $list[$jti] > time();
        } catch (\Exception $e) {
            error_log("Error al verificar blacklist: " . $e->getMessage());
            return false; // En caso de error, permitir el acceso
        }
    }
    
    /**
     * Limpiar manualmente tokens expirados
     */
    public static function cleanExpiredTokens(): int
    {
        $list = self::readBlacklist();
        $now = time();
        $removed = 0;
        
        foreach ($list as $jti => $exp) {
            if ($exp < $now) {
                unset($list[$jti]);
                $removed++;
            }
        }
        
        if ($removed > 0) {
            file_put_contents(self::$file, json_encode($list, JSON_PRETTY_PRINT));
            chmod(self::$file, 0644);
        }
        
        return $removed;
    }
    
    /**
     * Obtener estadísticas de la blacklist
     */
    public static function getStats(): array
    {
        $list = self::readBlacklist();
        $now = time();
        $active = 0;
        $expired = 0;
        
        foreach ($list as $exp) {
            if ($exp > $now) {
                $active++;
            } else {
                $expired++;
            }
        }
        
        return [
            'total' => count($list),
            'active' => $active,
            'expired' => $expired,
            'file_exists' => file_exists(self::$file),
            'file_writable' => is_writable(self::$file),
            'dir_writable' => is_writable(self::$cacheDir)
        ];
    }
}