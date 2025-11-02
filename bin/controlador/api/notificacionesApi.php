<?php
// notificacionesApi.php

require_once '../../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__. '/../../../');
$dotenv->safeLoad();

use modelo\notificacionesModelo as notificaciones;
use middleware\JwtMiddleware;

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true'); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $decodedToken = JwtMiddleware::verificarToken();
    if (!$decodedToken) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token no válido o expirado']);
        exit;
    }
    
    $cedulaUsuario = $decodedToken->cedula ?? null;
    if (!$cedulaUsuario) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token inválido: Falta la cédula.']);
        exit;
    }

} catch (\Exception $e) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Acceso denegado: Sesión inválida.']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$action = $data['action'] ?? '';
$response = ['success' => false];

$notifManager = new notificaciones(); 

switch ($action) {
    
    case 'obtener':
        $notifications = $notifManager->obtenerNotificacionesCompletas($cedulaUsuario);
        $response = [
            'success' => true,
            'data' => $notifications, 
            'count' => count($notifications)
        ];
        break;
        
    case 'marcarLeida':
        $idNotificacion = $data['idNotificacion'] ?? null;
        if ($idNotificacion) {
            $result = $notifManager->marcarNotificacionLeida($idNotificacion, $cedulaUsuario);
            $response = ['success' => true, 'message' => 'Marcada como leída.'];
        } else {
            http_response_code(400);
            $response = ['success' => false, 'message' => 'Falta idNotificacion.'];
        }
        break;
        
    case 'marcarTodas':
        $notifManager->marcarTodasLeidas($cedulaUsuario);
        $response = ['success' => true, 'message' => 'Todas marcadas como leídas.'];
        break;

   case 'eliminar':
    $idNotificacion = $data['idNotificacion'] ?? null;
    if ($idNotificacion) {
        $result = $notifManager->eliminarNotificacion($idNotificacion, $cedulaUsuario); 
        $response = ['success' => true, 'message' => 'Notificación eliminada.']; 
    }else {
            http_response_code(400);
            $response = ['success' => false, 'message' => 'Falta idNotificacion.'];
        }
        break;
        
    default:
        http_response_code(404);
        $response = ['success' => false, 'message' => 'Acción no reconocida.'];
        break;
}

echo json_encode($response);
exit;