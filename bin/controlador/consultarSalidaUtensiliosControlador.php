<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use modelo\consultarSalidaUtensiliosModelo as consultarSalidaUtensilios;

 $objeto = new consultarSalidaUtensilios;
 $sistem = new encryption();
 $permisosHelper = new permisosHelper();
 $datosPermisos = $permisosHelper->verificarPermisos($sistem, $objeto, 'Inventario de Utensilios', 'consultar');
 $permisos = $datosPermisos['permisos'];
 $payload = $datosPermisos['payload'];
 $NotificacionesServer = new NotificacionesServer();

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

 //---------------- MOSTRAR INFO EN LA TABLA
if (isset($datosPermisos['permiso']['consultar'])) {
  if (isset($_POST['mostrarSU'], $_POST['fechaInicio'], $_POST['fechaFin'])) {
    $resultado = $objeto->mostrarSalidaUtensilios($_POST['fechaInicio'], $_POST['fechaFin']);
    exit(json_encode($resultado));
  }

  if (isset($_POST['infoTipoUtensilios'], $_POST['id'])) {
    $id = $_POST['id'];

    $verificacion = $objeto->verificarExistencia($id);

    if (isset($verificacion['resultado']) && $verificacion['resultado'] === 'ya no existe') {
        exit(json_encode($verificacion));
    }

    $tipos = $objeto->tipoutensilios($id);
    exit(json_encode($tipos));
  }

  if (isset($_POST['infoUtensilios'], $_POST['idTipoU'], $_POST['idInventarioU'])) {
    $idTipoU = $_POST['idTipoU'];
    $idInventarioU = $_POST['idInventarioU'];
    $data = $objeto->utensilios($idTipoU, $idInventarioU);
    exit(json_encode($data));
  }
}
//--------ANULAR-----------------
if (isset($datosPermisos['permiso']['anular'])) {
  if (isset($_POST['valAnulacion'], $_POST['id'])) {
    $resultado = $objeto->verificarAnulacion($_POST['id']);
    exit(json_encode($resultado));
  }

  if (isset($_POST['id'], $_POST['borrar'])) {
    $resultado = $objeto->anularSalidaUtensilios($_POST['id'], false);
    echo json_encode($resultado);
    exit;
  }
}
//-----------------REPORTE-------------------

    if(isset ($_POST['reporte']) && isset ($_POST['idSalidaU'])){
      $respuesta = $objeto->fpdf($_POST['idSalidaU']);
    }

    
    if(isset ($_POST['reporte2']) &&  isset($_POST['fechaI']) && isset($_POST['fechaF'])){
      $respuesta = $objeto->fpdf2($_POST['fechaI'], $_POST['fechaF'] );
    }




  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/consultarSalidaUtensiliosVista.php")) {
   require_once("vista/consultarSalidaUtensiliosVista.php");
   }else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  