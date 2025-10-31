<?php

use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
 use component\footer as footer;
use component\configuracion as configuracion;
use modelo\AyudaModelo as Ayuda;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;


$objeto = new Ayuda();  
$sistem = new encryption();
$permisosHelper = new permisosHelper();
$datosPermisos = $permisosHelper->verificarPermisos($sistem, $objeto, 'Home', 'consultar');
$permisos = $datosPermisos['permisos'];
$payload = $datosPermisos['payload'];

       if (!$payload->cedula) {
              die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
       }

        $components = new initComponents();
        $navegador = new navegador($payload);
        $sidebar = new sidebar($permisos);
        $footer = new footer();
       $configuracion = new configuracion($permisos);

if (file_exists("vista/ayudaVista.php")) {
   require_once("vista/ayudaVista.php");
}else {
   die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
}

  ?>