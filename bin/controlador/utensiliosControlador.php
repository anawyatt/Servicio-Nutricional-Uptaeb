<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;
 use modelo\utensiliosModelo as utensilios;

  $objeto = new utensilios;
  $sistem = new encryption();
  $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Utensilios', 'consultar');
  $permisos = $datosPermisos['permisos'];
  $payload = $datosPermisos['payload'];
  $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

  if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
    $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
    echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
    die();
  }

 $NotificacionesServer = new NotificacionesServer();

    if (isset($payload->cedula)) {
          $NotificacionesServer->setCedula($payload->cedula);
      } else {
          echo json_encode(['error' => 'Cédula no encontrada en el token']);
          exit;
      }

      if (isset($_POST['notificaciones'])) {
          $valor = $NotificacionesServer->consultarNotificaciones();
      }
    
      if (isset($_POST['notificacionId'])) {
          $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
    }

if (isset($datosPermisos['permiso']['consultar'])) {  
  if (isset($_POST['valida']) && isset($_POST['tipoU'])) {
    echo json_encode($objeto->verificarExistenciaTipoU($_POST['tipoU'], false));
    exit;
  }

  if (isset($_POST['select'])) {
    $resultado = $objeto->mostrarTipoUtensilios();
    echo json_encode($resultado);
    exit;
  }
}


if (isset($datosPermisos['permiso']['registrar'])) {
  if (isset($_POST['tipoU']) && isset($_POST['utensilio']) && isset($_POST['material'])) {

      $tipoU = $_POST['tipoU'];
      $utensilio = $_POST['utensilio'];
      $material = $_POST['material'];

      $verificar = $objeto->verificarUtensilios($tipoU, $utensilio, $material);

      echo json_encode($verificar);
      exit;
  }

  if (isset($_POST['imgState']) && isset($_POST['tipoUr']) && isset($_POST['utensilior']) && isset($_POST['materialr']) && isset($_POST['csrfToken'])) {
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $imagen = (isset($_FILES['imagen']) && isset($_FILES['imagen']['tmp_name'])) ? $_FILES['imagen']['tmp_name'] : null;

    $respuesta = $objeto->registrarUtensilio($imagen, $_POST['imgState'], $_POST['tipoUr'], $_POST['utensilior'], $_POST['materialr'], false);
    echo json_encode(['mensaje'=> $respuesta, 'newCsrfToken' => $csrf['newToken']]);
    exit;
  }
}

 $components = new initComponents();
 $navegador = new navegador($payload);
 $sidebar = new sidebar($permisos);
 $footer = new footer();
 $configuracion = new configuracion($permisos);


  if (file_exists("vista/utensiliosVista.php")) {
  require_once("vista/utensiliosVista.php");
  }else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
 }

 ?>