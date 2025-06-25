<?php

use component\initComponents as initComponents;
use helpers\encryption as encryption;
use helpers\JwtHelpers;
use modelo\cambiarClaveModelo as cambiarClave;

function main() {
    $object = new cambiarClave();
    $components = new initComponents();
    $sistem = new encryption();

    // 🔒 Obtener el token desde la URL
    $token = $_GET['token'] ?? null;

    if (!$token) {
        die("Token de recuperación no proporcionado.");
    }

    // 🔐 Verificar el token recibido
    $jwtPayload = JwtHelpers::verificarTokenPersonalizado($token);

    if (!$jwtPayload || !isset($jwtPayload['tipo']) || $jwtPayload['tipo'] !== 'recuperacion') {
        die("Token inválido o manipulado.");
    }

    // ⏳ Verificar expiración del token
    if (!isset($jwtPayload['exp']) || $jwtPayload['exp'] < time()) {
        die("El enlace ha expirado. Por favor, solicita una nueva recuperación de contraseña.");
    }

    // ✅ Obtener datos del token
    $codigoEsperado = $jwtPayload['codigo'] ?? null;
    $email = $jwtPayload['correo'] ?? null;

    if (!$codigoEsperado || !$email) {
        die("Token incompleto.");
    }

    // 📝 Procesar el formulario si se envió
    if (isset($_POST['token'], $_POST['codigo'], $_POST['nuevaClave'], $_POST['confirmarClave'])) {

        if ($_POST['nuevaClave'] !== $_POST['confirmarClave']) {
            echo json_encode(['error' => 'Las contraseñas no coinciden.']);
            die();
        }

        $respuesta = $object->actualizarClaveRecuperacion(
            $_POST['token'],
            $_POST['codigo'],
            $_POST['nuevaClave'],
            $_POST['confirmarClave']
        );
        echo json_encode($respuesta);
        die();
    }

    // 🖼️ Cargar la vista si existe
    if (file_exists("vista/cambiarClaveVista.php")) {
        require_once("vista/cambiarClaveVista.php");
    } else {
        die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
    }
}
