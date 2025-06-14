<?php

namespace bin\controlador;

use config\componentes\configSistema as configSistema;
use helpers\encryption as encryption;
use middleware\JwtMiddleware;  // Usamos el middleware de JWT

class frontControlador extends configSistema
{
    private $url;
    private $directory;
    private $controlador;
    private $sistem;
    private $cipher;
    private $jwtPayload; // Guardamos info del token aquí

    public function __construct($request)
    {
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
            $this->_loadPage($decryptedURL);
        } else {
            die('La URL ingresada es inválida');
        }
    }

    private function _loadPage($url)
    {
        $publicRoutes = ['login'];
        if (!in_array($url, $publicRoutes)) {
            $this->jwtPayload = JwtMiddleware::verificarToken();
            if (!$this->jwtPayload) {
                $loginURL = urlencode($this->cipher->encryptURL('login'));
                die("<script>window.location='?url=" . $loginURL . "'</script>");
            }

        }

        // Si la URL es válida, cargar el controlador correspondiente
        $pathControlador = $this->directory . $url . $this->controlador;
        error_log("Intentando cargar controlador: " . $pathControlador);

        if (file_exists($pathControlador)) {
            require_once($pathControlador);
        } else {
            // Si no se encuentra el archivo del controlador, redirigir a login
            error_log("Controlador no encontrado para URL: " . $url);
            $loginURL = urlencode($this->cipher->encryptURL('login'));
            die("<script>window.location='?url=" . $loginURL . "'</script>");
        }
    }
}
?>
