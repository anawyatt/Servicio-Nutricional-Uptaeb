<?php
use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;
use component\configuracion as configuracion;
use component\NotificacionesServer as NotificacionesServer;
use modelo\rolesModelo as rol; 
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;
use helpers\csrfTokenHelper;
use middleware\csrfMiddleware;
 use middleware\PostRateMiddleware as PostRateMiddleware;


$objeto = new rol(); 
$sistem = new encryption();
$NotificacionesServer = new NotificacionesServer();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Roles', 'consultar');
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


//registrar
if (isset($datosPermisos['permiso']['registrar'])) {
  
if(isset($_POST['rol'])){
  try{
    $validar = $objeto->validarRol($_POST['rol']);
    if ($validar['resultado'] == 'error2') { 
      echo json_encode($validar);
      die();
    }
  }catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
   }
}
if(isset($_POST['registrar']) && isset($_POST['rol'])  && isset($_POST['csrfToken']) ){
  try{
    PostRateMiddleware::verificar('registrar', (array)$payload);
     $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $respuesta = $objeto->registrarRol($_POST['rol']);
    if ($respuesta['resultado'] == 'exitoso') { 
      echo json_encode(['mensaje' => $respuesta,'newCsrfToken' => $csrf['newToken']]);
      die();
    }
  }catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
   }
    
}
}

//Consultar 

if (isset($datosPermisos['permiso']['consultar'])) {

if(isset($_POST['muestra'])){
 $mostrar= $objeto->mostrarRolesTabla();
 echo json_encode($mostrar);
 die();
}


if(isset($_POST['info']) && $_POST['id']){
  $mostrarInfo=  $objeto->muestraRol($_POST['id']);
  echo json_encode($mostrarInfo);
  die();
}

}

//modificar

if (isset($datosPermisos['permiso']['modificar'])) {

if(isset($_POST['rol2']) && isset($_POST['id']) ){
  try{
    $validar = $objeto->validarRol2($_POST['rol2'], $_POST['id']);
    if ($validar['resultado'] == 'errorRol') { 
      echo json_encode($validar);
      die();
    }
  }catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
   }    
}

if(isset($_POST['rol2']) && isset($_POST['id'])  && isset($_POST['csrfToken'])  ){
  try{
    PostRateMiddleware::verificar('modificar', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $verificarE= $objeto->verificarExistencia($_POST['id']);
    if ($verificarE['resultado'] == 'ya no existe') { 
      echo json_encode($verificarE);
      die();
    }
    $modificar = $objeto->editarRol($_POST['rol2'], $_POST['id']);
    echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]);
    die();

  }catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
   }
}

}


//eliminar

if (isset($datosPermisos['permiso']['eliminar'])) {

if(isset($_POST['verificarRolUsuario']) && isset($_POST['id']) ){
  $verificar = $objeto->usuariosRegistradosConRol($_POST['id']);
   echo json_encode($verificar);
   die();
}
if(isset($_POST['eliminar']) && isset($_POST['id'])  && isset($_POST['csrfToken']) ){
   $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
  try{
    PostRateMiddleware::verificar('anular', (array)$payload);
    $verificarE= $objeto->verificarExistencia($_POST['id']);
    if ($verificarE['resultado'] == 'ya no existe') { 
      echo json_encode($verificarE);
      die();
    }
    $eliminar =  $objeto->eliminarRol($_POST['id']);
    echo json_encode(['mensaje'=>$eliminar, 'newCsrfToken' => $csrf['newToken']]);
    die();

  }catch (\RuntimeException $e) {
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

if (file_exists("vista/rolesVista.php")) {
    require_once("vista/rolesVista.php");
} else {
   die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login')). "'</script>");
}

  ?>