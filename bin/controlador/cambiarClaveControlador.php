<?php

  use component\initComponents as initComponents;
  use helpers\encryption as encryption;
  use modelo\cambiarClaveModelo as cambiarClave;

  $object = new cambiarContraseña();
 
 
 
   


    $components = new initComponents();
    $sistem = new encryption();


    if (file_exists("vista/cambiarClaveVista.php")) {
    require_once("vista/cambiarClaveVista.php");
    }else {
        die("<script>window.location='?url=" . urlencode( $sistem->encryptURL('login') ). "'</script>");
    }

?>


