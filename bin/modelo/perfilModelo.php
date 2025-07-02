<?php 
    namespace modelo;

    use config\connect\connectDB as connectDB;
    use helpers\encryption;
    use helpers\JwtHelpers;


    class perfilModelo extends connectDB {

        private $nombre	;
        private $apellido;
        private $correo	;

        private $iD;
        private $payload;


        public function __construct(){
            parent::__construct(); 
            $this->encryption = new encryption();
            $token = $_COOKIE['jwt'];
            $this->payload = JwtHelpers::validarToken($token);
        
        }

        public function informacionUsuario($iD) {
            if (!preg_match("/^[0-9]{1,}$/", $iD)) {
                return ['resultado' => 'Seleccionar Usuario'];
            }

            $this->iD = $iD;
            return $this->verDatosUsuario();  
        }

        private function verDatosUsuario() {
            try {
                $this->conectarDBSeguridad();
                $query = $this->conex2->prepare("SELECT nombre, apellido, correo FROM usuario WHERE cedula = ?;");
                $query->bindValue(1, $this->iD);
                $query->execute();
                $data = $query->fetch(\PDO::FETCH_OBJ); 

                if ($data) {
                    $data->correo = $this->encryption->decryptData($data->correo);
                }

                $this->desconectarDB();
                return $data;
            } catch (\PDOException $e) {
                return null;
            }
        }

        public function validarCorreo($correo) {
            if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/", $correo)) {
                return ['resultado' => 'Ingresar Correo'];
            }

            if (!$this->payload || empty($this->payload->cedula)) {
                return ['resultado' => 'Error: usuario no identificado'];
            }

            $this->correo = $correo;
            $this->cedula = trim($this->payload->cedula);

            $resultado = $this->validarCO();
            return $resultado === true ? ['resultado' => 'error correo'] : ['resultado' => 'ok'];
        }

        private function validarCO(){
                try {
                    $this->conectarDBSeguridad();
                    $correoCifrado = $this->encryption->encryptData($this->correo);

                    $validar = $this->conex2->prepare("SELECT `correo` FROM `usuario` WHERE `correo` = ? AND cedula != ? AND status != 0 ");
                    $validar->bindValue(1, $correoCifrado);
                    $validar->bindValue(2, $this->cedula);
                    $validar->execute();
                    $data = $validar->fetchAll();
                    $this->desconectarDB();
                    return !empty($data);
                    
                } catch (\Exception $error) {
                    return ['resultado' => '¡Error Sistema!'];
                }
        }


        public function editarPerfil($nombre, $apellido, $correo) {
                if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/", $correo)) {
                    return ['resultado' => 'Ingresar Correo'];
                }

                if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]{2,}$/", $nombre)) {
                    return ['resultado' => 'Ingresar Nombre'];
                }

                if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]{2,}$/", $apellido)) {
                    return ['resultado' => 'Ingresar Apellido'];
                }

                if (!$this->payload || empty($this->payload->cedula)) {
                    return ['resultado' => 'Error: usuario no identificado'];
                }

                $this->correo = $correo;
                $this->cedula = trim($this->payload->cedula);
                if ($this->validarCO() === true) {
                    return ['resultado' => 'error', 'mensaje' => 'El correo ya está en uso por otro usuario.'];
                }

                $this->nombre = trim($nombre);
                $this->apellido = trim($apellido);

                return $this->ModificarUsuario();
        }

        

        private function ModificarUsuario() {
            $cedula = $this->payload->cedula; 
            $this->cedula = $cedula;
            try {
                $this->conectarDBSeguridad();

                $correoCifrado = $this->encryption->encryptData($this->correo);

                $update = $this->conex2->prepare("UPDATE `usuario` SET `nombre`= ?, `apellido`= ?, `correo`=? WHERE `cedula` = ? AND `status` = 1");

                $update->bindValue(1, $this->nombre);
                $update->bindValue(2, $this->apellido);
                $update->bindValue(3, $correoCifrado);
                $update->bindValue(4, $cedula);

                $update->execute();
                $this->desconectarDB();

                $bitacora= new bitacoraModelo; 
                $bitacora->registrarBitacora('Perfil', 'Modificó sus datos personales', $this->payload->cedula);

                $this->payload->nombre = $this->nombre;
                $this->payload->apellido = $this->apellido;
                $this->payload->correo = $this->correo;
                
                $this->refrescarToken();


                $encryptedURL = $this->encryption->encryptURL('perfil');
                return ['resultado' => 'success', 'mensaje' => 'Perfil actualizado', 'url' => '?url=' . urlencode($encryptedURL)];
    
            } catch (\PDOException $e) {
                return ['resultado' => 'error', 'mensaje' => 'Error al actualizar perfil: ' . $e->getMessage()];
            }
        }

        public function cambiarContraseña($clave, $nuevaClave, $repetirClave) {
            $this->clave = $clave;
            $this->nuevaClave = $nuevaClave;
            $this->repetirClave = $repetirClave;

            $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\*\-_\.\;\,\(\)\"@#\$=])[A-Za-z\d\*\-_\.\;\,\(\)\"@#\$=]{8,}$/';

            foreach ([$this->clave, $this->nuevaClave, $this->repetirClave] as $claveTest) {
                if (!preg_match($regex, $claveTest)) {
                    return ['resultado' => 'error', 'mensaje' => 'La contraseña no cumple con los requisitos mínimos de seguridad'];
                }
            }

            return $this->cambiar();
        }

        private function cambiar() {
            $this->cedula = $this->payload->cedula;

            try {
                $this->conectarDBSeguridad();
                $query = $this->conex2->prepare("SELECT clave FROM usuario WHERE cedula = ?");
                $query->bindValue(1, $this->cedula);
                $query->execute();
                $data = $query->fetchAll();
                $this->desconectarDB();

                if (!isset($data[0]["clave"])) {
                    return ['resultado' => 'error', 'mensaje' => 'Usuario no encontrado'];
                }

                if (!password_verify($this->clave, $data[0]['clave'])) {
                    return ['resultado' => 'error', 'mensaje' => 'Contraseña actual incorrecta'];
                }

                if ($this->nuevaClave !== $this->repetirClave) {
                    return ['resultado' => 'error', 'mensaje' => 'Las nuevas contraseñas no coinciden'];
                }


                $this->nuevaContraseña = password_hash($this->nuevaClave, PASSWORD_BCRYPT);
                $this->conectarDBSeguridad();
                $update = $this->conex2->prepare("UPDATE usuario SET clave = ? WHERE cedula = ?");
                $update->bindValue(1, $this->nuevaContraseña);
                $update->bindValue(2, $this->cedula);
                $update->execute();
                $this->desconectarDB();

                $encryptedURL2 = $this->encryption->encryptURL('perfil');

                $bitacora = new bitacoraModelo();
                $bitacora->registrarBitacora('Perfil', 'Cambio su contraseña', $this->cedula);

                return ['resultado' => 'clave Editada correctamente.', 'url' => '?url=' . urlencode($encryptedURL2)];

            } catch (\Exception $error) {
                return ['resultado' => 'error', 'mensaje' => 'Error interno', 'detalle' => $error->getMessage()];
            }
        }


        public function eliminarImagen() {
            $this->cedula = $this->payload->cedula;
            $this->img = 'assets/images/perfil/user.png';
            return $this->eliminar();
        }

        private function eliminar() {
            try {
                $this->conectarDBSeguridad();

                // Obtener ruta actual de imagen para borrar archivo si no es la imagen por defecto
                $query = $this->conex2->prepare("SELECT img FROM usuario WHERE cedula = ? AND status = 1");
                $query->bindValue(1, $this->cedula);
                $query->execute();
                $data = $query->fetch(\PDO::FETCH_ASSOC);

                if ($data && isset($data['img']) && $data['img'] !== 'assets/images/perfil/user.png') {
                    $this->delete($data['img']);
                }

                $update = $this->conex2->prepare("UPDATE usuario SET img = ? WHERE cedula = ? AND status = 1");
                $update->bindValue(1, $this->img);
                $update->bindValue(2, $this->cedula);
                $update->execute();

                $this->desconectarDB();

                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Perfil', 'Eliminó su foto de perfil', $this->cedula);

                $this->payload->img = $this->img;
                $this->refrescarToken();

                return [
                    'resultado' => 'success',
                    'mensaje' => 'Imagen eliminada exitosamente',
                    'img' => $this->img
                ];

            } catch (\PDOException $e) {
                return ['resultado' => 'error', 'mensaje' => 'Error al eliminar imagen: ' . $e->getMessage()];
            }
        }

       
        public function editarImagen($img) {
            $this->cedula = $this->payload->cedula;
            $rand = rand(1, 10000);
            $this->img = $img;

            // Ruta absoluta donde se guardará la imagen
            $directorio = __DIR__ . '/../../assets/images/perfil/';
            $nombreArchivo = $this->cedula . $rand . '.png';
            $rutaCompleta = $directorio . $nombreArchivo;

            // Ruta relativa que se guardará en la base de datos
            $this->imagen = 'assets/images/perfil/' . $nombreArchivo;

            // Mover imagen al servidor
            if (!move_uploaded_file($this->img, $rutaCompleta)) {
                return [
                    'resultado' => 'error',
                    'mensaje' => 'No se pudo guardar la imagen en el servidor.'
                ];
            }

            return $this->editar();
        }


        private function editar() {
            try {
                $this->conectarDBSeguridad();
                $query = $this->conex2->prepare("SELECT img FROM usuario WHERE cedula = ?;");
                $query->bindValue(1, $this->cedula);
                $query->execute();
                $data = $query->fetchAll();

                if ($data && isset($data[0]["img"]) && $data[0]["img"] !== 'assets/images/perfil/user.png') {
                    $imagenAnterior = $data[0]["img"];
                    $this->delete($imagenAnterior);
                }

                $new = $this->conex2->prepare("UPDATE `usuario` SET img = ? WHERE `cedula` = ? AND `status` = 1");
                $new->bindValue(1, $this->imagen);
                $new->bindValue(2, $this->cedula);
                $new->execute();

                $this->desconectarDB();

                $this->payload->img = $this->imagen;
                $this->refrescarToken();

                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Perfil', 'cambió su foto de perfil', $this->cedula);

                return [
                    'resultado' => 'success',
                    'mensaje' => 'Foto cambiada con éxito',
                    'img' => $this->imagen
                ];

            } catch (\PDOException $e) {
                return ['resultado' => 'error', 'mensaje' => $e->getMessage()];
            }
        }

        private function delete($img) {
            $rutaAbsoluta = __DIR__ . '/../../' . $img;

            if (file_exists($rutaAbsoluta)) {
                unlink($rutaAbsoluta);
                error_log("Archivo eliminado correctamente: " . $rutaAbsoluta);
            } else {
                error_log("No se encontró el archivo para eliminar: " . $rutaAbsoluta);
            }
        }

        private function refrescarToken() {
            $nuevoToken = JwtHelpers::generarToken((array) $this->payload);
            setcookie('jwt', $nuevoToken, time() + 3600, "/", "", false, true);
        }



      


}

?>


