<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use component\NotificacionesServer as NotificacionesServer;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use modelo\consultarEntradaUtensiliosModelo as consultarEntradaUtensilios;

 $objeto = new consultarEntradaUtensilios;
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


if (isset($_POST['mostrarEU'], $_POST['fechaInicio'], $_POST['fechaFin'])) {
  $mostrarTabla = $objeto->mostrarEntradaUtensilios($_POST['fechaInicio'], $_POST['fechaFin']);
  exit(json_encode($mostrarTabla));
}
 
if (isset($datosPermisos['permiso']['consultar'])) {
  if (isset($_POST['infoTipoUtensilio'], $_POST['id'])) {
    $verificacion = $objeto->verificarExistencia($_POST['id']);
    
    if ($verificacion === null) {
        $tipos = $objeto->tipoutensilios($_POST['id']);
        exit(json_encode($tipos));
    } else {
        exit(json_encode($verificacion));
    }
  }

  if (isset($_POST['infoUtensilio'], $_POST['idTipoU'], $_POST['idInventarioU'])) {
    $utensilios = $objeto->utensilios($_POST['idTipoU'], $_POST['idInventarioU']);
    exit(json_encode($utensilios));
  }
}
 //--------ANULAR-----------------

if (isset($datosPermisos['permiso']['anular'])) {
  if (isset($_POST['valAnulacion'], $_POST['id'])) {
    $resultado = $objeto->verificarAnulacion($_POST['id']);
    exit(json_encode($resultado));
  }

  
  if (isset($_POST['id'], $_POST['borrar'])) {
    $resultado = $objeto->anularEntradaUtensilios($_POST['id']);
    exit(json_encode($resultado));
  }
}
//-----------------REPORTE-------------------

  if(isset ($_POST['reporte']) && isset ($_POST['idEntradaU'])){
    $reporte1 = $objeto->fpdf($_POST['idEntradaU']);
  }

  if(isset ($_POST['reporte2']) &&  isset($_POST['fechaI']) && isset($_POST['fechaF'])){
    $reporte2 = $objeto->fpdf2($_POST['fechaI'], $_POST['fechaF'] );
  }



  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/consultarEntradaUtensiliosVista.php")) {
   require_once("vista/consultarEntradaUtensiliosVista.php");
   }else {
    die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  