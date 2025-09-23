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

use modelo\homeModelo as home;
use middleware\JwtMiddleware;
use helpers\decryptionAsyncHelpers;

 $objeto = new home();

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

$data = null;

if (isset($_POST['datos'])) {

    $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

    if (isset($data['mostrarInfo'])) {
        $resultado = $objeto->cantTodos();
        echo json_encode($resultado);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes mostrarInfo']);
        exit;
    }
}

if (isset($_POST['dataGraficoA'])) {
    $data = decryptionAsyncHelpers::decryptPayload($_POST['dataGraficoA']);

    if (isset($data['graficoAsistencias'])) {
        $resultado = $objeto->asistenciasPorPNF();
        echo json_encode($resultado);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes grafico']);
        exit;
    }
}

if (isset($_POST['dataGraficoM'])) {
    $data = decryptionAsyncHelpers::decryptPayload($_POST['dataGraficoM']);

    if (isset($data['graficoMenus'])) {
        $resultado = $objeto->menusH();
        echo json_encode($resultado);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros requeridos faltantes grafico']);
        exit;
    }
}

// Si no viene ninguno
http_response_code(400);
echo json_encode(['resultado' => 'error', 'mensaje' => 'No se recibió ningún parámetro reconocido']);
exit;


