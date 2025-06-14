<?php
namespace helpers;

use helpers\JwtHelpers; // Asegúrate de tener acceso a JwtHelpers para leer el token

class permisosHelper {

    public static function verificarPermisos($sistem, $objeto, $modulo, $accion) {
        if (!isset($_COOKIE['jwt'])) {
            die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
        }

        $token = $_COOKIE['jwt'];
        $payload = JwtHelpers::validarToken($token); // Obtener el payload del JWT
        

        if (!$payload) {
            die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
        }

        $permisos = $objeto->getPermisosRol($payload->rol);
        if (!isset($permisos[$modulo])) {
            die("<script>window.location='?url=" . urlencode($sistem->encryptURL('home')) . "'</script>");
        }

        $permiso = $permisos[$modulo];

        if (!isset($permiso[$accion])) {
            die("<script>window.location='?url=" . urlencode($sistem->encryptURL('home')) . "'</script>");
        }

        if (isset($_POST['getPermisos']) && isset($permiso[$accion])) {
            die(json_encode($permiso));
        }

        return [
            'permisos' => $permisos,
            'permiso' => $permiso,
            'payload' =>$payload
        ];
    }
}


?>

