<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;
 use middleware\PostRateMiddleware as PostRateMiddleware;

 use modelo\alimentosModelo as alimentos;

 $objeto = new alimentos;
 $sistem = new encryption();

 $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Alimentos', 'registrar');
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
  $mostrarTipoA= $objeto->mostrarTipoAlimento();
  echo json_encode($mostrarTipoA);
  die();
 }

if ( isset($_POST['tipoA']) && isset($_POST['alimento']) && isset($_POST['marca'])) {
  try {
    $verificarAlimento=  $objeto->verificarAlimento($_POST['tipoA'], $_POST['alimento'], $_POST['marca']);
    if ($verificarAlimento['resultado'] == 'existe') { 
      echo json_encode($verificarAlimento);
      die();
     }
  } catch (\RuntimeException $e) {
    echo json_encode(['message' => $e->getMessage()]);
    die();
  }
}

if (isset($_POST['men']) && isset($_POST['tipoA']) && isset($_POST['alimento']) && isset($_POST['marca']) && isset($_POST['unidad']) && isset($_POST['csrfToken'])) {
  if ($_POST['men'] === 'SI') {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $resultado = $objeto->validarImagen($_FILES['imagen']);
            if ($resultado !== true) {
                echo json_encode($resultado);
                die();
            }
        } else {
            echo json_encode(['resultado' => 'No se recibió imagen']);
            die();
        }
    }
    PostRateMiddleware::verificar('registrar', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $imagen = ($_POST['men'] === 'SI' && isset($_FILES['imagen']['tmp_name'])) ? $_FILES['imagen']['tmp_name'] : null;
    $registrar = $objeto->registrarAlimento($imagen, $_POST['men'], $_POST['tipoA'], $_POST['alimento'], $_POST['marca'],$_POST['unidad']);
    echo json_encode(['mensaje'=> $registrar, 'newCsrfToken' => $csrf['newToken']]);
    die();
}


  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/alimentosVista.php")) {
   require_once("vista/alimentosVista.php");
   }else {
    die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  