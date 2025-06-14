<?php 
use component\initComponents as initComponents;
use helpers\encryption as encryption;
use modelo\bitacoraModelo as bitacora;

$components = new initComponents();
$components->componentsHeader();
$components->componentsJS();
$sistem = new encryption();
$bitacora = new bitacora;
$bitacora->registrarBitacora('Login', 'La cuenta del usuario  '.$_SESSION['nombre'].' '.$_SESSION['apellido'].' se cerró por inactividad ', $_SESSION['cedula']);

    if (file_exists("vista/inactividadVista.php")) {
    require_once("vista/inactividadVista.php");
  }else {
    die("<script>window.location='?url=" . $sistem->encryptURL('login') . "'</script>");
  }
 ?>