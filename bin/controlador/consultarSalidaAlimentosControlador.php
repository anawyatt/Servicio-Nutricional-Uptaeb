<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use modelo\consultarSalidaAlimentosModelo as consultarSalidaAlimentos;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;
 use middleware\PostRateMiddleware as PostRateMiddleware;

 $objeto = new consultarSalidaAlimentos;
 $sistem = new encryption();
 $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Inventario de Alimentos', 'consultar');
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

  if (!isset($payload->cedula)) {
            echo json_encode(['error' => 'Cédula no encontrada en el token']);
            exit;
        }

if (isset($datosPermisos['permiso']['consultar'])) {
 //---------------- MOSTRAR INFO EN LA TABLA

if(isset($_POST['mostrarSalidaA']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])){
 try {
      $mostrarTabla= $objeto->mostrarSalidaAlimentos($_POST['fechaInicio'], $_POST['fechaFin']);
      echo json_encode($mostrarTabla);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
}

if(isset($_POST['infoTipoAlimento']) && isset($_POST['id'])){
try {
      $verificarExistencia= $objeto->verificarExistencia( $_POST['id']);
      if ($verificarExistencia['resultado'] == 'ya no existe') { 
       echo json_encode($verificarExistenciaTA);
       die();
      }
      $mostrarTipoA= $objeto->tipoalimento($_POST['id']);
       echo json_encode($mostrarTipoA);
       die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }

}

if(isset($_POST['infoAlimento']) && isset($_POST['idTipoA']) && isset($_POST['idInventarioA'])){
try {
      $mostrarAlimento= $objeto->alimento($_POST['idTipoA'], $_POST['idInventarioA']);
      echo json_encode($mostrarAlimento);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
}
}

if (isset($datosPermisos['permiso']['eliminar'])) {
//--------ANULAR-----------------

if (isset($_POST['valAnulacion']) && isset($_POST['id'])) {
   try {
      $verificarAnulacion= $objeto->verificarAnulacion($_POST['id']); 
       echo json_encode($verificarAnulacion);
       die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
 }

 if (isset($_POST['id']) && isset($_POST['borrar'])  && isset($_POST['csrfToken'])) {
     try {
      PostRateMiddleware::verificar('anular', (array)$payload);
      $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
      $eliminar= $objeto->anularSalidaAlimento($_POST['id']);
      echo json_encode(['mensaje'=>$eliminar, 'newCsrfToken' => $csrf['newToken']]);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
  }

}

//  REPORTE DEl PDF //

    if(isset ($_POST['reporte']) && isset ($_POST['idSalidaA'])){
      $reporte1 = $objeto->fpdf($_POST['idSalidaA']);
    }

    
    if(isset ($_POST['reporte2']) &&  isset($_POST['fechaI']) && isset($_POST['fechaF'])){
      $reporte2 = $objeto->fpdf2($_POST['fechaI'], $_POST['fechaF'] );
    }




  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/consultarSalidaAlimentosVista.php")) {
   require_once("vista/consultarSalidaAlimentosVista.php");
   }else {
   die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login') ). "'</script>");
  }

  ?>
  