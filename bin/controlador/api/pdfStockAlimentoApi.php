<?php

require_once '../../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__. '/../../../');
$dotenv->safeLoad();

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true'); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

use modelo\stockAlimentosModelo as stockAlimentos;
use middleware\JwtMiddleware;
use helpers\decryptionAsyncHelpers;
 $objeto = new stockAlimentos();

$decodedToken = JwtMiddleware::verificarToken();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['consultarStockTotal'])) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Faltan datos cifrados']);
    exit;
}
else{
    try{

    $data = decryptionAsyncHelpers::decryptPayload($_POST['consultarStockTotal']);

    if (!isset($data['mostrarAlimentosTotal']) ) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes para el reporte']);
        exit;
    }
    $tipoA='Seleccionar';
    $resultado = $objeto->mostrarAlimentos($tipoA);
    echo json_encode($resultado);


    }catch(Exception $e) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
    }
}



