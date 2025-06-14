<?php
 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use modelo\PermisoModelo as Permisos;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;
 use middleware\PostRateMiddleware as PostRateMiddleware;
 
$permisosModel = new Permisos();
$sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $permisosModel, 'Permisos', 'consultar');
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
  

if (isset($datosPermisos['permiso']['consultar'])) {

if (isset($_POST['mostrar'])) {
  
   try {
      $mostrarRoles=$permisosModel->obtenerRoles();
      echo json_encode($mostrarRoles);
      die();
    } catch (\RuntimeException $e) {
       echo json_encode(['message' => $e->getMessage()]);
       die();
    }  
}


if (isset($_POST['mostrarr'])) {
  try {
    $mostrarModulos= $permisosModel->obtenerModulos();
    echo json_encode($mostrarModulos);
    die();
  } catch (\RuntimeException $e) {
     echo json_encode(['message' => $e->getMessage()]);
     die();
  }  
}


if (isset($_POST['permisos'], $_POST['id'])) {
  try {
    $mostrarPermisos= $permisosModel->getPermisos($_POST['id']);
    echo json_encode($mostrarPermisos);
    die();
  } catch (\RuntimeException $e) {
     echo json_encode(['message' => $e->getMessage()]);
     die();
  }  
 
}

}

if (isset($datosPermisos['permiso']['modificar'])) {

if(isset($_POST['datos_permisos']) && isset($_POST['csrfToken'])){
  try {
    PostRateMiddleware::verificar('modificar', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $modificar= $permisosModel->actualizarPermisos($_POST['datos_permisos']);
    echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]);
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
$configuracion = new configuracion($permisos);
$footer = new footer();


if (file_exists("vista/permisoVista.php")) {
   require_once("vista/permisoVista.php");
   }else {
   die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
  }

?>
