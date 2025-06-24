<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\configuracion as configuracion;
use component\footer as footer;
use component\NotificacionesServer as NotificacionesServer;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;
use modelo\EstudianteNormalizer as EstudianteNormalizer;
use helpers\csrfTokenHelper;
use middleware\csrfMiddleware;

set_time_limit(3600);

use modelo\estudiantesModelo as estudiantes;
use modelo\bitacoraModelo as bitacora;



$objeto = new estudiantes;

$sistem = new encryption();

$normalizer = new EstudianteNormalizer();
$NotificacionesServer = new NotificacionesServer();


if (isset($_POST['notificaciones'])) {
  $valor = $NotificacionesServer->consultarNotificaciones();
}

if (isset($_POST['notificacionId'])) {
  $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
}

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Estudiantes', 'consultar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

$tokenCsrf = csrfTokenHelper::generateCsrfToken($payload->cedula);

if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
  $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
  echo json_encode(['message' => 'Token renovado', 'newCsrfToken' => $resultadoToken['newToken']]);
  die();
}


if (isset($_POST['verEstudiantes']) && isset($datosPermisos['permiso']['consultar'])) {

    // Parámetros de DataTables
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

    // Parámetros de ordenamiento
    $orderColumn = 0;
    $orderDirection = 'ASC';

    if (isset($_POST['order']) && count($_POST['order']) > 0) {
        $orderColumn = intval($_POST['order'][0]['column']);
        $orderDirection = $_POST['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';
    }

    // Mapear columnas para el ordenamiento
    $columns = ['cedEstudiante', 'nombre', 'carrera', 'seccion'];
    $orderBy = isset($columns[$orderColumn]) ? $columns[$orderColumn] : 'cedEstudiante';

    try {
        // Obtener datos paginados
        $result = $objeto->mostrarEstudiantes($start, $length, $searchValue, $orderBy, $orderDirection);

        // Respuesta para DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $result['total'],
            "recordsFiltered" => $result['filtered'],
            "data" => $result['data']
        ];

        echo json_encode($response);
    } catch (Exception $e) {
        // Error response
        $response = [
            "draw" => $draw,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => [],
            "error" => "Error interno del servidor"
        ];

        echo json_encode($response);
    }

    die();
}
if (isset($_POST['verEstudiantes_informacion']) && isset($datosPermisos['permiso']['consultar'])) {
    $Info = $objeto->infoStudy($_POST['id']);
    echo json_encode($Info);
    die();
}



if (isset($_POST['verificarcodigo'])) {
    $codigoIngresado = $_POST['codigoIngresado'];
    $codigo = $payload->cedula;
    $correcto = $objeto->verificarCodigo($codigoIngresado, $codigo);
    echo json_encode(['correcto' => $correcto]);
    die();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'validar_archivo') {

    if (!isset($_FILES['file']) || empty($_FILES['file']['name'])) {
        echo json_encode([
            'valido' => false,
            'mensaje' => 'No se ha seleccionado ningún archivo.'
        ]);
        exit;
    }

    $validacion = $objeto->validarExcel($_FILES['file']);

    // Si la validación es exitosa, también procesar el archivo y devolver los datos
    if ($validacion['valido']) {
        try {
            // Leer y procesar el archivo Excel
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($_FILES['file']['tmp_name']);
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $excelData = $worksheet->toArray();

            // Convertir a formato JSON como lo hace el JavaScript
            $headers = $excelData[0];
            $jsonData = [];

            for ($i = 1; $i < count($excelData); $i++) {
                $row = $excelData[$i];
                $obj = [];
                foreach ($headers as $index => $header) {
                    $obj[trim($header)] = $row[$index] ?? null;
                }
                $jsonData[] = $obj;
            }

            // Limpiar memoria
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

            // Retornar validación exitosa con los datos
            echo json_encode([
                'valido' => true,
                'mensaje' => 'Archivo válido y procesado correctamente.',
                'datos' => $jsonData
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'valido' => false,
                'mensaje' => 'Error al procesar el archivo: ' . $e->getMessage()
            ]);
        }
    } else {
        // Retornar error de validación
        echo json_encode($validacion);
    }

    exit;
}

// Tu código original de procesamiento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    if (isset($_POST['data'])) {

        $data = json_decode($_POST['data'], true);
        $totalRecords = count($data);
        $totalProcessed = 0;
        $alreadyRegistered = [];
        $incompleteData = [];
         $errors = [];

       

        foreach ($data as $index => $row) {
            try {
                // Normalizar datos antes de validar
                $datosNormalizados = $normalizer->normalizarDatosEstudiante($row);

                // Validación de campos obligatorios con datos normalizados
                if (!empty($datosNormalizados['cedula']) && 
                    !empty($datosNormalizados['nombre']) && 
                    !empty($datosNormalizados['apellido']) && 
                    !empty($datosNormalizados['sexo']) && 
                    !empty($datosNormalizados['nucleo']) && 
                    !empty($datosNormalizados['carrera']) && 
                    !empty($datosNormalizados['secciones']) && 
                    !empty($datosNormalizados['horarios'])) {

                    $registrar = $objeto->registrarEstudiante(
                        $datosNormalizados['cedula'],
                        $datosNormalizados['nombre'],
                        $datosNormalizados['segNombre'],
                        $datosNormalizados['apellido'],
                        $datosNormalizados['segApellido'],
                        $datosNormalizados['sexo'],
                        $datosNormalizados['telefono'],
                        $datosNormalizados['nucleo'],
                        $datosNormalizados['carrera'],
                        $datosNormalizados['secciones'],
                        $datosNormalizados['horarios']
                    );

                    if (strpos($registrar, 'ya está actualizada') !== false) {
                        $alreadyRegistered[] = $datosNormalizados['cedula'];
                    } else {
                        $totalProcessed++;
                    }
                } else {
                    $incompleteData[] = $datosNormalizados['cedula'] ?: 'Sin cédula';
                    error_log("Datos incompletos para la fila: " . ($index + 1));
                }

            } catch (Exception $e) {
                $errors[] = "Error en fila " . ($index + 1) . ": " . $e->getMessage();
                error_log("Error procesando fila " . ($index + 1) . ": " . $e->getMessage());
            }

            // Calcular el progreso
            $progress = round((($index + 1) / $totalRecords) * 100);
            $upload_progress = $progress;

            // Enviar progreso al cliente
            echo json_encode(['progress' => $progress]);
            echo PHP_EOL;
            ob_flush();
            flush();
        }

        $bitacora = new bitacora();
        $bitacora->registrarBitacora(
            'Estudiantes',
            'Se han registrado un total de ' . $totalProcessed . ' estudiantes.',
            $payload->cedula
        );

        echo json_encode([
            'status' => 'success',
            'totalProcessed' => $totalProcessed,
            'alreadyRegistered' => $alreadyRegistered,
            'incompleteData' => $incompleteData
        ]);
        die();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data received']);
        die();
    }
}





$components = new initComponents();
$navegador = new navegador($payload);
$sidebar = new sidebar($permisos);
$footer = new footer();
$configuracion = new configuracion($permisos);


if (file_exists("vista/estudiantesVista.php")) {
    require_once("vista/estudiantesVista.php");
} else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
