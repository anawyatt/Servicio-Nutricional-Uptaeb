<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;
use component\configuracion as configuracion;
use component\NotificacionesServer as NotificacionesServer;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;

use modelo\consultarAsistenciaModelo as consultarAsistencia;


$objeto = new consultarAsistencia;
$sistem = new encryption();
$NotificacionesServer = new NotificacionesServer();

if (isset($_POST['notificaciones'])) {
  $valor = $NotificacionesServer->consultarNotificaciones();
}

if (isset($_POST['notificacionId'])) {
  $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
}

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Asistencias', 'consultar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];



if (isset($_POST['select'])) {
  $mostrarFechas = $objeto->mostrarFechas();
  echo json_encode($mostrarFechas);
  die();
}

if (isset($_POST['select2']) && isset($_POST['fecha'])) {
  $mostrarFechas = $objeto->mostrarHorarios($_POST['fecha']);
  echo json_encode($mostrarFechas);
  die();
}


if (isset($_POST['mostrar']) && isset($_POST['fecha']) && isset($_POST['horarioComida'])) {
  $MostrarAsistencia = $objeto->mostrarAsistencia($_POST['fecha'], $_POST['horarioComida']);
  echo json_encode($MostrarAsistencia);
  die();
}

if (isset($_POST['mostrarUltimaVez']) && isset($permiso['consultar'])) {
  $MostrarPorFiltro = $objeto->mostrarUltimaVez();
  echo json_encode($MostrarPorFiltro);
  die();
}

// ------------ PDF

if (isset($_POST['reporte']) &&  isset($_POST['fecha']) && isset($_POST['horario'])) {
  $pdf = $objeto->fpdf($_POST['fecha'], $_POST['horario']);
}

if (isset($_POST['reporte2'])) {
  $pdf2 = $objeto->fpdf2();
}


$components = new initComponents();
$navegador = new navegador($payload);
$configuracion = new configuracion($permisos);
$sidebar = new sidebar($permisos);
$footer = new footer();


if (file_exists("vista/consultarAsistenciaVista.php")) {
  require_once("vista/consultarAsistenciaVista.php");
} else {
  die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
