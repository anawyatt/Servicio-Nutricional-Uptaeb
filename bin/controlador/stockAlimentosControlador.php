<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\NotificacionesServer as NotificacionesServer;
 use component\configuracion as configuracion;
use config\componentes\configSistema as configSistema;
 use modelo\stockAlimentosModelo as stockAlimentos;

 $objeto = new stockAlimentos;
$sistem = new configSistema();
$NotificacionesServer = new NotificacionesServer();

    if (isset($_POST['notificaciones'])) {
        $valor = $NotificacionesServer->consultarNotificaciones();
    }
  
    if (isset($_POST['notificacionId'])) {
        $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
    }

 if(!isset($_SESSION['idRol'])){
 die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
}
$permisos = $objeto->getPermisosRol($_SESSION['idRol']);
 $permiso = $permisos['Inventario de Alimentos'];

    if(!isset($permiso['consultar'])) die("<script>window.location='?url=" . $sistem->encryptURL('home') . "'</script>");

 if(isset($_POST['getPermisos']) && isset($permiso['consultar'])){
   die(json_encode($permiso));
 }

 //--------- MOSTRAR TABLA

 if(isset($_POST['mostrarStock'])){
 $mostrarTabla= $objeto->mostrarAlimentos();
}

//  REPORTE DEl PDF //

    if(isset ($_POST['reporte']) ){
      $reporte = $objeto->fpdf();
    }


  $components = new initComponents();
  $navegador = new navegador();
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/stockAlimentosVista.php")) {
   require_once("vista/stockAlimentosVista.php");
   }else {
   die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
  }

  ?>
  