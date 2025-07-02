<?php
use component\initComponents as initComponents;
use component\navegador as navegador;
use component\sidebar as sidebar;
use component\footer as footer;
use component\configuracion as configuracion;
use component\NotificacionesServer as NotificacionesServer;
use helpers\encryption as encryption;
use helpers\permisosHelper as permisosHelper;
use modelo\tipoUtensilioModelo as tipoUtensilio;
use middleware\PostRateMiddleware as PostRateMiddleware;
use helpers\csrfTokenHelper;
use middleware\csrfMiddleware;

    $objeto = new tipoUtensilio();
    $sistem = new encryption();
    $datosPermisos = permisosHelper::verificarPermisos($sistem, $objeto, 'Tipos de Utensilios', 'consultar');
    $permisos = $datosPermisos['permisos'];
    $payload = $datosPermisos['payload'];
    $tokenCsrf= csrfTokenHelper::generateCsrfToken($payload->cedula);

if (isset($_POST['renovarToken']) && $_POST['renovarToken'] == true && isset($_POST['csrfToken'])) {
    $resultadoToken = csrfMiddleware::verificarYRenovar($_POST['csrfToken'], $payload->cedula);
    echo json_encode(['message' => 'Token renovado','newCsrfToken' => $resultadoToken['newToken']]);
    die();
}
    
  $NotificacionesServer = new NotificacionesServer();

        if (isset($payload->cedula)) {
        $NotificacionesServer->setCedula($payload->cedula);
        } else {
            echo json_encode(['error' => 'Cédula no encontrada en el token']);
            exit;
        }

        if (isset($_POST['notificaciones'])) {
            $valor = $NotificacionesServer->consultarNotificaciones();
        }
    
        if (isset($_POST['notificacionId'])) {
            $valor = $NotificacionesServer->marcarNotificacionLeida($_POST['notificacionId']);
        }

    if (isset($datosPermisos['permiso']['registrar'])) {
        if (isset($_POST['validar'], $_POST['tipo'])) {
           
            echo json_encode($objeto->validarTipo($_POST['tipo']));
            exit;
        }
        
        if (isset($_POST['registrar'], $_POST['tipo'], $_POST['csrfToken'])) {
            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
            PostRateMiddleware::verificar('registrar', (array)$payload);
            $respuesta = $objeto->registrarTipo($_POST['tipo']);
            echo json_encode(['mensaje' => $respuesta,'newCsrfToken' => $csrf['newToken']]);
            exit;
        }    
    }


    if(isset($datosPermisos['permiso']['consultar'])) {
        if (isset($_POST['tipoU'])) {
            $respuesta = $objeto->mostrarTiposTabla();
            echo json_encode($respuesta);
            exit;
        }


        if (isset($_POST['info']) && isset($_POST['id'])) {
            
            $respuesta = $objeto->verTipos($_POST['id'], false);
            echo json_encode($respuesta);
            exit;
        }
    }
    
    if(isset($datosPermisos['permiso']['modificar'])) {
        if (isset($_POST['modificar']) && isset($_POST['id'],)) {
        
            $modificar = $objeto->validarModificar($_POST['id'], false);
            echo json_encode($modificar);
            exit;
        }
        
        if (isset($_POST['tipo2']) && isset($_POST['id']) && isset($_POST['csrfToken'])) {
            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
            PostRateMiddleware::verificar('verificar', (array)$payload);
            $tipo = $_POST['tipo2'];
            $id = $_POST['id'];
        
            $existe = $objeto->existeTipo($id, false);
            if (isset($existe['resultado']) && $existe['resultado'] === 'ya no existe') {
                exit(json_encode($existe));
            }
        
            $validacion = $objeto->validarTipo2($tipo, $id, false);
            if (isset($validacion['resultado']) && $validacion['resultado'] === 'error2') {
                exit(json_encode($validacion));
            }
        
            $modificar = $objeto->editarTipo($tipo, $id, false);
            echo json_encode(['mensaje'=>$modificar, 'newCsrfToken' => $csrf['newToken']]); 
            exit();
        }
    
    }


    if(isset($datosPermisos['permiso']['eliminar'])) {
        if (isset($_POST['eliminar']) && isset($_POST['id']) && isset($_POST['csrfToken'])) {
            $csrf = csrfMiddleware::verificarCsrfToken($payload->cedula, $_POST['csrfToken']);
            PostRateMiddleware::verificar('anular', (array)$payload);
            try {
                $tipoId = $_POST['id'];
                $objeto->existeTipo($tipoId);
                $anular = $objeto->eliminarTipo($tipoId);
                echo json_encode(['mensaje'=>$anular, 'newCsrfToken' => $csrf['newToken']]);
                die();
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error en la eliminación: ' . $e->getMessage()]);
            }
            die();
        }
    }


    $components = new initComponents();
    $navegador = new navegador($payload);
    $sidebar = new sidebar($permisos);
    $footer = new footer();
    $configuracion = new configuracion($permisos);


if (file_exists("vista/tipoUtensilioVista.php")) {
    require_once("vista/tipoUtensilioVista.php");
}else{
    die("<script>window.location='?url=" .urlencode( $sistem->encryptURL('login')) . "'</script>");
}


?>