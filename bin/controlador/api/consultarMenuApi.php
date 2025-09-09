<?php

require_once '../../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__. '/../../../');
$dotenv->safeLoad();

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true'); 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

use modelo\consultarMenuModelo as consultarMenu;
use middleware\JwtMiddleware;
use helpers\decryptionAsyncHelpers;


$decodedToken = JwtMiddleware::verificarToken();
if (!$decodedToken) {
    http_response_code(401);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Token no válido o expirado']);
    exit;
}
$consultarMenuModelo = new consultarMenu();


header('Content-Type: application/json');

try {
    if (isset($_POST['datos'])) {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

        if (isset($data['accion']) && $data['accion'] === 'buscarMenu') {
            $fechaInicio = $data['fechaInicio'] ?? '';
            $fechaFin = $data['fechaFin'] ?? '';
            $horarioComida = $data['horarioComida'] ?? null;

            if ($horarioComida) {
                $consultarMenuModelo->payload = (object)['horario_comida' => $horarioComida]; // 👈 
            }

            $menus = $consultarMenuModelo->mostrarM($fechaInicio, $fechaFin);

            if (is_array($menus) && isset($menus[0]) && is_string($menus[0])) {
                http_response_code(400);
                echo json_encode(['resultado' => 'error', 'mensaje' => $menus[0]]);
                exit;
            }

            echo json_encode(['resultado' => 'success', 'menus' => $menus]);
            exit;
        } else {
            throw new Exception('Acción no reconocida');
        }
    }

    if (isset($_POST['infoMenuModal'])) {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['infoMenuModal']);

        if (!isset($data['mostrarMenu']) || !isset($data['idMenu'])) {
            throw new Exception('Parámetros requeridos faltantes para mostrar menú');
        }

        $info = $consultarMenuModelo->infoApp($data['idMenu']);
        echo json_encode($info);
        exit;
    }

    throw new Exception('Faltan datos cifrados');
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
    exit;
}