<?php

use modelo\bitacoraModelo as bitacora;
use helpers\encryption as encryption;
use helpers\JwtHelpers;
use helpers\BlacklistHelper;

$sistem = new encryption();

$token = $_COOKIE['jwt'];
$payload = JwtHelpers::validarToken($token);
if (!$payload) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}

if (isset($payload->cedula)) {
    $bitacora = new bitacora;
    $bitacora->registrarBitacora('Login', 'El usuario ' . $payload->nombre . ' ' . $payload->apellido . '  cerró sesión ', $payload->cedula);

    BlacklistHelper::addToBlacklist($payload->jti, $payload->exp);
    setcookie('jwt', '', time() - 3600*6, '/', '', false, true);
    unset($_COOKIE['jwt']);
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
