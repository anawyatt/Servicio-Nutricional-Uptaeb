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
 use middleware\PostRateMiddleware as PostRateMiddleware;

 use modelo\consultarAlimentosModelo as consultarAlimentos;

 $objeto = new consultarAlimentos;
 $sistem = new encryption();

 $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Alimentos', 'consultar');
 $permisos = $datosPermisos['permisos'];
 $payload = $datosPermisos['payload'];

 if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }


$tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
    $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
    echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
    die();
}


if (isset($datosPermisos['permiso']['consultar'])) {
 //--------- MOSTRAR TABLA

 if(isset($_POST['mostrarAlimentos']) && isset($_POST['tipoA']) ){
  try {
    $mostrarTabla= $objeto->mostrarAlimentos($_POST['tipoA']);
      echo json_encode($mostrarTabla);
      die();
  } catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }
}

//---------- MOSTRAR INFORMACIÓN

if(isset($_POST['infoAlimento']) && isset($_POST['id'])){
  try {
    $verificarExistencia= $objeto->verificarExistencia( $_POST['id']);
    if ($verificarExistencia['resultado'] == 'ya no existe') { 
      echo json_encode($verificarExistencia);
      die();
    }
    $mostrarInfo= $objeto->infoAlimento($_POST['id']);
    echo json_encode($mostrarInfo);
    die();
  } catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }

}

// select tipo Alimentos

if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
  try {
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

// validat Boton

    if (isset($_POST['modificar']) && isset($_POST['id'])) {
      try {
        PostRateMiddleware::verificar('modificar', (array)$payload);
        $verificarBoton= $objeto->verificarBoton($_POST['id']);
          echo json_encode($verificarBoton);
          die();
      } catch (\RuntimeException $e) {
        echo json_encode(['message' => $e->getMessage()]);
        die();
      }
      
    }

  
}

if(isset($_POST['verificarAlimento']) && isset($_POST['id']) && isset($_POST['alimento']) && isset($_POST['marca']) && isset($_POST['unidad']) ) {
   try {

   $verificarAlimento=  $objeto->verificarAlimento($_POST['id'],  $_POST['alimento'], $_POST['marca'], $_POST['unidad']);
    if ($verificarAlimento['resultado'] == 'existe') { 
      echo json_encode($verificarAlimento);
      die();
     }
  } catch (\RuntimeException $e) {  
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }
 }

if (isset($datosPermisos['permiso']['modificar'])) {

// ------ MODIFICAR 

if ( isset($_POST['modificarINFO']) && isset($_POST['id']) && isset($_POST['tipoA']) && isset($_POST['alimento']) && isset($_POST['marca']) && isset($_POST['unidad']) && isset($_POST['csrfToken']) ) {
  try {
    PostRateMiddleware::verificar('modificar', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
   
     $modificar= $objeto->modificarAlimentos($_POST['id'], $_POST['tipoA'], $_POST['alimento'], $_POST['marca'], $_POST['unidad']);
     echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]);
     die();

  } catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }

   }

   if(isset(($_FILES['imagen']) ) && isset($_POST['validarIMG'])){
    try {
      $validarImagen = $objeto->validarImagen($_FILES['imagen']);
      echo json_encode($validarImagen);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }

   }

if (isset($_FILES['imagen']) && isset($_POST['id']) && isset($_POST['csrfToken'])) {
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

//--------ANULAR-----------------

 if (isset($_POST['id']) && isset($_POST['borrar']) && isset($_POST['csrfToken'])) {
  try {
    PostRateMiddleware::verificar('anular', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $anular= $objeto->anularAlimento($_POST['id']);
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


   if (file_exists("vista/consultarAlimentosVista.php")) {
   require_once("vista/consultarAlimentosVista.php");
   }else {
    die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login') ). "'</script>");
  }

  ?>
  