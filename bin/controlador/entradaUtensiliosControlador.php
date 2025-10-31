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
 use modelo\entradaUtensiliosModelo as entradaUtensilios;

 $objeto = new entradaUtensilios;
 $sistem = new encryption();
 $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Inventario de Utensilios', 'consultar');
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
  if (isset($_POST['select'])) {
    $mostrarTipoU = $objeto->mostrarTipoUtensilio();
    exit(json_encode($mostrarTipoU));
  }

  if (isset($_POST['valida']) && isset($_POST['tipoU'])) {
    $validarExistenciaTU = $objeto->verificarExistenciaTipoU($_POST['tipoU']);
    exit(json_encode($validarExistenciaTU));
  }

  if (isset($_POST['valida2']) && isset($_POST['utensilio'])) {
    $validarExistenciaU = $objeto->verificarExistenciaUtensilio($_POST['utensilio']);
    exit(json_encode($validarExistenciaU));
  }

  if (isset($_POST['select2']) && isset($_POST['tipoU'])) {
    $mostrarUtensilio = $objeto->mostrarUtensilio($_POST['tipoU']);
    exit(json_encode($mostrarUtensilio));
  }

  if (isset($_POST['muestra']) && isset($_POST['idUtensilio'])) {
    $infoUtensilio = $objeto->infoUtensilio($_POST['idUtensilio']);
    exit(json_encode($infoUtensilio));
  }
}

// ------------------- REGISTRAR -----------------------
if (isset($datosPermisos['permiso']['registrar'])) {
  if (isset($_POST['registrar'], $_POST['fecha'], $_POST['hora'], $_POST['descripcion'], $_POST['csrfToken'])) {
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $registrarU = $objeto->registrarEntradaU($_POST['fecha'], $_POST['hora'], $_POST['descripcion']);
    echo json_encode(['mensaje'=> $registrarU, 'newCsrfToken' => $csrf['newToken']]);
    exit();
  }

  if (isset($_POST['utensilio'], $_POST['cantidad'], $_POST['id'])) {
    $registrarDetalle = $objeto->registrarDetalleEntradaU($_POST['utensilio'], $_POST['cantidad'], $_POST['id']);
    exit(json_encode($registrarDetalle));
  }
}
  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);


   if (file_exists("vista/entradaUtensiliosVista.php")) {
   require_once("vista/entradaUtensiliosVista.php");
   }else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  