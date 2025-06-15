<?php

    use component\initComponents as initComponents;
    use component\navegador as navegador;
    use component\sidebar as sidebar;
    use component\footer as footer;
    use component\configuracion as configuracion;
    use helpers\encryption as encryption;
    use helpers\permisosHelper as permisosHelper;
    use component\NotificacionesServer as NotificacionesServer;
    use middleware\PostRateMiddleware as PostRateMiddleware;
    use helpers\csrfTokenHelper;
    use middleware\csrfMiddleware;
    use modelo\consultarMenuModelo as consultarMenu;

    $object = new consultarMenu;
    $sistem = new encryption();
    $NotificacionesServer = new NotificacionesServer();

    $datosPermisos = permisosHelper::verificarPermisos($sistem, $object, 'Menú', 'consultar');
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
    
    if(isset($_POST['mostrarMenu']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])){
      $mostrarT= $object->mostrarM($_POST['fechaInicio'], $_POST['fechaFin']);
      echo json_encode($mostrarT);
      die();
    }

      //---------------- MOSTRAR INFO ----------------

        if(isset($_POST['infoMenu']) && isset($_POST['id']) && isset($datosPermisos['permiso']['consultar'])){
       $verificarExistencia= $object->verificarExistencia( $_POST['id']);

         if (isset($verificarExistencia['resultado']) && $verificarExistencia['resultado'] === 'si existe') {
            $mostrarMenu = $object->menu($_POST['id']);
            echo json_encode($mostrarMenu);
            die();
        } else {
            echo json_encode($verificarExistencia); 
            die();
        }
    }
    

        if(isset($_POST['infoAlimento']) && isset($_POST['idTipoA']) && isset($_POST['idMenu'])
        && isset($datosPermisos['permiso']['consultar'])){
          $mostrarAlimento= $object->alimento($_POST['idTipoA'] , $_POST['idMenu']); 
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
        
        

        if (isset($datosPermisos['permiso']['modificar']) && isset($_POST['feMenu']) && isset($_POST['horarioComida']) && isset($_POST['cantPlatos']) && isset($_POST['descripcion'])
         && isset($_POST['id']) && isset($_POST['idSalidaA'])&& isset($_POST['csrfToken'])) {
            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

           PostRateMiddleware::verificar('modificar', (array)$payload); 

          $modificarM = $object->modificarMenu($_POST['feMenu'], $_POST['horarioComida'], 
          $_POST['cantPlatos'], $_POST['descripcion'], $_POST['id'], $_POST['idSalidaA']);
            if (!isset($modificarM['resultado']) || $modificarM['resultado'] !== 'Menú Actualizado Exitosamente') {

              echo json_encode([
                  'resultado' => 'error',
                  'mensaje' => $modificarM,
                  'newCsrfToken' => $csrf['newToken']
              ]);
              die();
          }

          echo json_encode([
              'resultado' => 'exitoso',
              'menuId' => $modificarM['menuId'],
              'salidaId' => $modificarM['salidaId'],
              'newCsrfToken' => $csrf['newToken']
          ]);
          die();

        }

      if (isset($_POST['cantidad']) && isset($_POST['idMenu']) && isset($_POST['alimento']) && isset($_POST['idSalidaA'])) {
        $modificarDSM = $object->detalleSalidaM($_POST['cantidad'], $_POST['idMenu'], $_POST['alimento'], $_POST['idSalidaA']);
        echo json_encode($modificarDSM);
        die();
      }

      if (isset($_POST['id']) && !isset($_POST['borrar'])) {
          $verificarAnulacion = $object->verificarAnulacion($_POST['id']);
          if (isset($verificarAnulacion['resultado']) && $verificarAnulacion['resultado'] === 'no se puede') {
              echo json_encode($verificarAnulacion);
          } else {
              echo json_encode(['resultado' => 'se puede']);
          }
          die();
      }

        if (isset($_POST['id']) && isset($_POST['borrar'])  && isset($_POST['csrfToken']) && isset($datosPermisos['permiso']['eliminar'])) {

            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);

        PostRateMiddleware::verificar('anular', (array)$payload); 
        $eliminar = $object->eliminarMenu($_POST['id']);

         echo json_encode(['resultado' => $eliminar['resultado'],  'newCsrfToken' => $csrf['newToken']]);
        die();
          } 
    

  
        //  REPORTE DEl PDF //
        if(isset ($_POST['reporte']) && isset ($_POST['idMenu'])){
            $respuesta = $object->fpdf($_POST['idMenu']);
            echo json_encode($respuesta);
            die();
        }

  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/consultarMenuVista.php")) {
   require_once("vista/consultarMenuVista.php");
   }else {
    die("<script>window.location='?url=" .urlencode($sistem->encryptURL('login')) . "'</script>");
  }

?>
  