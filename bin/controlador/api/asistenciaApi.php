<?php

require_once '../../../vendor/autoload.php';

use Dotenv\Dotenv;
use modelo\asistenciaModelo as asistencia;
use middleware\JwtMiddleware;
use helpers\decryptionAsyncHelpers;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->safeLoad();

// Configuración de CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// Preflight para peticiones OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');

// Solo se permite método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

// Validar existencia del parámetro 'datos'
if (!isset($_POST['datos'])) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Faltan datos cifrados']);
    exit;
}

try {
    // Verificar token
    $decodedToken = JwtMiddleware::verificarToken();
    if (!$decodedToken) {
    http_response_code(401);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Token no válido o expirado']);
    exit;
   }

    // Desencriptar datos
    $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

    // Validar que los datos sean un array
    if (!is_array($data)) {
        throw new Exception("Error al descifrar los datos.");
    }

    // Instanciar modelo
    $objeto = new asistencia();

    // Ver estudiantes
    if (isset($data['verEstudiantes'])) {
        if (!isset($data['id'])) {
            throw new Exception("Falta el ID del estudiante.");
        }

        $id = $data['id'];
        $InfoEstudiantes = $objeto->infoStudy($id);
        echo json_encode($InfoEstudiantes);
        return;
    }

    // Ver menú
    if (isset($data['vermenu'])) {
        if (!isset($data['horario'])) {
            throw new Exception("Falta el horario.");
        }

        try {
            $VerMenu = $objeto->obtenerIdMenu($data['horario']);
            echo json_encode($VerMenu);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ocurrió un error al obtener el menú.',
                'error' => $e->getMessage()
            ]);
        }
        return;
    }

    // Ver platos disponibles
    if (isset($data['verPlatosDisponibles']) && isset($data['horarioComida'])) {
        $Verplato = $objeto->platosDisponibles($data['horarioComida']);
        echo json_encode($Verplato);
        return;
    }

    // Verificar asistencia
    if (isset($data['verificar']) && isset($data['horarioComida']) && isset($data['id'])) {
        $Validar = $objeto->verificarAsistenciaEstudiante($data['horarioComida'], $data['id']);
        echo json_encode($Validar);
        return;
    }

    // Registrar asistencia
    if (isset($data['registrar']) && isset($data['id']) && isset($data['idmenu'])) {
        $registrar = $objeto->registrarAsistencia($data['id'], $data['idmenu']);
        echo json_encode($registrar);
        return;
    }

    // Si no coincide ninguna acción
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Acción no válida.']);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}
