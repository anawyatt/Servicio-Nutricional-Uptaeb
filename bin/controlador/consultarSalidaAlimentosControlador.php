<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use config\componentes\configSistema as configSistema;
 use modelo\consultarSalidaAlimentosModelo as consultarSalidaAlimentos;

 $objeto = new consultarSalidaAlimentos;
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

 //---------------- MOSTRAR INFO EN LA TABLA

if(isset($_POST['mostrarSalidaA']) && isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])){
 $mostrarTabla= $objeto->mostrarSalidaAlimentos($_POST['fechaInicio'], $_POST['fechaFin']);
}

if(isset($_POST['infoTipoAlimento']) && isset($_POST['id'])){
$verificarExistencia= $objeto->verificarExistencia( $_POST['id']);
$mostrarTipoA= $objeto->tipoalimento($_POST['id']);

}

if(isset($_POST['infoAlimento']) && isset($_POST['idTipoA']) && isset($_POST['idInventarioA'])){
$mostrarAlimento= $objeto->alimento($_POST['idTipoA'], $_POST['idInventarioA']);

}

//--------ANULAR-----------------

if (isset($_POST['valAnulacion']) && isset($_POST['id'])) {
      $verificarAnulacion= $objeto->verificarAnulacion($_POST['id']);
    }

 if (isset($_POST['id']) && isset($_POST['borrar'])) {
    $eliminar= $objeto->anularSalidaAlimento($_POST['id']);
  }

//  REPORTE DEl PDF //

    if(isset ($_POST['reporte']) && isset ($_POST['idSalidaA'])){
      $reporte1 = $objeto->fpdf($_POST['idSalidaA']);
    }

    
    if(isset ($_POST['reporte2']) &&  isset($_POST['fechaI']) && isset($_POST['fechaF'])){
      $reporte2 = $objeto->fpdf2($_POST['fechaI'], $_POST['fechaF'] );
    }




  $components = new initComponents();
  $navegador = new navegador();
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/consultarSalidaAlimentosVista.php")) {
   require_once("vista/consultarSalidaAlimentosVista.php");
   }else {
   die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
  }

  ?>
  