<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;
 use component\configuracion as configuracion;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use helpers\csrfTokenHelper;
 use middleware\csrfMiddleware;


 use modelo\salidaUtensiliosModelo as salidaUtensilios;

 $objeto = new salidaUtensilios;
 $sistem = new encryption();
 $permisosHelper = new permisosHelper();
 $datosPermisos = $permisosHelper->verificarPermisos($sistem, $objeto, 'Inventario de Utensilios', 'consultar');
 $permisos = $datosPermisos['permisos'];
 $payload = $datosPermisos['payload'];

 if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }


 $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
    $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
    echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
    die();
}

if (isset($datosPermisos['permiso']['consultar'])) { 
  if (isset($_POST['valida']) && isset($_POST['tipoU'])) {
    $resultado = $objeto->verificarExistenciaTipoU($_POST['tipoU']);
    echo json_encode($resultado);
    exit;
  }

  if (isset($_POST['select'])) {
    $resultado = $objeto->mostrarTipoUtensilio();
    echo json_encode($resultado);
    exit;
  }


  if (isset($_POST['valida2']) && isset($_POST['utensilio'])) {
    $resultado = $objeto->verificarExistenciaUtensilio($_POST['utensilio']);
    echo json_encode($resultado);
    exit;
  }



  if (isset($_POST['select2']) && isset($_POST['tipoU'])) {
    $resultado = $objeto->mostrarUtensilios($_POST['tipoU']);
    echo json_encode($resultado);
    exit;
  }



  if (isset($_POST['valida3']) && isset($_POST['tipoS'])) {
    $resultado = $objeto->verificarExistenciaTipoS($_POST['tipoS']);
    echo json_encode($resultado);
    exit;
  }

  if (isset($_POST['select3'])) {
    $resultado = $objeto->mostrarTipoSalida();
    echo json_encode($resultado);
    exit;
  }


  if (isset($_POST['muestra']) && isset($_POST['idUtensilios'])) {
    $infoUtensilio = $objeto->infoUtensilio($_POST['idUtensilios']);
    echo json_encode($infoUtensilio);
    exit;
  }
}
  //------------------- REGISTRAR -----------------------
if (isset($datosPermisos['permiso']['registrar'])) {
  if (isset($_POST['registrar']) && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['tipoS']) && isset($_POST['descripcion']) && isset($_POST['csrfToken'])) {
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);  
    $registrarU = $objeto->registrarSalidaU($_POST['fecha'], $_POST['hora'], $_POST['tipoS'], $_POST['descripcion']);
      echo json_encode(['mensaje'=>$registrarU, 'newCsrfToken' => $csrf['newToken']]);
      exit;
  }

  if (isset($_POST['utensilio']) && isset($_POST['cantidad']) && isset($_POST['id'])) {
      $registrarDetalle = $objeto->registrarDetalleSalidaU($_POST['utensilio'], $_POST['cantidad'], $_POST['id']);
      echo json_encode($registrarDetalle);
      exit;
  }
}


  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/salidaUtensiliosVista.php")) {
   require_once("vista/salidaUtensiliosVista.php");
   }else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  