<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;
use component\configuracion as configuracion;
use component\NotificacionesServer as NotificacionesServer;
use helpers\encryption as encryption;
use modelo\tipoSalidaModelo as tipoSalida;
use helpers\permisosHelper as permisosHelper;

$objeto = new tipoSalida;
$sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Tipos de Salidas', 'consultar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

$NotificacionesServer = new NotificacionesServer();

if (isset($_POST['notificaciones'])) {
  $valor = $NotificacionesServer->consultarNotificaciones();
}

if (isset($_POST['notificacionId'])) {
  $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
}

//registrar

if (isset($_POST['tipoS'])) {
  $validar = $objeto->verificarTipoSalida($_POST['tipoS']);
}

if (isset($_POST['registrar']) && isset($_POST['tipoS']) && $datosPermisos['permiso']['registrar']) {
  $registrar = $objeto->registrarTipoSalida($_POST['tipoS']);
}

// Consultar


if (isset($_POST['muestra'], $_POST['tabla'])) {
  $mostrar = $objeto->tabla();
}

if (isset($_POST['modificar']) && isset($_POST['id'])) {
  $verificarModificacion = $objeto->verificarModificacion($_POST['id']);
}


// Modificar

if (isset($_POST['mostrar']) && isset($_POST['id'])) {
  $mostrarInfo = $objeto->mostrarTipoS($_POST['id']);
}

//-------- MODIFICAR -----------------------------------------

if (isset($_POST['tipoS2']) && isset($_POST['id']) && $datosPermisos['permiso']['modificar']) {
  $verificarExistencia = $objeto->verificarExistencia($_POST['id']);
  $verificarTipoAlimento = $objeto->verificarTipoS2($_POST['tipoS2'], $_POST['id']);

  $modificar = $objeto->modificarTipoSalida($_POST['tipoS2'], $_POST['id']);
}

//-------- ANULAR -----------------------------------------
if (isset($_POST['id']) && isset($_POST['borrar'])  && $datosPermisos['permiso']['eliminar']) {
  $verificarExistencia = $objeto->verificarExistencia($_POST['id']);
  $anular = $objeto->anularTipoSalida($_POST['id']);
}


$components = new initComponents();
$navegador = new navegador($payload);
$sidebar = new sidebar($permisos);
$footer = new footer();
$configuracion = new configuracion($permisos);


if (file_exists("vista/tipoSalidaVista.php")) {
  require_once("vista/tipoSalidaVista.php");
} else {
  die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
