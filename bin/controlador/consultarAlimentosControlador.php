<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use config\componentes\configSistema as configSistema;
 use component\NotificacionesServer as NotificacionesServer;

 use modelo\consultarAlimentosModelo as consultarAlimentos;

 $objeto = new consultarAlimentos;
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

    if(!isset($permiso['consultar'])) die("<script>window.location='?url=" . $sistem->encryptURL('home') . "'</script>");

 if(isset($_POST['getPermisos']) && isset($permiso['consultar'])){
   die(json_encode($permiso));
 }

 //--------- MOSTRAR TABLA

 if(isset($_POST['mostrarAlimentos']) && isset($_POST['tipoA']) ){
 $mostrarTabla= $objeto->mostrarAlimentos($_POST['tipoA']);
}

//---------- MOSTRAR INFORMACIÓN

if(isset($_POST['infoAlimento']) && isset($_POST['id'])){
 $verificarExistencia= $objeto->verificarExistencia( $_POST['id']);
$mostrarInfo= $objeto->infoAlimento($_POST['id']);

}

// select tipo Alimentos

if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
  $validarExistenciaTA=  $objeto->verificarExistenciaTipoA($_POST['tipoA']);
   }

 if (isset($_POST['select'])) {

  $mostrarTipoA= $objeto->mostrarTipoAlimento();
}

// validat Boton

    if (isset($_POST['modificar']) && isset($_POST['id'])) {
      $verificarBoton= $objeto->verificarBoton($_POST['id']);
    }

// ------ MODIFICAR 

if ( isset($_POST['modificarINFO']) && isset($_POST['id']) && isset($_POST['tipoA']) && isset($_POST['alimento']) && isset($_POST['marca']) && isset($_POST['unidad']) ) {
   $verificarAlimento=  $objeto->verificarAlimento($_POST['id'], $_POST['tipoA'], $_POST['alimento'], $_POST['marca']);

   $modificar= $objeto->modificarAlimentos($_POST['id'], $_POST['tipoA'], $_POST['alimento'], $_POST['marca'], $_POST['unidad']);

   }


   if (isset($_FILES['imagen']['tmp_name']) && isset($_POST['id'])) {
 $modificar= $objeto->modificarImagen($_FILES['imagen']['tmp_name'], $_POST['id']);
 ;
}

//--------ANULAR-----------------

 if (isset($_POST['id']) && isset($_POST['borrar'])) {
    $anular= $objeto->anularAlimento($_POST['id']);
  }





  $components = new initComponents();
  $navegador = new navegador();
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/consultarAlimentosVista.php")) {
   require_once("vista/consultarAlimentosVista.php");
   }else {
    die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
  }

  ?>
  