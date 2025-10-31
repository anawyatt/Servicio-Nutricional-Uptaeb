<?php

 use component\initComponents as initComponents;
 use component\navegador as navegador;
 use component\sidebar as sidebar;
 use component\footer as footer;

 use component\configuracion as configuracion;
 use helpers\encryption as encryption;
 use helpers\permisosHelper as permisosHelper;
 use modelo\stockAlimentosModelo as stockAlimentos;
 

 $objeto = new stockAlimentos;
 $sistem = new encryption();

 $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Inventario de Alimentos', 'consultar');
 $permisos = $datosPermisos['permisos'];
 $payload = $datosPermisos['payload'];

 if (!$payload->cedula) {
    die("<script>window.location='?url=" . urlencode($sistem->encryptURL('login')) . "'</script>");
  }


 //---- FILTRO---

 if (isset($_POST['select'])) {
   try {
      $mostrarTipoA= $objeto->mostrarTipoAlimento();
      echo json_encode($mostrarTipoA);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
}

if (isset($_POST['valida']) && isset($_POST['tipoA'])) {
   try {
      $validarExistenciaTA=  $objeto->verificarExistenciaTipoA($_POST['tipoA']);
      if ($validarExistenciaTA['resultado'] == 'no esta') { 
       echo json_encode($validarExistenciaTA);
       die();
      }
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
 }

 //--------- MOSTRAR TABLA

 if(isset($_POST['mostrarAlimentos']) && isset($_POST['tipoA']) ){
   try {
      $mostrarTabla= $objeto->mostrarAlimentos($_POST['tipoA']);
      echo json_encode($mostrarTabla);
      die();
    } catch (\RuntimeException $e) {
      echo json_encode(['message' => $e->getMessage()]);
      die();
    }
 }

//  REPORTE DEl PDF //

    if(isset ($_POST['reporte']) && isset ($_POST['tipoA'])){
      $reporte = $objeto->fpdf($_POST['tipoA']);
    }


  $components = new initComponents();
  $navegador = new navegador($payload);
  $sidebar = new sidebar($permisos);
  $footer = new footer();
  $configuracion = new configuracion($permisos);

   if (file_exists("vista/stockAlimentosVista.php")) {
   require_once("vista/stockAlimentosVista.php");
   }else {
   die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login')) . "'</script>");
  }

  ?>
  