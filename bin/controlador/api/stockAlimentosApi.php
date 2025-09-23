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
if (!$decodedToken) {
    http_response_code(401);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Token no válido o expirado']);
    exit;
}

header('Content-Type: application/json');

// Solo permitimos POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

/* En el archivo: bin/controlador/api/stockAlimentosApi.php */

// ... (código existente)

if (isset($_POST['datos'])) {
    try {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);
        
        if (!isset($data['alimento']) || !isset($data['page']) || !isset($data['limit'])) {
            http_response_code(400);
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes para la búsqueda.']);
            exit;
        }

        $limit = (int) $data['limit'];
        $offset = ((int) $data['page'] - 1) * $limit; 

        $resultado = $objeto->buscarAlimentoPaginado($data['alimento'], $limit, $offset);
        echo json_encode($resultado);
        exit;

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
        exit;
    }
}

if (isset($_POST['consultarStockTotal'])) {
    try {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['consultarStockTotal']);
        
        if (!isset($data['page']) || !isset($data['limit'])) {
            http_response_code(400);
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes para el reporte paginado']);
            exit;
        }

        $limit = (int) $data['limit'];
        $offset = ((int) $data['page'] - 1) * $limit; 
        
        $resultado = $objeto->alimentosPaginado($limit, $offset);
        $totalAlimentos = $objeto->contarAlimentosTotales(); 
        
        echo json_encode(['alimentos' => $resultado, 'total' => $totalAlimentos]);
        exit;

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
        exit;
    }
}

if (isset($_POST['exportarPdf'])) {
    try {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['exportarPdf']);
        
        if (!isset($data['pdfStockAlimentos'])) {
            http_response_code(400);
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes para el reporte pdf']);
            exit;
        }

        $tipoA= 'Seleccionar';
        $resultado = $objeto->mostrarAlimentos($tipoA);
        
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
