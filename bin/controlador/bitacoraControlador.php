<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;

set_time_limit(3600);

use component\configuracion as configuracion;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;
use modelo\bitacoraModelo as bitacora;

$objeto = new bitacora;
$sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Bitacora', 'consultar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

 if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }


// Controlador modificado para manejar server-side processing
if (isset($_POST['tabla']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
    
    // Obtener parámetros de DataTables para server-side processing
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    
    // Información de ordenamiento
    $orderColumn = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 3; // Por defecto fecha
    $orderDir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';
    
    // Mapeo de columnas para ordenamiento
    $columns = ['imagen', 'modulo', 'acciones', 'fecha', 'hora'];
    $orderBy = isset($columns[$orderColumn]) ? $columns[$orderColumn] : 'fecha';
    
    // Llamar al método del modelo con los parámetros de paginación
    $resultado = $objeto->mostrarBitacora(
        $_POST['fechaInicio'], 
        $_POST['fechaFin'],
        $start,
        $length,
        $searchValue,
        $orderBy,
        $orderDir
    );
    
    // Estructurar respuesta para DataTables
    $response = [
        "draw" => $draw,
        "recordsTotal" => $resultado['recordsTotal'],
        "recordsFiltered" => $resultado['recordsFiltered'],
        "data" => $resultado['data']
    ];
    
    echo json_encode($response);
    die();
}


if (isset($_POST['verBitacora'])) {
  $Info = $objeto->verAccionesDeBitacora($_POST['id'], $_POST['idBitacora']);
  echo json_encode($Info);
  die();
}



$components = new initComponents();
$navegador = new navegador($payload);
$footer = new footer();
$sidebar = new sidebar($permisos);
$configuracion = new configuracion($permisos);


if (file_exists("vista/bitacoraVista.php")) {
  require_once("vista/bitacoraVista.php");
} else {
  die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
