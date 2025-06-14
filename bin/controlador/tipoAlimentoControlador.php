<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use modelo\tipoAlimentoModelo as tipoAlimento;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;
 use middleware\PostRateMiddleware as PostRateMiddleware;

 $objeto = new tipoAlimento;
 $sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Tipos de Alimentos', 'consultar');
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
        die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
    }

    if (isset($_POST['notificaciones'])) {
        $valor = $NotificacionesServer->consultarNotificaciones();
    }
  
    if (isset($_POST['notificacionId'])) {
        $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
    }


 //========================= registrar ====================

if (isset($datosPermisos['permiso']['registrar'])) {
  if (isset($_POST['tipoA'])) {

    try {
      $validar = $objeto->verificarTipoAlimento($_POST['tipoA']);
      if ($validar['resultado'] == 'error tipo') { 
        echo json_encode($validar);
        die();
      }
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }

  if (isset($_POST['registrar']) && isset($_POST['tipoA']) && isset($_POST['csrfToken'])) {
    try {
        PostRateMiddleware::verificar('registrar', (array)$payload);
        $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

        $registrar = $objeto->registrarTipoAlimento($_POST['tipoA']);
        echo json_encode(['mensaje' => $registrar,'newCsrfToken' => $csrf['newToken']]);
        die();
    } catch (\RuntimeException $e) {
        echo json_encode(['error' => $e->getMessage()]);
        die();
    }
  }

}



//======================= Consultar -------------------------

if (isset($datosPermisos['permiso']['consultar'])) {
  if (isset($_POST['muestra'], $_POST['tabla'])) {
    try {
      $mostrar = $objeto->tabla();
      echo json_encode($mostrar);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }

  if (isset($_POST['mostrar']) && isset($_POST['id'])) {
    try {
      $mostrarInfo = $objeto->mostrarTipoA($_POST['id']);
      echo json_encode($mostrarInfo);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }

  if (isset($_POST['modificar']) && isset($_POST['id'])) {
    try {
      $verificarBoton = $objeto->verificarBoton($_POST['id']);
      echo json_encode($verificarBoton);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }
}

//------------------- Modificar ----------------------

if (isset($datosPermisos['permiso']['modificar'])) {

  if (isset($_POST['tipoA2']) && isset($_POST['id']) && isset($_POST['csrfToken'])) {
      try {
           PostRateMiddleware::verificar('modificar', (array)$payload);
          $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

          $verificarExistencia = $objeto->verificarExistencia($_POST['id']);
          if ($verificarExistencia['resultado'] == 'ya no existe') { 
              echo json_encode($verificarExistencia); 
              die();
          }

          $verificarTipoAlimento = $objeto->verificarTipoA2($_POST['tipoA2'], $_POST['id']);
          if ($verificarTipoAlimento['resultado'] == 'error tipo') {
              echo json_encode($verificarTipoAlimento); 
              die();
          }

          $modificar = $objeto->modificarTipoAlimento($_POST['tipoA2'], $_POST['id']);
          echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]); 
          die();
  
      } catch (\RuntimeException $e) {
          echo json_encode(['message' => $e->getMessage()]);
          die();
      }
  }
}


  //-------- ANULAR -----------------------------------------
 if (isset($datosPermisos['permiso']['eliminar'])) {
   if (isset($_POST['id']) && isset($_POST['borrar']) && isset($_POST['csrfToken'])) {
  try {
    PostRateMiddleware::verificar('anular', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $verificarExistencia = $objeto->verificarExistencia($_POST['id']);
    if ($verificarExistencia['resultado'] == 'ya no existe') { 
        echo json_encode($verificarExistencia); 
        die();
    }

    $anular= $objeto->anularTipoAlimento($_POST['id']);
    echo json_encode(['mensaje'=>$anular, 'newCsrfToken' => $csrf['newToken']]); 
    die();

  } catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }
    
  }
}



  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/tipoAlimentoVista.php")) {
   require_once("vista/tipoAlimentoVista.php");
   }else {
   die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  