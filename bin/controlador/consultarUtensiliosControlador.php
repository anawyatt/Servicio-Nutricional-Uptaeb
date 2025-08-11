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
 use modelo\consultarUtensiliosModelo as consultarUtensilios;


 $objeto = new consultarUtensilios;
 $sistem = new encryption();
 $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Utensilios', 'consultar');
 $permisos = $datosPermisos['permisos'];
 $payload = $datosPermisos['payload'];
 $NotificacionesServer = new NotificacionesServer();
 $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

 if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
    $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
    echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
    die();
  }

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

if (isset($datosPermisos['permiso']['modificar'])) {
  if (isset($_POST['modificar'], $_POST['id'])) {
    $respuesta = $objeto->verificarModificacion($_POST['id']);
    echo json_encode($respuesta);
    exit;
  }

  if (
    isset($_POST['modificarINFO'], $_POST['id'], $_POST['tipoU'], $_POST['utensilio'], $_POST['material'], $_POST['csrfToken'])
  ) {

    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $verificarUtensilio = $objeto->verificarUtensilio($_POST['id'], $_POST['tipoU'], $_POST['utensilio'], $_POST['material']);
    $modificar = $objeto->modificarUtensilio($_POST['id'], $_POST['tipoU'], $_POST['utensilio'], $_POST['material']);
    echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]);
    exit;
  }

  if (isset($_FILES['imagen'], $_POST['id'])) {
    $modificar = $objeto->modificarImagen($_FILES['imagen'], $_POST['id']);
    // Si la respuesta es un error de validación de imagen, devolverlo como resultado
    if (isset($modificar['resultado']) && (
      $modificar['resultado'] === 'El archivo no es una imagen válida (JPEG, PNG)!' ||
      $modificar['resultado'] === 'La imagen no debe superar los 2MB!' ||
      $modificar['resultado'] === 'La imagen está dañada o no se puede procesar!' ||
      $modificar['resultado'] === 'No se recibió imagen'
    )) {
      echo json_encode($modificar);
      exit;
    }
    echo json_encode($modificar);
    exit;
  }
}

if (isset($datosPermisos['permiso']['eliminar'])) {
  if (isset($_POST['id'], $_POST['borrar'], $_POST['csrfToken'])) {
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
  