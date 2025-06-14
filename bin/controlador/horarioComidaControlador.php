<?php

  use component\initComponents as initComponents;
  use modelo\horarioComidaModelo as horarioComida;
  use helpers\encryption as encryption;


  $objeto = new horarioComida();
  $sistem = new encryption();

   if(isset($_POST['ingresar']) && isset($_POST['horario'])){
    $ingresar= $objeto->ingresar($_POST['horario']);
    }

  $components = new initComponents();


if (file_exists("vista/horarioComidaVista.php")) {
   require_once("vista/horarioComidaVista.php");
   }else {
   die ("<script>window.location='?url=".urlencode( $sistem->encryptURL('horarioComida') )."</script>");
  }

?>


