<?php

namespace Bin\Controlador;
use modelo\notificacionesModelo as notificacionesModelo;

$objetoNoti = new notificacionesModelo();

if (isset($_POST['obtenerNotificaciones'])) {
  $notificaciones = $objetoNoti->obtenerNotificaciones();
  echo json_encode($notificaciones);
  exit;
}

if (isset($_POST['marcarLeida']) && isset($_POST['notificacionId'])) {
  $notificacionId = $_POST['notificacionId'];
  $resultado = $objetoNoti->marcarNotificacionLeida($notificacionId);
  echo json_encode($resultado);
  exit;
}

if (isset($_POST['marcarTodasLeidas'])) {
  $objetoNoti->marcarTodasLeidas();
  echo json_encode(['success' => 'Todas las notificaciones marcadas como leídas.']);
  exit;
}

if (isset($_POST['eliminarNotificacion']) && isset($_POST['notificacionId'])) {
  $notificacionId = $_POST['notificacionId'];
  $resultado = $objetoNoti->eliminarNotificacion($notificacionId);
  echo json_encode($resultado);
  exit;
}

?>