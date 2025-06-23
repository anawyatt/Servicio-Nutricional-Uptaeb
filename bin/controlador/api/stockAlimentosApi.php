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
    // Respuesta para preflight
    http_response_code(200);
    exit();
}
use modelo\stockAlimentosModelo as stockAlimentos;
use middleware\JwtMiddleware;
$decodedToken = JwtMiddleware::verificarToken();

$objeto = new stockAlimentos();

if (isset($_POST['mostrarAlimentos']) && isset($_POST['alimento'])) {
    try {
        $mostrarTabla = $objeto->buscarAlimento($_POST['alimento']);
        echo json_encode($mostrarTabla);
        die();
    } catch (\RuntimeException $e) {
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}

?>
