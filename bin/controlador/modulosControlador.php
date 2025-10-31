<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\configuracion as configuracion;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;
use component\footer as footer;
use modelo\ModulosModelo as Modulo;
/* Modelo */

$obj_modulo = new Modulo();
$sistem = new encryption();

$datosPermisos = permisosHelper::verificarPermisos($sistem, $obj_modulo, 'Modulos', 'consultar');

$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

 if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }


if (isset($_POST['mostrar'])) {
    $obj_modulo->mostrarModulosAjax();
}

// seleccionar
if (isset($_POST['select'])) {
    $idmulos= $obj_modulo->getModulo($_POST['id']);
    echo json_encode($idmulos);
    die();
}

//modificar
if (isset($_POST['nombreEdit']) && isset($_POST['id'])  && isset($datosPermisos['permiso']['modificar'])) {
    $respuesta = $obj_modulo->editarModulo($_POST['nombreEdit'], $_POST['id']);
}



$components = new initComponents();
$navegador = new navegador($payload);
$sidebar = new sidebar($permisos);
$configuracion = new configuracion($permisos);
$footer = new footer();



if (file_exists("vista/modulosVista.php")) {
    require_once("vista/modulosVista.php");
} else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}
