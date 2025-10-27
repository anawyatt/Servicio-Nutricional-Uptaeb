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
use modelo\asistenciaModelo as asistencia;
use component\NotificacionesServer as NotificacionesServer;


$objeto = new asistencia;
$sistem = new encryption();
$NotificacionesServer = new NotificacionesServer();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Asistencias', 'registrar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

if (isset($payload->cedula)) {
        $NotificacionesServer->setCedula($payload->cedula);
    } else {
        die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
    }

    if (isset($_POST['notificaciones'])) {
        $valor = $NotificacionesServer->consultarNotificaciones();
    }
  
    if (isset($_POST['notificacionId'])) {
        $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
    }

  $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);


if (isset($_POST['verEstudiantes']) && isset($datosPermisos['permiso']['consultar'])) {
  $id = $_POST['id'];
  $InfoEstudiantes = $objeto->infoStudy($id);
  echo json_encode($InfoEstudiantes);
  die();
}


if (isset($_POST['vermenu']) && isset($datosPermisos['permiso']['consultar'])) {
  try {
    $VerMenu = $objeto->obtenerIdMenu($_POST['horario']);
    echo json_encode($VerMenu);
  } catch (Exception $e) {
    echo json_encode([
      'status' => 'error',
      'message' => 'Ocurrió un error al obtener el menú.',
      'error' => $e->getMessage()
    ]);
  }
  die();
}



if (isset($_POST['verPlatosDisponibles']) && isset($_POST['horarioComida']) && isset($datosPermisos['permiso']['consultar'])) {
  $Verplato = $objeto->platosDisponibles($_POST['horarioComida']);
  echo json_encode($Verplato);
  die();
}


if (isset($_POST['verificar']) && isset($_POST['horarioComida']) && isset($_POST['id']) && isset($datosPermisos['permiso']['consultar'])) {
  $Validar = $objeto->verificarAsistenciaEstudiante($_POST['horarioComida'], $_POST['id']);
  echo json_encode($Validar);
  die();
}

if (isset($_POST['verificar']) && isset($_POST['id']) && isset($datosPermisos['permiso']['consultar'])) {
  $Validar = $objeto->verificarPorHorario($_POST['id']);
  echo json_encode($Validar);
  die();
}

if (isset($_POST['registrar']) && isset($_POST['id']) && isset($_POST['idmenu']) && isset($_POST['csrfToken']) && isset($datosPermisos['permiso']['registrar'])) {
  $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
  $registrar = $objeto->registrarAsistencia($_POST['id'], $_POST['idmenu']);
  echo json_encode(['mensaje'=>$registrar, 'newCsrfToken' => $csrf['newToken']]);
  die();
}


if (isset($_POST['verificarcodigo'])) {
  $codigoIngresado = $_POST['codigoIngresado'];
  $codigo = $payload->cedula;
  $correcto = $objeto->verificarCodigo($codigoIngresado, $codigo);
  echo json_encode(['correcto' => $correcto]);
  die();
}


/* EXCEPCION 1 */

if (isset($_POST['mostrarC']) && isset($_POST['cedula'])) {
  $validarCedula = $objeto->verificarCedula($_POST['cedula']);
  if ($validarCedula['resultado'] === 'error cedula') {
   echo json_encode($validarCedula);
   die();
  }
  
}

if (isset($_POST['select3'])) {
  $MostrarNucleo = $objeto->mostrarNucleo();
  echo json_encode($MostrarNucleo);
  die();
}
if (isset($_POST['select2'])) {
  $MostrarCarrera = $objeto->mostrarCarreras();
  echo json_encode($MostrarCarrera);
  die();
}
if (isset($_POST['select'])) {
  $MostrarSeccion = $objeto->mostrarSeciones();
  echo json_encode($MostrarSeccion);
  die();
}

if (isset($_POST['mostrarHorario']) && isset($_POST['seccion'])) {
  $mostrarHorario = $objeto->mostrarHorarios($_POST['seccion']);
  echo json_encode($mostrarHorario);
  die();
}


if (isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['sexo']) && isset($_POST['nucleo']) && isset($_POST['carrera']) && isset($_POST['seccion']) && isset($_POST['seccion2']) && isset($_POST['justificativo']) && isset($_POST['csrfToken']) && isset($_POST['excepcion1'])) {
  $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
  $registrar = $objeto->registrarStudyExcepcion1($_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['sexo'], $_POST['nucleo'], $_POST['carrera'], $_POST['seccion'], $_POST['seccion2'], $_POST['justificativo']);
  echo json_encode(['mensaje'=> $registrar, 'newCsrfToken' => $csrf['newToken']]);
  die();
}




/* EXCEPCION 2 */

if (isset($_POST['mostrarCed']) && isset($_POST['cedula'])) {
  $validarCedula = $objeto->verificarExistenciaEstudiante($_POST['cedula']);
  if ($validarCedula['resultado'] == 'error Cedula') {
   echo json_encode($validarCedula);
   die();
  }
}

if (isset($_POST['verificar']) && isset($_POST['horarioComida']) && isset($_POST['cedula'])) {
  $Validar = $objeto->verificarAsistenciaEstudiante2($_POST['horarioComida'], $_POST['cedula']);
  if($Validar['resultado'] === 'ya ingreso al comedor2') {
    echo json_encode($Validar);
    die();
  }
}

if (isset($_POST['excepcion2']) && isset($_POST['cedula']) && isset($_POST['idmenu']) && isset($_POST['justificativo']) && isset($_POST['csrfToken'])  ) {
  $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
  $registrar = $objeto->registrarStudyExcepcion2($_POST['cedula'],  $_POST['idmenu'], $_POST['justificativo']);
  if($registrar['resultado'] === 'registro del Estudiante 2') {
    echo json_encode(['mensaje'=>$registrar, 'newCsrfToken' => $csrf['newToken']]);
    die();
  }
}


$components = new initComponents();
$navegador = new navegador($payload);
$configuracion = new configuracion($permisos);
$sidebar = new sidebar($permisos);
$footer = new footer();


if (file_exists("vista/asistenciaVista.php")) {
  require_once("vista/asistenciaVista.php");
} else {
   die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
