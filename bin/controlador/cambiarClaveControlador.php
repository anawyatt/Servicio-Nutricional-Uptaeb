<?php

use component\initComponents as initComponents;
use helpers\encryption as encryption;
use modelo\cambiarClaveModelo as cambiarClave;


function main($jwtPayload) {

    $object = new cambiarClave();
    $components = new initComponents();
    $sistem = new encryption();

        $codigoEsperado = $jwtPayload['codigo'] ?? null;
        $email = $jwtPayload['correo'] ?? null;

        if (!$codigoEsperado || !$email) {
            die("Token inválido o incompleto cambiarclaveControlador.");
        }

        if (isset($_POST['token']) && isset($_POST['codigo']) && isset($_POST['nuevaClave']) && isset($_POST['confirmarClave'])) {
           
            if ($_POST['nuevaClave'] !== $_POST['confirmarClave']) {
                echo json_encode(['error' => 'Las contraseñas no coinciden.']);
                die();
            }   
         
            $respuesta = $object->actualizarClaveRecuperacion($_POST['token'], $_POST['codigo'], $_POST['nuevaClave'], $_POST['confirmarClave']);
            echo json_encode($respuesta);
            die();
        }
   
    if (file_exists("vista/cambiarClaveVista.php")) {
        require_once("vista/cambiarClaveVista.php");
    } else {
        die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
    }
}
