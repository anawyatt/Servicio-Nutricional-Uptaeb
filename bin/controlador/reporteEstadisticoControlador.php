<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;
use component\configuracion as configuracion;
use component\cardysReporte as cardysReporte;
use component\NotificacionesServer as NotificacionesServer;
use modelo\reporteEstadisticoModelo as reporteEstadistico;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;

$objeto = new reporteEstadistico;
$sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Alimentos', 'registrar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

$NotificacionesServer = new NotificacionesServer();

if (isset($_POST['notificaciones'])) {
  $valor = $NotificacionesServer->consultarNotificaciones();
}

if (isset($_POST['notificacionId'])) {
  $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
}


// ------------------------------ VERIFICAR CARDS DE LOS REPORTES -----------------

if (isset($_POST['verificarEA'])) {
  $objeto->verificarAsistenciasEstudiantes();
}

if (isset($_POST['verificarME'])) {
  $objeto->verificarMenus();
  $objeto->verificarEventos();
}
if (isset($_POST['verificarIA'])) {
  $objeto->verificarEntradaAlimentos();
  $objeto->verificarSalidaAlimentos();
}
if (isset($_POST['verificarIU'])) {
  $objeto->verificarEntradaUtensilios();
  $objeto->verificarSalidaUtensilios();
}



//------------ SELECTS ----------------------------

if (isset($_POST['select1A'])) {
  $objeto->mostrarFechasAsistencia();
}

if (isset($_POST['select1AJ'])) {
  $objeto->mostrarFechasAsistenciaJustificativo();
}

if (isset($_POST['select2M'])) {
  $objeto->mostrarFechasMenus();
}

if (isset($_POST['select2E'])) {
  $objeto->mostrarFechasEventos();
}

if (isset($_POST['select3EA'])) {
  $objeto->mostrarFechasEntradaAlimentos();
}

if (isset($_POST['select3SA'])) {
  $objeto->mostrarFechasSalidaAlimentos();
}

if (isset($_POST['select4EU'])) {
  $objeto->mostrarFechasEntradaUtensilios();
}

if (isset($_POST['select4SU'])) {
  $objeto->mostrarFechasSalidaUtensilios();
}

// -------------- ASISTENCIAS --------------------


if (isset($_POST['reporteAsistenciasEstudiantes']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasEstudiantes($_POST['fecha']);
}

if (isset($_POST['reporteAsistenciasPorSexo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorSexo($_POST['fecha']);
}

if (isset($_POST['reporteAsistenciasPorNucleo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorNucleo($_POST['fecha']);
}

if (isset($_POST['reporteAsistenciasPorPNF']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorPNF($_POST['fecha']);
}

if (isset($_POST['reporteAsistenciasPorJustificativo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->asistenciasPorJustificativo($_POST['fecha']);
}



// ---------------- MENU Y EVENTOS --------------------

if (isset($_POST['reporteMenus']) && isset($_POST['fecha'])) {
  $reporte = $objeto->menus($_POST['fecha']);
}

if (isset($_POST['reporteEventos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->eventos($_POST['fecha']);
}

if (isset($_POST['reporteCantidadMenuActivos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->cantidadMenuActivos($_POST['fecha']);
}

if (isset($_POST['reporteAlimentosMasUtilizados']) && isset($_POST['fecha'])) {
  $reporte = $objeto->alimentosMasUtilizados($_POST['fecha']);
}

if (isset($_POST['reporteEventosConMayorAlimentos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->eventosConMayorAlimentos($_POST['fecha']);
}

// ----------------- ALIMENTOS ------------------

if (isset($_POST['reporteEntradaAlimentos']) && isset($_POST['fecha'])) {
  $reporte = $objeto->entradaAlimentos($_POST['fecha']);
}

if (isset($_POST['reporteAlimentosMasIngresados']) && isset($_POST['fecha'])) {
  $reporte = $objeto->alimentosMasIngresados($_POST['fecha']);
}

if (isset($_POST['reporteSalidaAlimentosMenu']) && isset($_POST['fecha'])) {
  $reporte = $objeto->salidaAlimentosMenu($_POST['fecha']);
}


if (isset($_POST['reporteSalidaAlimentosMerma']) && isset($_POST['fecha'])) {
  $reporte = $objeto->salidaAlimentosMerma($_POST['fecha']);
}

//-------------- UTENSILIOS ----------------------

if (isset($_POST['reporteEntradaUtensilios']) && isset($_POST['fecha'])) {
  $reporte = $objeto->entradaUtensilios($_POST['fecha']);
}

if (isset($_POST['reporteUtensiliosMasIngresados']) && isset($_POST['fecha'])) {
  $reporte = $objeto->utensiliosMasIngresados($_POST['fecha']);
}

if (isset($_POST['reporteSalidaUtensilios']) && isset($_POST['fecha'])) {
  $reporte = $objeto->salidaUtensilios($_POST['fecha']);
}

// ----------------- PDF ---------------------


if (isset($_POST['reporte']) && isset($_POST['grafica']) && isset($_POST['tipo']) && isset($_POST['fecha'])) {
  $reporte = $objeto->fpdf($_POST['grafica'], $_POST['tipo'], $_POST['fecha']);
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