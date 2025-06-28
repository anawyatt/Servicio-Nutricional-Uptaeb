<?php

require_once '../../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__. '/../../../');
$dotenv->safeLoad();

use modelo\passwordRecoveryModelo as passwordRecovery;
use helpers\decryptionAsyncHelpers;

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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

    if (!isset($data['enviar']) || !isset($data['correo'])) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Enviar y Correo son requeridos']);
        exit;
    }

    $objecto = new passwordRecovery();
    $respuesta = $objecto->recuperContraseñas($data['correo']);
    echo json_encode($respuesta);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}
