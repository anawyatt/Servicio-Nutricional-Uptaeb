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

$decodedToken = JwtMiddleware::verificarToken();

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

    // Aquí verifica los parámetros esperados para esta función
    if (!isset($data['mostrarAlimentos']) || !isset($data['alimento'])) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes']);
        exit;
    }

    $objeto = new stockAlimentos();
    $resultado = $objeto->buscarAlimento($data['alimento']);

    echo json_encode($resultado);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}
