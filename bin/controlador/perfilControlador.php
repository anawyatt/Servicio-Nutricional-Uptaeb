<?php
    use component\initComponents as initComponents;
    use component\navegador as navegador;
    use component\sidebar as sidebar;
    use component\NotificacionesServer as NotificacionesServer;
    use component\configuracion as configuracion;
    use helpers\encryption as encryption;
    use helpers\JwtHelpers;
    use helpers\csrfTokenHelper;
    use middleware\csrfMiddleware;
    use modelo\perfilModelo as perfil;


    $objet = new perfil(); 
    $sistem = new encryption();
    $NotificacionesServer = new NotificacionesServer();

    $jwt = new JwtHelpers();
    $payload = $jwt->validarToken($_COOKIE['jwt'] ?? '');

  
    if (!$payload) {
        die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
    }
      $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

    
if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
    $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
    echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
    die();
}

    $permisos = $objet->getPermisosRol($payload->rol);

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

    if (isset($_POST['info'])) {
      $respuesta = $objet->informacionUsuario($payload->cedula);
      echo json_encode($respuesta);
      die();
    }


    if (isset($_POST['validarCorreo']) && $_POST['validarCorreo'] == true && isset($_POST['correo']) && isset($_POST['cedula'])) {
        echo json_encode($object->validarCorreo($_POST['correo'], $_POST['cedula']));
        die();
    }

    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['csrfToken'])) {

        $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
        $respuesta = $objet->editarPerfil($_POST['nombre'], $_POST['apellido'], $_POST['correo']);
        echo json_encode(['respuesta'=>$respuesta, 'newCsrfToken' => $csrf['newToken']]);
        die();
    }



    if (isset($_POST['nuevaClave']) && isset($_POST['repetirClave']) && isset($_POST['csrfToken'])) {
        $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
        $respuesta2 = $objet->cambiarContraseña($_POST['clave'], $_POST['nuevaClave'], $_POST['repetirClave']);
        echo json_encode(['respuesta2'=>$respuesta2, 'newCsrfToken' => $csrf['newToken']]);
        die();
    }

    if (isset($_POST['borrar'])  && isset($_POST['csrfToken'])) {
        $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
        $respuesta3 = $objet->eliminarImagen();
        echo json_encode(['respuesta3'=>$respuesta3, 'newCsrfToken' => $csrf['newToken']]);
        die();
    }


    if (isset($_POST['accion']) && $_POST['accion'] === 'imagenPerfil' && isset($_POST['csrfToken'])) {
        if (isset($_FILES['imagen']['tmp_name'])) {
            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
            $respuesta4 = $objet->editarImagen($_FILES['imagen']['tmp_name']);
            echo json_encode(['respuesta4'=>$respuesta4, 'newCsrfToken' => $csrf['newToken']]);
            die();
        }
    }


    $components = new initComponents();
    $navegador = new navegador($payload);
    $sidebar = new sidebar($permisos);
    $configuracion = new configuracion($permisos);

    if (file_exists("vista/perfilVista.php")) {
        require_once("vista/perfilVista.php");
    } else {
        die("<script>window.location='?url=" . urlencode($sistem->encryptURL('perfil')) . "'</script>");
    }
