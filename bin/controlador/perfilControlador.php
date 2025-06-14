<?php
 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\NotificacionesServer as NotificacionesServer;
 use config\componentes\configSistema as configSistema;
 use component\configuracion as configuracion;
 use modelo\perfilModelo as perfil;

 $objet = new perfil(); 
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
$permisos = $objet->getPermisosRol($_SESSION['idRol']);


    if(isset($_POST['info'])){
        $respuesta =  $objet->informacionUsuario($_SESSION['cedula']);
            echo json_encode(['mensaje' => $respuesta]); 
    }

    if(isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo'])){

      $respuesta = $objet->editarPerfil( $_POST['nombre'], $_POST['apellido'], $_POST['correo']);
    }

    if (isset($_POST['nuevaClave']) && isset($_POST['repetirClave'])) {
      // Modo normal de cambio de contraseña
      if (isset($_POST['clave'])) {
          $respuesta2 = $objet->cambiarContraseña($_POST['clave'], $_POST['nuevaClave'], $_POST['repetirClave']);
      } else {
          // Modo de recuperación de contraseña (sin contraseña antigua)
          $respuesta2 = $objet->cambiarContraseña(null, $_POST['nuevaClave'], $_POST['repetirClave']);
      }
  }
  

 
    if(isset($_POST['borrar'])){
      $objet->eliminarImagen();
    }
    
     if (isset($_POST['accion']) == 'imagenPerfil') {
       if (isset($_FILES['imagen']['tmp_name'])) {
             $objet->editarImagen($_FILES['imagen']['tmp_name']);
    
       } 
    }


        $components = new initComponents();
        $navegador = new navegador();
        $sidebar = new sidebar($permisos);
        $configuracion = new configuracion($permisos);

   if (file_exists("vista/perfilVista.php")) {
   require_once("vista/perfilVista.php");
   }else {
    die("<script>window.location='?url=" . $sistem->encryptURL('perfil') . "'</script>");
  }

  ?>