<?php
use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\configuracion as configuracion;
use component\cardysHome as cardysHome;
use modelo\homeModelo as home;
use component\footer as footer;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;
use helpers\JwtHelpers; 

$objModel = new home;
$sistem = new encryption();


$datosPermisos = permisosHelper::verificarPermisos($sistem, $objModel, 'Home', 'consultar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

        if (!$payload->cedula) {
             die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
        }




if(isset($payload->horario_comida)){
$objModel->setHorario($payload->horario_comida);
}

if (isset($_POST['mostrar1'])) {
    $mostrar = $objModel->cantEstudiantes();
}

if (isset($_POST['mostrar2'])) {
    $mostrar = $objModel->cantAsistencias();
}

if (isset($_POST['mostrar3'])) {
    $mostrar = $objModel->cantMenus();
}

if (isset($_POST['mostrar4'])) {
    $mostrar = $objModel->cantEventos();
}

if (isset($_POST['mostrar5'])) {
    $mostrar = $objModel->cantAlimentos();
}

if (isset($_POST['mostrar6'])) {
    $mostrar = $objModel->cantUtensilios();
}

if (isset($_POST['mostrar7'])) {
    $mostrar = $objModel->asistencias();
}

if (isset($_POST['mostrar8'])) {
    $mostrar = $objModel->menusG();
}

if (isset($_POST['mostrar9'])) {
    $mostrar = $objModel->menus();
}

$components = new initComponents();
$navegador = new navegador($payload);
$footer = new footer();
$sidebar = new sidebar($permisos);
$configuracion = new configuracion($permisos);
$cardy = new cardysHome($permisos);

if (file_exists("vista/homeVista.php")) {
    require_once("vista/homeVista.php");
} else {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('home')) . "'</script>");
}
?>
