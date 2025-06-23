
<?php

require_once '../../../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__. '/../../../');
$dotenv->safeLoad();

use modelo\loginModelo;

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['cedula']) || !isset($_POST['clave'])) {
    http_response_code(400);
    echo json_encode(['resultado' => 'error', 'mensaje' => 'Cédula y clave son requeridos']);
    exit;
}

$cedula = $_POST['cedula'];
$clave = $_POST['clave'];

$login = new loginModelo();
$respuesta = $login->loginSistema($cedula, $clave);

if ($respuesta['resultado'] === 'success') {
    http_response_code(200);
    echo json_encode($respuesta);
} else {
    http_response_code(401);
    echo json_encode($respuesta);
}




/*

require_once '../../../vendor/autoload.php';

header('Content-Type: application/json');

use modelo\loginModelo;



$object = new loginModelo();


if(isset($_POST['cedula'])){
    $respuesta = $object->loginSistema($_POST['cedula'], $_POST['clave']);
    echo json_encode($respuesta);
    die();  
   }

*/
?>
