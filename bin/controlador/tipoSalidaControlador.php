<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;
use component\configuracion as configuracion;
use helpers\encryption as encryption;
use modelo\tipoSalidaModelo as tipoSalida;
use helpers\permisosHelper as permisosHelper;
use helpers\csrfTokenHelper;
use middleware\csrfMiddleware;
use middleware\PostRateMiddleware as PostRateMiddleware;

$objeto = new tipoSalida;
$sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Tipos de Salidas', 'consultar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }



$tokenCsrf = csrfTokenHelper::generateCsrfToken($payload->cedula);

if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
  $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
  echo json_encode(['message' => 'Token renovado', 'newCsrfToken' => $resultadoToken['newToken']]);
  die();
}

//registrar

if (isset($_POST['tipoS'])) {
  $validar = $objeto->verificarTipoSalida($_POST['tipoS']);
    if ($validar['resultado'] === 'error tipo') {
        echo json_encode($validar);
        die();
    }
}


if (isset($_POST['registrar']) && isset($_POST['tipoS']) && $datosPermisos['permiso']['registrar']) {
  PostRateMiddleware::verificar('registrar', (array)$payload);
  $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
  $registrar = $objeto->registrarTipoSalida($_POST['tipoS']);
  echo json_encode(['mensaje' => $registrar,'newCsrfToken' => $csrf['newToken']]);
  die();
}

// Consultar


if (isset($_POST['muestra'], $_POST['tabla'])) {
  $mostrar = $objeto->tabla();
}

if (isset($_POST['modificar']) && isset($_POST['id'])) {
  
  $verificarModificacion = $objeto->verificarModificacion($_POST['id']);
  echo json_encode($verificarModificacion);
  die();
 
}


// Modificar

if (isset($_POST['mostrar']) && isset($_POST['id'])) {
  $mostrarInfo = $objeto->mostrarTipoS($_POST['id']);
  echo json_encode($mostrarInfo);
  die();
}

//-------- MODIFICAR -----------------------------------------

if (isset($_POST['tipoS2']) && isset($_POST['id']) && $datosPermisos['permiso']['modificar']) {
    PostRateMiddleware::verificar('modificar', (array)$payload);
    $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
    $verificarExistencia = $objeto->verificarExistencia($_POST['id']);
    $verficar = $objeto->verificarTipoS2($_POST['tipoS2'], $_POST['id']);
        if ($verificarExistencia !== null) {
        echo json_encode($verificarExistencia);
        die();
    }

    if ($verficar['resultado'] !== 'ok') {
        echo json_encode($verficar);
        die();
    }

    $modificar = $objeto->modificarTipoSalida($_POST['tipoS2'], $_POST['id']);
    echo json_encode($modificar);
    die();
}


//-------- ANULAR -----------------------------------------
if (isset($_POST['id']) && isset($_POST['borrar'])  && $datosPermisos['permiso']['eliminar']) {
  PostRateMiddleware::verificar('anular', (array)$payload);
  $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
  $verificarExistencia = $objeto->verificarExistencia($_POST['id']);
  $anular = $objeto->anularTipoSalida($_POST['id']);
  echo json_encode(['mensaje' => $anular, 'newCsrfToken' => $csrf['newToken']]);
  die();
}


$components = new initComponents();
$navegador = new navegador($payload);
$sidebar = new sidebar($permisos);
$footer = new footer();
$configuracion = new configuracion($permisos);


if (file_exists("vista/tipoSalidaVista.php")) {
  require_once("vista/tipoSalidaVista.php");
} else {
  die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
