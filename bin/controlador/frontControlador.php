<?php

namespace bin\controlador;

use config\componentes\configSistema as configSistema;
use helpers\encryption as encryption;
use middleware\JwtMiddleware;  // Usamos el middleware de JWT
use helpers\JwtHelpers;

class frontControlador extends configSistema
{
    private $url;
    private $directory;
    private $controlador;
    private $sistem;
    private $cipher;
    private $jwtPayload; // Guardamos info del token aquí
    private $request;    // <-- NUEVA propiedad

    public function __construct($request)
    {
        $this->request = $request; // <-- Guardamos el request
        $this->sistem = new configSistema();
        $this->cipher = new encryption();
        
        if (isset($request["url"])) {
            $this->url = $request["url"];
            $this->directory = $this->sistem->_Dir_();
            $this->controlador = $this->sistem->_Control_();

            $this->validarURL();
        } else {
            // Si no se pasa URL, redirige al login
            $loginURL = urlencode($this->cipher->encryptURL('login'));
            die("<script>window.location='?url=" . $loginURL . "'</script>");
        }
    }

    private function validarURL()
    {
        $decryptedURL = $this->cipher->decryptURL($this->url);
        $pattern = preg_match("/^[\w\-\/]+$/", $decryptedURL);
        if ($pattern == 1) {
            $this->_loadPage($decryptedURL, $this->request); // <-- PASAMOS el segundo argumento
        } else {
            die('La URL ingresada es inválida');
        }
    }

    private function _loadPage($url, $request)
{
    $publicRoutes = ['login', 'cambiarClave'];

    if (!in_array($url, $publicRoutes)) {
        $this->jwtPayload = JwtMiddleware::verificarToken();
        if (!$this->jwtPayload) {
            $loginURL = urlencode($this->cipher->encryptURL('login'));
            die("<script>window.location='?url=" . $loginURL . "'</script>");
        }

    } else if ($url === 'cambiarClave') {

        if (isset($request["token"])) {
            $token = $request["token"];
            $payload = JwtHelpers::verificarTokenPersonalizado($token); 
            if (!$payload || $payload['tipo'] !== 'recuperacion') {
                die("Token inválido o expirado.");
            }
            $this->jwtPayload = $payload;
        } else {
            die("Token no proporcionado.");
        }
    }

    $pathControlador = $this->directory . $url . $this->controlador;
    if (file_exists($pathControlador)) {
        require_once($pathControlador);

        // ✅ Ejecutamos la función principal si existe
        if (function_exists('main')) {
            if ($url === 'cambiarClave') {
                main($this->jwtPayload); // ← Le pasas el payload aquí
            } 
        }
    } else {
        $loginURL = urlencode($this->cipher->encryptURL('login'));
        die("<script>window.location='?url=" . $loginURL . "'</script>");
    }
}

}
?>
