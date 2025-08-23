<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use config\componentes\configSistema as configSistema;
 use modelo\registrarEntradaAlimentosModelo as registrarEntradaAlimentos;

 $objeto = new registrarEntradaAlimentos;
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

    if(!isset($permiso['registrar'])) die("<script>window.location='?url=" . $sistem->encryptURL('home') . "'</script>");

 if(isset($_POST['getPermisos']) && isset($permiso['registrar'])){
   die(json_encode($permiso));
 }

 if (isset($_POST['select'])) {
  $mostrarTipoA= $objeto->mostrarTipoAlimento();
  }

 if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
  $validarExistenciaTA=  $objeto->verificarExistenciaTipoA($_POST['tipoA']);
   }

if (isset($_POST['select2']) && isset($_POST['tipoA'])) {
  $mostrarAlimento= $objeto->mostrarAlimento( $_POST['tipoA']);
  }
 

  if (isset($_POST['valida2']) && isset($_POST['alimento'])) {
  $validarExistenciaA=  $objeto->verificarExistenciaAlimento($_POST['alimento']);
   }


  if (isset($_POST['muestra']) && isset($_POST['idAlimento'])) {
  $infoAlimento= $objeto->infoAlimento( $_POST['idAlimento']);
  }

  //------------------- REGISTRAR -----------------------
 if(isset($_POST['registrar']) && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['descripcion']) ){
    $registrarA= $objeto->registrarEntradaA($_POST['fecha'], $_POST['hora'] , $_POST['descripcion']);
   
 }

 if(isset($_POST['alimento'])  && isset($_POST['cantidad'])  && isset($_POST['id']) ){
        $registrarDetalle= $objeto->registrarDetalleEntradaA($_POST['alimento'], $_POST['cantidad'] , $_POST['id'] );
   
 }


  $components = new initComponents();
  $navegador = new navegador();
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/registrarEntradaAlimentosVista.php")) {
   require_once("vista/registrarEntradaAlimentosVista.php");
   }else {
  die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
  }

  ?>
  