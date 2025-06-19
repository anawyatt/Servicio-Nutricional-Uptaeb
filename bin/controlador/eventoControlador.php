<?php
    
    use component\initComponents as initComponents;
    use component\navegador as navegador;
    use component\sidebar as sidebar;
    use component\footer as footer;
    use helpers\encryption as encryption;
    use helpers\permisosHelper as permisosHelper;    
    use component\configuracion as configuracion;
    use component\NotificacionesServer as NotificacionesServer;
    use middleware\PostRateMiddleware as PostRateMiddleware;
    use helpers\csrfTokenHelper;
    use middleware\csrfMiddleware;
    use modelo\eventoModelo as evento;

    $object = new evento;
    $sistem = new encryption();
    $NotificacionesServer = new NotificacionesServer();

    $datosPermisos = permisosHelper::verificarPermisos($sistem, $object, 'Eventos', 'registrar');
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
  
    if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
        $validarExistenciaTA=  $object->verificarExistenciaTipoA($_POST['tipoA']);
          if(isset($validarExistenciaTA['resultado']) && $validarExistenciaTA['resultado'] === 'no esta'){
            echo json_encode($validarExistenciaTA);
            die();
          }
    }

    if (isset($_POST['select'])) {
        $mostrarTipoA= $object->mostrarTipoAlimento();
          echo json_encode($mostrarTipoA);
          die();
    }

    if (isset($_POST['valida2']) && isset($_POST['alimento'])) {
        $validarExistenciaA=  $object->verificarExistenciaAlimento($_POST['alimento']);
          if(isset($validarExistenciaA['resultado']) && $validarExistenciaA['resultado'] === 'no esta'){
          echo json_encode($validarExistenciaA);
          die();
          }
    }

    if (isset($_POST['select2']) && isset($_POST['tipoA'])) {
        $mostrarAlimento= $object->mostrarAlimento( $_POST['tipoA']);
          echo json_encode($mostrarAlimento);
          die();
    }

    if (isset($_POST['muestra']) && isset($_POST['idAlimento'])) {
        $infoAlimento= $object->infoAlimento( $_POST['idAlimento']);
          echo json_encode($infoAlimento);
          die();
    }

    if (isset($_POST['validar']) && isset($_POST['feMenu']) && isset($_POST['horarioComida'])) {
          $validarFH= $object->validarFH( $_POST['feMenu'], $_POST['horarioComida']);
          if(isset($validarFH['resultado']) && $validarFH['resultado'] === 'error'){
          echo json_encode($validarFH);
          die();
          }
    }

  

    if(isset($_POST['registrar']) && isset($_POST['feMenu'])  && isset($_POST['horarioComida']) && isset($_POST['cantPlatos'])
     && isset($_POST['nomEvent']) && isset($_POST['descripEvent'])  && isset($_POST['descripcion']) && isset($_POST['csrfToken'])){
          
        $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

      PostRateMiddleware::verificar('registrar', (array)$payload);  

      $registrarE= $object->registrarEvento( $_POST['feMenu'], $_POST['horarioComida'] , $_POST['cantPlatos'], $_POST['nomEvent'], $_POST['descripEvent'], $_POST['descripcion']); 
      if (!isset($registrarE['resultado']) || $registrarE['resultado'] !== 'registrado') {
              echo json_encode([
                'resultado' => 'error', 
                'mensaje' => $registrarE, 
                'newCsrfToken' => $csrf['newToken']]);
              die();
          }
          echo json_encode([
              'resultado' => 'exitoso',
              'eventId' => $registrarE['eventId'],
              'menuId' => $registrarE['menuId'],
              'salidaId' => $registrarE['salidaId'],
              'newCsrfToken' => $csrf['newToken']
          ]);
          die();
      }
      
  
    if(isset($_POST['alimento'])  && isset($_POST['cantidad']) && isset($_POST['menuId'])  && isset($_POST['salidaId']) ){
            
        $registrarDetalle= $object->detalleSalidaM($_POST['alimento'], $_POST['cantidad'] , $_POST['menuId'], $_POST['salidaId'] );
          echo json_encode ($registrarDetalle);
          die();
    }

    $components = new initComponents();
    $navegador = new navegador($payload);
    $sidebar = new sidebar($permisos);
    $footer = new footer();
    $configuracion = new configuracion($permisos);


   if (file_exists("vista/eventoVista.php")) {
   require_once("vista/eventoVista.php");
   }else {
    die("<script>window.location='?url=" .urlencode ($sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  