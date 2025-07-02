<?php

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../../vendor/autoload.php';

use Dotenv\Dotenv;
use modelo\cambiarClaveModelo;
use helpers\decryptionAsyncHelpers;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->safeLoad();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['datos'])) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Faltan datos cifrados']);
    exit;
}


try {
    $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

    if (!isset($data['cambiarClave'], $data['codigo'], $data['clave'], $data['clave2'], $data['correo'])) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Los datos para cambiar contraseña son requeridos']);
        exit;
    }

    $objeto = new cambiarClaveModelo();
    $respuesta = $objeto->actualizarClaveRecuperacionApp(
        $data['codigo'],
        $data['clave'],
        $data['clave2'],
        $data['correo'] 

    );

    echo json_encode($respuesta);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}

