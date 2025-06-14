<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use modelo\stockUtensiliosModelo as stockUtensilios;

 $objeto = new stockUtensilios;
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

if (isset($datosPermisos['permiso']['consultar'])) {
    if (isset($_POST['mostrarS'])) {
        $resultado = $objeto->mostrarUtensilios();

        if (isset($resultado['error'])) {
            echo json_encode($resultado);
        } else {
            echo json_encode(!empty($resultado) ? $resultado : ['resultado' => 'No se encontraron utensilios.']);
        }

        exit;
    }
}

if(isset ($_POST['reporte']) ){
  $respuesta = $objeto->fpdf();
}

  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/stockUtensiliosVista.php")) {
   require_once("vista/stockUtensiliosVista.php");
   }else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  