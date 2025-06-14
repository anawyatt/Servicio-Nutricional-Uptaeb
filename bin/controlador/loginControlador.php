<?php

  use component\initComponents as initComponents;
  use helpers\encryption as encryption;
  use modelo\loginModelo as login;

  $object = new login();
 
  if(isset($_POST['cedula'])){
    $respuesta = $object->loginSistema($_POST['cedula'], $_POST['clave']);
    echo json_encode($respuesta);
    die();  
   }

    if(isset($_POST['enviar']) && isset($_POST['correo'])){
    $mostrar= $object->recuperContraseñas($_POST['correo']);
  }


$components = new initComponents();
$sistem = new encryption();


if (file_exists("vista/loginVista.php")) {
   require_once("vista/loginVista.php");
   }else {
    die("<script>window.location='?url=" . urlencode( $sistem->encryptURL('login') ). "'</script>");
  }

?>


