<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
 use component\footer as footer;
use component\configuracion as configuracion;
use modelo\AyudaModelo as Ayuda;
use component\NotificacionesServer as NotificacionesServer;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;


$objeto = new Ayuda();  
$NotificacionesServer = new NotificacionesServer();
$sistem = new encryption();
$permisosHelper = new permisosHelper();
$datosPermisos = $permisosHelper->verificarPermisos($sistem, $objeto, 'Home', 'consultar');
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


        $components = new initComponents();
        $navegador = new navegador($payload);
        $sidebar = new sidebar($permisos);
        $footer = new footer();
       $configuracion = new configuracion($permisos);

if (file_exists("vista/ayudaVista.php")) {
   require_once("vista/ayudaVista.php");
}else {
   die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}

  ?>