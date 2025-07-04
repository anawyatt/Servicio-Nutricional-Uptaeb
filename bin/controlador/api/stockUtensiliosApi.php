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

use modelo\stockUtensiliosModelo as stockUtensilios;
use middleware\JwtMiddleware;
use helpers\decryptionAsyncHelpers;
 $objeto = new stockUtensilios();

$decodedToken = JwtMiddleware::verificarToken();
if (!$decodedToken) {
    http_response_code(401);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Token no válido o expirado']);
    exit;
}

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
else{
try {
    $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

    if (!isset($data['mostrarUtensilios']) || !isset($data['utensilio'])) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes']);
        exit;
    }
    $resultado = $objeto->buscarUtensilio($data['utensilio']);

    echo json_encode($resultado);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}
}
