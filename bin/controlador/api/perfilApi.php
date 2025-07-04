<?php

require_once '../../../vendor/autoload.php';

use Dotenv\Dotenv;
use modelo\perfilModelo as perfil;
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

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

try {
    $decodedToken = JwtMiddleware::verificarToken();
    if (!$decodedToken) {
        http_response_code(401);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Token no válido o expirado']);
        exit;
    }

    $objet = new perfil();
    if (!$objet) {
        throw new Exception('Error al instanciar el modelo de perfil');
    }

    // Imagen (NO cifrada porque se usa multipart/form-data)
    if (isset($_POST['accion']) && $_POST['accion'] === 'imagenPerfil') {
        if (isset($_FILES['imagen']['tmp_name'])) {
            $respuesta = $objet->editarImagen($_FILES['imagen']['tmp_name']);
            echo json_encode($respuesta);
        } else {
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Imagen no recibida']);
        }
        exit;
    }

    // Leer y descifrar los datos cifrados
    if (!isset($_POST['datos'])) {
        http_response_code(400);
        echo json_encode(['resultado' => 'error', 'mensaje' => 'Faltan datos cifrados']);
        exit;
    }

    $data = decryptionAsyncHelpers::decryptPayload($_POST['datos']);

    if (isset($data['validarCorreo'], $data['correo']) && $data['validarCorreo'] === true) {
        $respuesta = $objet->validarCorreo($data['correo']);
        echo json_encode($respuesta);
        exit;
    }

    // Editar perfil
    if (isset($data['nombre'], $data['apellido'], $data['correo'])) {
        $respuesta = $objet->editarPerfil($data['nombre'], $data['apellido'], $data['correo']);
        echo json_encode($respuesta);
        exit;
    }

    // Borrar imagen
    if (isset($data['borrar'])) {
        $respuesta = $objet->eliminarImagen();
        echo json_encode($respuesta);
        exit;
    }

    // Acción no reconocida
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Acción no válida o datos incompletos']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => $e->getMessage()]);
}
