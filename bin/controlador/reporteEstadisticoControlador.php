<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;
use component\configuracion as configuracion;
use component\cardysReporte as cardysReporte;
use modelo\reporteEstadisticoModelo as reporteEstadistico;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;

$objeto = new reporteEstadistico;
$sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Alimentos', 'registrar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }


// ------------------------------ VERIFICAR CARDS DE LOS REPORTES -----------------

if (isset($_POST['verificarEA'])) {
  $respuesta = $objeto->verificarAsistenciasEstudiantes();
  echo json_encode($respuesta);
  die();
}

if (isset($_POST['verificarME'])) {
  $respuesta =  $objeto->verificarMenus();
  $respuesta2 = $objeto->verificarEventos();
  echo json_encode([
    'respuesta' => $respuesta,
    'respuesta2' => $respuesta2
   ]);
   die();
}
if (isset($_POST['verificarIA'])) {
  $respuesta = $objeto->verificarEntradaAlimentos();
  $respuesta2 = $objeto->verificarSalidaAlimentos();
  echo json_encode([
    'respuesta' => $respuesta,
    'respuesta2' => $respuesta2
   ]);
   die();
}
if (isset($_POST['verificarIU'])) {
 $respuesta =  $objeto->verificarEntradaUtensilios();
  $respuesta2 = $objeto->verificarSalidaUtensilios();
  echo json_encode([
    'respuesta' => $respuesta,
    'respuesta2' => $respuesta2
   ]);
   die();
}



//------------ SELECTS ----------------------------

if (isset($_POST['select1A'])) {
 $respuesta =  $objeto->mostrarFechasAsistencia();
 echo json_encode($respuesta);
 die();
}

if (isset($_POST['select1AJ'])) {
  $respuesta = $objeto->mostrarFechasAsistenciaJustificativo();
  echo json_encode($respuesta);
  die();
}

if (isset($_POST['select2M'])) {
 $respuesta = $objeto->mostrarFechasMenus();
 echo json_encode($respuesta);
  die();
}

if (isset($_POST['select2E'])) {
  $respuesta = $objeto->mostrarFechasEventos();
  echo json_encode($respuesta);
  die();
}

if (isset($_POST['select3EA'])) {
  $respuesta = $objeto->mostrarFechasEntradaAlimentos();
  echo json_encode($respuesta);
  die();
}

if (isset($_POST['select3SA'])) {
  $respuesta = $objeto->mostrarFechasSalidaAlimentos();
  echo json_encode($respuesta);
  die();
}

if (isset($_POST['select4EU'])) {
 $respuesta =  $objeto->mostrarFechasEntradaUtensilios();
 echo json_encode($respuesta);
    die();
}

if (isset($_POST['select4SU'])) {
 $respuesta =  $objeto->mostrarFechasSalidaUtensilios();
 echo json_encode($respuesta);
    die();
}

// -------------- ASISTENCIAS --------------------


if (isset($_POST['reporteAsistenciasEstudiantes']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasEstudiantes($_POST['fecha']);
  echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteAsistenciasPorSexo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorSexo($_POST['fecha']);
  echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteAsistenciasPorNucleo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorNucleo($_POST['fecha']);
  echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteAsistenciasPorPNF']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorPNF($_POST['fecha']);
  echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteAsistenciasPorJustificativo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorJustificativo($_POST['fecha']);
 echo json_encode($reporte);
  die();
}



// ---------------- MENU Y EVENTOS --------------------

if (isset($_POST['reporteMenus']) && isset($_POST['fecha'])) {
  $reporte = $objeto->menus($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteEventos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->eventos($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteCantidadMenuActivos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->cantidadMenuActivos($_POST['fecha']);
  echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteAlimentosMasUtilizados']) && isset($_POST['fecha'])) {
  $reporte = $objeto->alimentosMasUtilizados($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteEventosConMayorAlimentos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->eventosConMayorAlimentos($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

// ----------------- ALIMENTOS ------------------

if (isset($_POST['reporteEntradaAlimentos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->entradaAlimentos($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteAlimentosMasIngresados']) && isset($_POST['fecha'])) {
  $reporte = $objeto->alimentosMasIngresados($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteSalidaAlimentosMenu']) && isset($_POST['fecha'])) {
  $reporte = $objeto->salidaAlimentosMenu($_POST['fecha']);
 echo json_encode($reporte);
  die();
}


if (isset($_POST['reporteSalidaAlimentosMerma']) && isset($_POST['fecha'])) {
  $reporte = $objeto->salidaAlimentosMerma($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

//-------------- UTENSILIOS ----------------------

if (isset($_POST['reporteEntradaUtensilios']) && isset($_POST['fecha'])) {
  $reporte = $objeto->entradaUtensilios($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteUtensiliosMasIngresados']) && isset($_POST['fecha'])) {
  $reporte = $objeto->utensiliosMasIngresados($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

if (isset($_POST['reporteSalidaUtensilios']) && isset($_POST['fecha'])) {
  $reporte = $objeto->salidaUtensilios($_POST['fecha']);
 echo json_encode($reporte);
  die();
}

// ----------------- PDF ---------------------


if (isset($_POST['reporte']) && isset($_POST['grafica']) && isset($_POST['tipo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->fpdf($_POST['grafica'], $_POST['tipo'], $_POST['fecha']);
echo  json_encode($reporte);
  die();
}



$components = new initComponents();
$navegador = new navegador($payload);
$sidebar = new sidebar($permisos);
$configuracion = new configuracion($permisos);
$cardy = new cardysReporte($permisos);
$footer = new footer();


if (file_exists("vista/reporteVista.php")) {
  require_once("vista/reporteVista.php");
} else {
  die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}

?>