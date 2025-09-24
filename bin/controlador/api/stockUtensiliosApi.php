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

if (isset($_POST['datos'])) {
  try {
    $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

    if (!isset($data['mostrarUtensilios']) || !isset($data['utensilio']) || !isset($data['offset'])) {
      http_response_code(400);
      echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes']);
      exit;
    }
    
    $limit = 10; 
    $offset = (int) $data['offset'];
    
    if (empty($data['utensilio'])) {
      $resultado = $objeto->mostrarUtensiliosPaginado($limit, $offset);
    } else {
      $resultado = $objeto->buscarUtensilioPaginado($data['utensilio'], $limit, $offset);
    }
    
    echo json_encode($resultado);
  } catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
  }
  exit;
}

if (isset($_POST['consultarStockTotal'])) {
    try {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['consultarStockTotal']);
        
        if (!isset($data['mostrarUtensiliosTotal'])) {
            http_response_code(400);
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes para el reporte pdf']);
            exit;
        }
        $resultado = $objeto->mostrarUtensilios();
        
        echo json_encode($resultado);
        exit;

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
        exit;
    }
}
http_response_code(400);
echo json_encode(['resultado' => 'error', 'mensaje' => 'Solicitud inválida']);

