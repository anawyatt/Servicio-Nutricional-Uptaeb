<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;
 use modelo\consultarUtensiliosModelo as consultarUtensilios;
  use middleware\PostRateMiddleware as PostRateMiddleware;


 $objeto = new consultarUtensilios;
 $sistem = new encryption();
 $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Utensilios', 'consultar');
 $permisos = $datosPermisos['permisos'];
 $payload = $datosPermisos['payload'];
 $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

  if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }



 if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
    $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
    echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
    die();
  }

      

if(isset($_POST['mostrarU'])){
 $mostrarTabla= $objeto->mostrarUtensilios();
  echo json_encode($mostrarTabla);
      die();
}

if (isset($datosPermisos['permiso']['consultar'])) {
  if (isset($_POST['infoUtensilio'], $_POST['id'])) {
    $verificar = $objeto->verificarExistencia($_POST['id']);

    if ($verificar !== null) {
        echo json_encode($verificar);
        exit;
    }

    echo json_encode($objeto->infoUtensilio($_POST['id']));
    exit;
  }

  if (isset($_POST['valida'], $_POST['tipoU'])) {
    $resultado = $objeto->verificarExistenciaTipoU($_POST['tipoU']);
    echo json_encode($resultado);
    exit;
  }

  if (isset($_POST['select'])) {
    $mostrarTipoU = $objeto->mostrarTipoUtensilio();
    echo json_encode($mostrarTipoU);
    exit;
  }
}

if(isset($_POST['verificarUtensilios']) && isset($_POST['id']) && isset($_POST['utensilio']) && isset($_POST['material']) ) {
   try {

   $verificarUtensilio=  $objeto->verificarUtensilio($_POST['id'],  $_POST['utensilio'], $_POST['material']);
      echo json_encode($verificarUtensilio);
      die();
    
  } catch (\RuntimeException $e) {  
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }
 }

if (isset($datosPermisos['permiso']['modificar'])) {
  if (isset($_POST['modificar'], $_POST['id'])) {
    $respuesta = $objeto->verificarModificacion($_POST['id']);
    echo json_encode($respuesta);
    exit;
  }


  if (
    isset($_POST['modificarINFO'], $_POST['id'], $_POST['tipoU'], $_POST['utensilio'], $_POST['material'], $_POST['csrfToken'])
  ) {
    PostRateMiddleware::verificar('modificar', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $modificar = $objeto->modificarUtensilio($_POST['id'], $_POST['tipoU'], $_POST['utensilio'], $_POST['material']);
    echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]);
    exit;
  }

  if (isset($_FILES['imagen']) && isset($_POST['validarIMG'])) {
    $validarImagen = $objeto->validarImagen($_FILES['imagen']);
    echo json_encode($validarImagen);
    die();
}


  if (isset($_FILES['imagen'], $_POST['id'])) {
    try {
     $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
     
     PostRateMiddleware::verificar('modificar', (array)$payload);

     $modificar= $objeto->modificarImagen($_FILES['imagen'], $_POST['id']);

           echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]);
           die();
  } catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }
  }
}

if (isset($datosPermisos['permiso']['eliminar'])) {
  if (isset($_POST['id'], $_POST['borrar'], $_POST['csrfToken'])) {
    PostRateMiddleware::verificar('eliminar', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $eliminar = $objeto->anularUtensilio($_POST['id']);
    echo json_encode(['mensaje'=>$eliminar, 'newCsrfToken' => $csrf['newToken']]);
    exit;
  }
}


  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/consultarUtensiliosVista.php")) {
   require_once("vista/consultarUtensiliosVista.php");
   }else {
    die("<script>window.location='?url=" . urlencode( $sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  