<?php
  use component\initComponents as initComponents;
  use component\navegador as navegador;
  use component\sidebar as sidebar;
  use component\footer as footer;
  use component\NotificacionesServer as NotificacionesServer;
  use helpers\encryption as encryption;
  use helpers\permisosHelper as permisosHelper;
  use component\configuracion as configuracion;
  use modelo\usuarioModelo as usuario;
  use middleware\PostRateMiddleware as PostRateMiddleware;
  use helpers\csrfTokenHelper;
  use middleware\csrfMiddleware;


  $object = new usuario;
  $sistem = new encryption();
  $NotificacionesServer = new NotificacionesServer();

  $datosPermisos = permisosHelper::verificarPermisos($sistem, $object, 'Usuarios', 'registrar');
  $permisos = $datosPermisos['permisos'];
  $payload = $datosPermisos['payload'];


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

    $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

    if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
        $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
        echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
        die();
    }
    
       if(isset($_POST['mostrarC']) && isset($_POST['cedula']) ){
                $validarC = $object->validarCedula($_POST['cedula']);
        if (isset($validarC['resultado']) && $validarC['resultado'] === 'error Cedula') {
            echo json_encode($validarC);
            die();
        }
      }

    if(isset($_POST['muestra2'])  && isset($_POST['correo']) ){
      $validarCorreo=  $object->validarCorreo($_POST['correo']);
      if (isset($validarCorreo['resultado']) && $validarCorreo['resultado'] === 'error correo'){
        echo json_encode($validarCorreo);
        die();
      }
    }

    if(isset($_POST['muestra3'])  && isset($_POST['telefono']) ){
      $validarTelefono= $object->validarTelefono($_POST['telefono']);
      if(isset($validarTelefono['resultado']) && $validarTelefono['resultado'] === 'error telefono'){
        echo json_encode($validarTelefono);
        die();
      }
    }

      if (isset($_POST['valida']) && isset($_POST['idRol'])) {
          $validarExistencia = $object->verificarExistenciaRol($_POST['idRol']);
          echo json_encode($validarExistencia);
          die();
      }


    if (isset($_POST['select']) && $_POST['select'] === 'mostrar') {
      $roles = $object->mostrarRol();
      echo json_encode($roles); 
      die();
    }


    if(isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['segNombre']) && isset($_POST['apellido']) &&
     isset($_POST['segApellido']) && isset($_POST['correo']) && isset($_POST['telefono'])   && isset($_POST['idRol']) 
     &&  isset($_POST['clave']) && isset($_POST['csrfToken'])){

       $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

        PostRateMiddleware::verificar('registrar', (array)$payload); 
     $registrarUsuario = $object->registrarUsuario($_POST['cedula'], $_POST['nombre'], $_POST['segNombre'], $_POST['apellido'], 
     $_POST['segApellido'], $_POST['correo'], $_POST['telefono'], $_POST['idRol'] , $_POST['clave']);
     echo json_encode(['mensaje' => $registrarUsuario, 'newCsrfToken' => $csrf['newToken']]);
      die();

    }

    
  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/usuarioVista.php")) {
   require_once("vista/usuarioVista.php");
   }else {
   die("<script>window.location='?url=" . urlencode ($sistem->encryptURL('login')) . "'</script>");
  
  }

 
  ?>
  