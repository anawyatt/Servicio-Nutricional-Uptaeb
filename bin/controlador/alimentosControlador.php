<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use config\componentes\configSistema as configSistema;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;

 use modelo\alimentosModelo as alimentos;

 $objeto = new alimentos;
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
 $permiso = $permisos['Alimentos'];

    if(!isset($permiso['registrar']))  die("<script>window.location='?url=" . $sistem->encryptURL('home') . "'</script>");
 if(isset($_POST['getPermisos']) && isset($permiso['registrar'])){
   die(json_encode($permiso));
 }
/// ---------------------------------------------------------------------------------------
 
 if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
  $validarExistenciaTA=  $objeto->verificarExistenciaTipoA($_POST['tipoA']);
   }

 if (isset($_POST['select'])) {
  $mostrarTipoA= $objeto->mostrarTipoAlimento();
 }

if ( isset($_POST['tipoA']) && isset($_POST['alimento']) && isset($_POST['marca'])) {
  $verificarAlimento=  $objeto->verificarAlimento($_POST['tipoA'], $_POST['alimento'], $_POST['marca']);
   }

if (isset($_POST['men']) && isset($_POST['tipoA']) && isset($_POST['alimento']) && isset($_POST['marca']) && isset($_POST['unidad'])) {
    $imagen = isset($_FILES['imagen']['tmp_name']) ? $_FILES['imagen']['tmp_name'] : null;
    $registrar = $objeto->registrarAlimento($imagen, $_POST['men'], $_POST['tipoA'], $_POST['alimento'], $_POST['marca'], $_POST['unidad']);
}


  $components = new initComponents();
  $navegador = new navegador();
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/alimentosVista.php")) {
   require_once("vista/alimentosVista.php");
   }else {
    die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
  }

  ?>
  