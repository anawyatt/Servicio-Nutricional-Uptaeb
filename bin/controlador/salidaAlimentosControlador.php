<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use helpers\encryption as encryption;
 use modelo\salidaAlimentosModelo as salidaAlimentos;
 use helpers\permisosHelper as permisosHelper;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;
use middleware\PostRateMiddleware as PostRateMiddleware;

 $objeto = new salidaAlimentos;
$sistem = new encryption();
$NotificacionesServer = new NotificacionesServer();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Inventario de Alimentos', 'registrar');
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



 if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
   try{
     $validarExistenciaTA=  $objeto->verificarExistenciaTipoA($_POST['tipoA']);
      if ($validarExistenciaTA['resultado'] == 'no esta') { 
       echo json_encode($validarExistenciaTA);
       die();
      }
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
   }

 if (isset($_POST['select'])) {
  try {
      $mostrarTipoA= $objeto->mostrarTipoAlimento();
      echo json_encode($mostrarTipoA);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }

  if (isset($_POST['valida2']) && isset($_POST['alimento'])) {
    try{
      $validarExistenciaA=  $objeto->verificarExistenciaAlimento($_POST['alimento']);
      if ($validarExistenciaA['resultado'] == 'no esta') { 
       echo json_encode($validarExistenciaA);
       die();
      }
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }


  if (isset($_POST['select2']) && isset($_POST['tipoA'])) {
   try {
      $mostrarAlimento= $objeto->mostrarAlimento( $_POST['tipoA']);
      echo json_encode($mostrarAlimento);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }


if (isset($_POST['valida3']) && isset($_POST['tipoS'])) {
  try{
      $validarExistenciaTS=  $objeto->verificarExistenciaTipoS($_POST['tipoS']);
      if ($validarExistenciaTS['resultado'] == 'no esta') { 
       echo json_encode($validarExistenciaTS);
       die();
      }
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
   }

  if (isset($_POST['select3'])) {
  try {
      $mostrarTipoS= $objeto->mostrarTipoSalida();
      echo json_encode($mostrarTipoS);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }

  if (isset($_POST['muestra']) && isset($_POST['idAlimento'])) {
    try {
      $infoAlimento= $objeto->infoAlimento( $_POST['idAlimento']);
      echo json_encode($infoAlimento);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }

  //------------------- REGISTRAR -----------------------
 if(isset($_POST['registrar'])  && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['tipoS']) && isset($_POST['descripcion']) && isset($_POST['csrfToken']) ){
    try {
      PostRateMiddleware::verificar('registrar', (array)$payload);
      $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
      $registrarS= $objeto->registrarSalidaA($_POST['fecha'], $_POST['hora'], $_POST['tipoS'] , $_POST['descripcion']);
      echo json_encode(['mensaje'=>$registrarS, 'newCsrfToken' => $csrf['newToken']]);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
   
 }

 if(isset($_POST['alimento'])  && isset($_POST['cantidad'])  && isset($_POST['id']) ){
   try {
      $registrarDetalle= $objeto->registrarDetalleSalidaA($_POST['alimento'], $_POST['cantidad'] , $_POST['id'] );
      echo json_encode($registrarDetalle);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
   
 }


  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/salidaAlimentosVista.php")) {
   require_once("vista/salidaAlimentosVista.php");
   }else {
  die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login') ). "'</script>");
  }

  ?>
  