<?php 
namespace modelo;

use config\connect\connectDB as connectDB;
 use config\componentes\configSistema as configSistema;

class perfilModelo extends connectDB {

    private $nombre	;
    private $apellido;
    private $correo	;

    private $iD;
    public function __construct(){
        parent::__construct(); 
        $this->sistem = new configSistema();
    }

public function informacionUsuario($iD) {
    $this->iD = $iD;
    $this->verDatosUsuario();
}

private function verDatosUsuario() {
    try {
        $this->conectarDBSeguridad();
        $query = $this->conex2->prepare("SELECT nombre, apellido, correo FROM  usuario WHERE cedula = ?;");
        $query->bindValue(1, $this->iD);
        $query->execute();
        $data = $query->fetchAll(\PDO::FETCH_OBJ);
        $this->desconectarDB();
       
        echo json_encode($data);
        die();
    } catch (\PDOException $e) {
        return $e;
    }
}


public function editarPerfil( $nombre, $apellido, $correo,) {
   
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->correo = $correo;    
   
    return $this->ModificarUsuario();
    
}

private function ModificarUsuario() {
    $ced = $_SESSION['cedula'];

    try {
        $this->conectarDBSeguridad();
    $new = $this->conex2->prepare("UPDATE `usuario` SET `nombre`= ?, `apellido`= ?,`correo`=?  WHERE `cedula` = ? AND `status` = 1");
        
        $new->bindValue(1, $this->nombre);
        $new->bindValue(2, $this->apellido);
        $new->bindValue(3, $this->correo);
        $new->bindValue(4, $ced);
        $new->execute();
        $this->desconectarDB();
        $bitacora= new bitacoraModelo;
        $bitacora->registrarBitacora('Perfil', 'Modifico sus datos personales ', $_SESSION['cedula']);
      
        $_SESSION['nombre'] = $this->nombre;
        $_SESSION['apellido'] = $this->apellido;
        $_SESSION['correo'] = $this->correo;

                     // Encriptar la URL de redirección
                    $encryptedURL = $this->sistem->encryptURL('perfil');

                    // Redirige al perfil con URL encriptada
                    $mensaje = ['resultado' => 'success', 'url' => '?url=' . $encryptedURL];
                    echo json_encode($mensaje);
                    die();
    } catch (\PDOException $e) {
        return $e;
    }
}

public function cambiarContraseña($clave, $nuevaClave, $repetirClave) {
    $this->clave = $clave;
    $this->nuevaClave = $nuevaClave;
    $this->repetirClave = $repetirClave;
    $ced = $_SESSION['cedula'];
    $this->cedula = $ced;
   
    return $this->cambiar();
}

private function cambiar() {
    try {
        $this->nuevaContraseña = password_hash($this->nuevaClave, PASSWORD_BCRYPT);
        
    
        if ($_SESSION['reset_password_mode']) {
            // En modo de recuperación no verificamos la contraseña antigua
            if ($this->nuevaClave == $this->repetirClave) {
                $this->conectarDBSeguridad();
                $cambio = $this->conex2->prepare("UPDATE usuario SET clave = ? WHERE cedula = ?");
                $cambio->bindValue(1, $this->nuevaContraseña);
                $cambio->bindValue(2, $this->cedula);
                $cambio->execute();
                $this->desconectarDB();
                $encryptedURL = $this->sistem->encryptURL('login');
                $mensaje = ['resultado' => 'clave Editada correctamente.', 'url' => '?url=' . $encryptedURL];
                echo json_encode($mensaje);
                $bitacora = new bitacoraModelo;
                             $bitacora->registrarBitacora('Perfil', 'Cambio su contraseña', $_SESSION['cedula']);
                die();
            } else {
                $mensaje = ['resultado' => 'no son iguales'];
                echo json_encode($mensaje);
                die();
            }
        } else {
            $this->conectarDBSeguridad();
            // Modo normal, verificar contraseña actual
            $new = $this->conex2->prepare("SELECT clave FROM usuario WHERE cedula = ?");
            $new->bindValue(1, $this->cedula);
            $new->execute();
            $data = $new->fetchAll();
             $this->desconectarDB();

            if (isset($data[0]["clave"])) {
                if (password_verify($this->clave, $data[0]['clave'])) {
                    if ($this->nuevaClave == $this->repetirClave) {
                        $this->conectarDBSeguridad();
                        $cambio = $this->conex2->prepare("UPDATE usuario SET clave = ? WHERE cedula = ?");
                        $cambio->bindValue(1, $this->nuevaContraseña);
                        $cambio->bindValue(2, $this->cedula);
                        $cambio->execute();
                        $this->desconectarDB();
                        $encryptedURL2 = $this->sistem->encryptURL('perfil');
                        $mensaje = ['resultado' => 'clave Editada correctamente.' , 'url' => '?url=' . $encryptedURL2];
                        echo json_encode($mensaje);
                        $bitacora = new bitacoraModelo;
                        $bitacora->registrarBitacora('Perfil', 'Cambio su contraseña', $_SESSION['cedula']);
                        die();
                    } else {
                        $mensaje = ['resultado' => 'no son iguales'];
                        echo json_encode($mensaje);
                        die();
                    }
                } else {
                    $mensaje = ['resultado' => 'error'];
                    echo json_encode($mensaje);
                    die();
                }
            }
        }
    } catch (Exception $error) {
        return $error;
    }
}


public function eliminarImagen() {
    $ced = $_SESSION['cedula'];
    $this->cedula=$ced;
    $img='assets/images/perfil/user.png';
    $this->img=$img;
 
    return $this->eliminar();
    
}

private function eliminar() {
  
    try {
        $this->conectarDBSeguridad();
    $new = $this->conex2->prepare("UPDATE `usuario` SET img =?  WHERE `cedula` = ? AND `status` = 1");
        $new->bindValue(1, $this->img);
        $new->bindValue(2, $this->cedula);
        $new->execute();
        $this->desconectarDB();
        $bitacora= new bitacoraModelo;
        $bitacora->registrarBitacora('Perfil', 'elimino su foto de perfil ', $_SESSION['cedula']);
      
        $_SESSION['img'] = $this->img;

        echo json_encode(['mensaje' => 'Actualizado Exitosamente']);
        die();
    } catch (\PDOException $e) {
        return $e;
    }
}


public function editarImagen($img) {
    $ced = $_SESSION['cedula'];
    $this->cedula=$ced;
    $rand = rand(1, 10000);
    $this->img=$img;
    $ruta = "assets/images/perfil/";
    $imagen= $ruta. $this->cedula.$rand.'.png';
    $this->imagen=$imagen;
    move_uploaded_file($this->img, $this->imagen);
    return $this->editar();
    
}

private function editar() {
  
    try {
       $this->conectarDBSeguridad();
        $query = $this->conex2->prepare("SELECT img FROM usuario WHERE cedula = ?;");
        $query->bindValue(1, $this->cedula);
        $query->execute();
        $data = $query->fetchAll();
        if($data[0]["img"] != 'assets/images/perfil/user.png'){
           $imagen= $data[0]["img"];
           $this->delete($imagen);
        }
        $new = $this->conex2->prepare("UPDATE `usuario` SET img =?  WHERE `cedula` = ? AND `status` = 1");
        $new->bindValue(1, $this->imagen);
        $new->bindValue(2, $this->cedula);
        $new->execute();
        $this->desconectarDB();
        $_SESSION['img'] = $this->imagen;
        $bitacora= new bitacoraModelo;
        $bitacora->registrarBitacora('Perfil', 'cambio su foto de perfil ', $_SESSION['cedula']);
        $resultado = ['resultado' => 'Foto cambiada con exito'];
        
       echo json_encode($resultado);
       die();
    } catch (\PDOException $e) {
        return $e;
    }
}

function delete($img){
    $img;
    if (file_exists($img)) {
        if (unlink($img)) {
            return "La imagen ha sido eliminada correctamente.";
        } else {
            return "Error al intentar eliminar la imagen.";
        }
    } else {
        return "La imagen no existe en el directorio especificado.";
    }
}




}

?>


