<?php
    use component\initComponents as initComponents;
    use component\navegador as navegador;
    use component\sidebar as sidebar;
    use component\footer as footer;
    use component\configuracion as configuracion;
    use component\NotificacionesServer as NotificacionesServer;
    use helpers\encryption as encryption;
    use helpers\permisosHelper as permisosHelper;
    use modelo\consultarUsuarioModelo as consultarUsuario;
    use middleware\PostRateMiddleware as PostRateMiddleware;
    use helpers\csrfTokenHelper;
    use middleware\csrfMiddleware;


    $object = new consultarUsuario;
    $sistem = new encryption();
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

    $datosPermisos = permisosHelper::verificarPermisos($sistem, $object, 'Usuarios', 'consultar');
    $permisos = $datosPermisos['permisos'];
    $payload = $datosPermisos['payload'];

     $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

    if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
        $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
        echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
        die();
    }


    if (isset($_POST['mostrar']) && isset($datosPermisos['permiso']['consultar'])) {
        $data = $object->mostrarUsuario();
        echo json_encode($data);
        die();
    }
    
    if (isset($_POST['verUsuario']) && isset($datosPermisos['permiso']['consultar'])) {
        $verificacion = $object->verificarExistencia($_POST['id']);

        if (isset($verificacion['resultado']) && $verificacion['resultado'] === 'Existe') {
            $infoUsuario = $object->infoUsuario($_POST['id']);
            echo json_encode($infoUsuario);
            die();
        } else {
            echo json_encode($verificacion); 
            die();
        }
    }
    
    
    if (isset($_POST['select2']) && $_POST['select2'] === 'mostrar') {
      $roles = $object->mostrarRol();
      echo json_encode($roles); 
      die();
    }

    if (isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['segNombre']) && isset($_POST['apellido'])
    && isset($_POST['segApellido']) && isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['idRol']) 
    && isset($_POST['estado']) && isset($datosPermisos['permiso']['modificar'])  && isset($_POST['csrfToken'])) {

          $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

          PostRateMiddleware::verificar('modificar', (array)$payload); 

        $validarCorreo = $object->validarCorreo($_POST['correo'], $_POST['cedula']);
        if ($validarCorreo['resultado'] === 'error correo') {
            echo json_encode($validarCorreo);
            die();
        }

        $validarTelefono = $object->validarTelefono($_POST['telefono'], $_POST['cedula']);
        if ($validarTelefono['resultado'] === 'error telefono') {
            echo json_encode($validarTelefono);
            die();
        }

        $resultado = $object->editarUsuario($_POST['cedula'], $_POST['nombre'], $_POST['segNombre'], $_POST['apellido'],
        $_POST['segApellido'], $_POST['correo'], $_POST['telefono'], $_POST['idRol'], $_POST['estado']);

        echo json_encode(['mensaje' => $resultado, 'newCsrfToken' => $csrf['newToken']]);
        die();
    }

    if (isset($_POST['eliminar']) && isset($_POST['iD']) && isset($datosPermisos['permiso']['eliminar']) 
    && isset($_POST['csrfToken'])) {
            
            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

        PostRateMiddleware::verificar('anular', (array)$payload); 
        
          $verificar = $object->verificarExistencia($_POST['iD']);
          if (isset($verificar['resultado']) && $verificar['resultado'] === 'Existe') {
              $eliminarUsuario = $object->eliminarUsuario($_POST['iD']);
              echo json_encode(['mensaje' => $eliminarUsuario, 'newCsrfToken' => $csrf['newToken']]);
              die();
          } else {
              echo json_encode(['resultado' => 'error usuario']); 
              die();
          }
    }

  $components = new initComponents();
  $navegador = new navegador($payload);
  $configuracion = new configuracion($permisos);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
 

   if (file_exists("vista/consultarUsuarioVista.php")) {
   require_once("vista/consultarUsuarioVista.php");
   }else {
   die("<script>window.location='?url=" . urlencode ($sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  