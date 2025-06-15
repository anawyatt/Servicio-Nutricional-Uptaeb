<?php

    use component\initComponents as initComponents;
    use component\navegador as navegador;
    use component\sidebar as sidebar;
    use component\footer as footer;
    use component\configuracion as configuracion;
    use helpers\encryption as encryption;
    use helpers\permisosHelper as permisosHelper;
    use modelo\consultarEventosModelo as consultarEventos;
    use component\NotificacionesServer as NotificacionesServer;
    use middleware\PostRateMiddleware as PostRateMiddleware;
    use helpers\csrfTokenHelper;
    use middleware\csrfMiddleware;

    $object = new consultarEventos;
    $sistem = new encryption();
    $NotificacionesServer = new NotificacionesServer();

    $datosPermisos = permisosHelper::verificarPermisos($sistem, $object, 'Eventos', 'consultar');
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
  
    if(isset($_POST['mostrarEvento']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])){
      $mostrarT= $object->mostrarE($_POST['fechaInicio'], $_POST['fechaFin']);
      echo json_encode($mostrarT);
      die();
    }

    //---------------- MOSTRAR INFO ----------------

    if (isset($_POST['infoEvento']) && isset($_POST['id']) && isset($datosPermisos['permiso']['consultar'])) {
      $verificarExistencia = $object->verificarExistencia($_POST['id']);

      if (isset($verificarExistencia['resultado']) && $verificarExistencia['resultado'] === 'si existe') {
          $mostrarE = $object->evento($_POST['id']);
          echo json_encode($mostrarE);
          die();
      } else {
          echo json_encode($verificarExistencia); 
          die();
      }
    }


      if(isset($_POST['infoAlimento']) && isset($_POST['idTipoA']) && isset($_POST['idEvento'])){
        $mostrarAlimento= $object->alimento($_POST['idTipoA'] , $_POST['idEvento']); 
        echo json_encode($mostrarAlimento);
        die();
      }

  //----------Modificar
      if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
          $validarExistenciaTA=  $object->verificarExistenciaTipoA($_POST['tipoA']);
          if(isset($validarExistenciaTA['resultado']) && $validarExistenciaTA['resultado'] === 'no esta'){
            echo json_encode($validarExistenciaTA);
            die();
          }
        }

      if (isset($_POST['select'])) {
          $mostrarTipoA = $object->mostrarTipoAlimento();
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
        $mostrarAlimento = $object->mostrarAlimento( $_POST['tipoA']);
        echo json_encode($mostrarAlimento);
        die();
      }
      
      if (isset($_POST['muestra']) && isset($_POST['idAlimento']) && isset($datosPermisos['permiso']['consultar'])) {
          $infoAlimento = $object->infoAlimento( $_POST['idAlimento']);
          echo json_encode($infoAlimento);
          die();
      }

      if ( isset($_POST['id'])) {
          $verificarModi = $object->verificarModificacion($_POST['id']);
          if(isset($verificarModi['resultado']) && $verificarModi['resultado'] === 'no se puede'){
          echo json_encode($verificarModi);
          die();
          }
        }

        if (isset($_POST['validar']) && isset($_POST['feMenu']) && isset($_POST['horarioComida'])
         && isset($_POST['id'])) {
          $validarFH= $object->validarFH( $_POST['feMenu'], $_POST['horarioComida'], $_POST['id']);
          if(isset($validarFH['resultado']) && $validarFH['resultado'] === 'error'){
          echo json_encode($validarFH);
          die();
          }
        }

       
      if (isset($_POST['feMenu']) && isset($_POST['cantPlatos']) && isset($_POST['nomEvent']) 
        && isset($_POST['descripEvent']) && isset($_POST['horarioComida']) && isset($_POST['descripcion'])
        && isset($_POST['id']) && isset($_POST['idSalidaA']) && isset($_POST['idMenu']) 
        && isset($datosPermisos['permiso']['modificar'])  && isset($_POST['csrfToken']) ) {

            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

            PostRateMiddleware::verificar('modificar', (array)$payload); 
          
        $modificarE = $object->modificarEven($_POST['feMenu'],  $_POST['cantPlatos'], $_POST['nomEvent'],
        $_POST['descripEvent'], $_POST['horarioComida'],  $_POST['descripcion'], $_POST['id'], 
        $_POST['idSalidaA'], $_POST['idMenu']);
        echo json_encode(['mensaje' => $modificarE, 'newCsrfToken' => $csrf['newToken']]);
        die();
      }

      if (isset($_POST['cantidad']) && isset($_POST['idMenu']) && isset($_POST['alimento']) 
        && isset($_POST['idSalidaA'])) {
        $modificarDSE = $object->detalleSalidaE($_POST['cantidad'], $_POST['idMenu'], $_POST['alimento'], 
        $_POST['idSalidaA']);
        echo json_encode($modificarDSE);
        die();
      }

  

    //--------ANULAR-----------------
     if (isset($_POST['id']) && !isset($_POST['borrar'])) {
          $verificarAnulacion = $object->verificarAnulacion($_POST['id']);
          if (isset($verificarAnulacion['resultado']) && $verificarAnulacion['resultado'] === 'no se puede') {
              echo json_encode($verificarAnulacion);
          } else {
              echo json_encode(['resultado' => 'se puede']);
          }
          die();
      }
  
    if(isset($_POST['id']) && isset($_POST['borrar']) && isset($datosPermisos['permiso']['eliminar']) 
    && isset($_POST['csrfToken'])) {

             $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

          PostRateMiddleware::verificar('anular', (array)$payload); 
          $eliminar = $object->eliminarEvento($_POST['id']);
          echo json_encode(['mensaje' => $eliminar, 'newCsrfToken' => $csrf['newToken']]);
          die();
    }
  
    //  REPORTE DEl PDF //
    if(isset ($_POST['reporte']) && isset ($_POST['idEvento'])){
      $respuesta = $object->fpdf($_POST['idEvento']);
      echo json_encode($respuesta);
      die();
    }


  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/consultarEventoVista.php")) {
   require_once("vista/consultarEventoVista.php");
   }else {
    die("<script>window.location='?url=" .urlencode($sistem->encryptURL('login')). "'</script>");
 }

?>
  