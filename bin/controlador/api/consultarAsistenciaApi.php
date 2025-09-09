<?php

require_once '../../../vendor/autoload.php';

use Dotenv\Dotenv;
use modelo\consultarAsistenciaModelo as consultarAsistencia;
use middleware\JwtMiddleware;
use helpers\decryptionAsyncHelpers;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->safeLoad();

// Configuración CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

// Validar datos cifrados
if (!isset($_POST['datos'])) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Faltan datos cifrados']);
    exit;
}

try {
    // Verificar el token JWT
    $decodedToken = JwtMiddleware::verificarToken();
    if (!$decodedToken) {
    http_response_code(401);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Token no válido o expirado']);
    exit;
}

    // Descifrar los datos enviados
    $data = decryptionAsyncHelpers::decryptPayload(base64Payload: $_POST['datos']);

    $objeto = new consultarAsistencia();

    if (isset($data['mostrar'])) {
        $fecha = $data['fecha'] ?? 'Seleccionar';
        $horario = $data['horarioComida'] ?? 'Seleccionar';
        $resultado = $objeto->mostrarAsistencia($fecha, $horario);
        echo json_encode($resultado);
        exit;
    }
    
    // Si no coincide con ninguna acción conocida
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Parámetros inválidos o incompletos']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}
