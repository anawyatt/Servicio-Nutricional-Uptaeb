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

use modelo\consultarEventosModelo as consultarEventos;
use middleware\JwtMiddleware;
use helpers\decryptionAsyncHelpers;


$decodedToken = JwtMiddleware::verificarToken();
$consultarEventosModelo = new consultarEventos();


header('Content-Type: application/json');

try {
    if (isset($_POST['datos'])) {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

        if (isset($data['accion']) && $data['accion'] === 'buscarEvento') {
            $fechaInicio = $data['fechaInicio'] ?? '';
            $fechaFin = $data['fechaFin'] ?? '';
            $horarioComida = $data['horarioComida'] ?? null;

            if ($horarioComida) {
                $consultarEventosModelo->payload = (object)['horario_comida' => $horarioComida]; // 👈 importante, que coincida con el modelo
            }

            $eventos = $consultarEventosModelo->mostrarE($fechaInicio, $fechaFin);

            if (is_array($eventos) && isset($eventos[0]) && is_string($eventos[0])) {
                http_response_code(400);
                echo json_encode(['resultado' => 'error', 'mensaje' => $eventos[0]]);
                exit;
            }

            echo json_encode(['resultado' => 'success', 'eventos' => $eventos]);
            exit;
        } else {
            throw new Exception('Acción no reconocida');
        }
    }

    if (isset($_POST['infoEventoModal'])) {
        $data = decryptionAsyncHelpers::decryptPayload($_POST['infoEventoModal']);

        if (!isset($data['mostrarEvento']) || !isset($data['idEvento'])) {
            throw new Exception('Parámetros requeridos faltantes para mostrar eventos');
        }

        $info = $consultarEventosModelo->infoAppEvento($data['idEvento']);
        echo json_encode($info);
        exit;
    }

    throw new Exception('Faltan datos cifrados');
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
    exit;
}