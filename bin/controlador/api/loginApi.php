<?php

require_once '../../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__. '/../../../');
$dotenv->safeLoad();

use modelo\loginModelo;
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

if (!isset($_POST['payload'])) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Faltan datos cifrados']);
    exit;
}
else{

    
try {

    $data = decryptionAsyncHelpers::decryptPayload($_POST['payload']);

    if (!isset($data['cedula']) || !isset($data['clave'])) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Cédula y clave requeridos']);
        exit;
    }

    $cedula = $data['cedula'];
    $clave = $data['clave'];

    $login = new loginModelo();
    $respuesta = $login->loginSistema($cedula, $clave);
    echo json_encode($respuesta);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}


}


