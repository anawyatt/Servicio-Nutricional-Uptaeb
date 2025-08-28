<?php 

    namespace modelo;
    use config\connect\connectDB as connectDB;
    use helpers\encryption;
    use helpers\JwtHelpers;


    class usuarioModelo extends connectDB{
   
    private $cedula;
    private $nombre;
    private $segNombre;
    private $apellido;
    private $segApellido;
    private $correo;
    private $telefono;
    private $idRol;
    private $clave;

    private $img;
    private $encryption;
    private $payload;

    public function __construct(){
    parent::__construct();

    $this->encryption = new encryption();

    if (isset($_COOKIE['jwt']) && !empty($_COOKIE['jwt'])) {
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    } else {
        $this->payload = (object) ['cedula' => '12345678'];
    }
}



        public function validarCedula($cedula) {
            if (!preg_match("/^[0-9]{7,9}$/", $cedula)) {
                return ['resultado' => 'Ingresar Cedula'];
            }

            $this->cedula = trim($cedula);
            $resultado = $this->validarCE();
    
            return $resultado === true ? ['resultado' => 'error Cedula'] : ['resultado' => 'No Existe'];  
        }

        private function validarCE(){
            try {
                $this->conectarDBSeguridad();
                $validar = $this->conex2->prepare("SELECT `cedula` FROM `usuario` WHERE `cedula`= ? AND status != 0");
                $validar->bindValue(1, $this->cedula);
                $validar->execute();
                $data = $validar->fetch(); 
                $this->desconectarDB();
                return !empty($data);

            } catch (Exception $error) {
            return ['resultado' => '¡Error Sistema!'];
            }
        }

        public function validarCorreo($correo) {
            if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/", $correo)) {
              return ['resultado' => 'Ingresar Correo'];
            }

            $this->correo = trim($correo);
            $resultado = $this->validarCO();
            return $resultado === true ? ['resultado' => 'error correo'] : ['resultado' => 'No Existe'];
        }

        private function validarCO() {
            try {
                $this->conectarDBSeguridad();
                $correoCifrado = $this->encryption->encryptData($this->correo);
                $validar = $this->conex2->prepare("SELECT `correo` FROM `usuario` WHERE `correo` = ? AND status != 0");
                $validar->bindValue(1, $correoCifrado);
                $validar->execute();
                $data = $validar->fetch(); 
                $this->desconectarDB();

                return !empty($data);

            } catch (Exception $error) {
                return ['resultado' => '¡Error Sistema!'];
            }
        }

        public function validarTelefono($telefono) {
            if (!preg_match("/^0\d{10}$/", $telefono)) {
                    return ['resultado' => 'Ingresar Teléfono válido sin espacios'];
            }

            $this->telefono = trim($telefono);
            $resultado = $this->validarT();

            return $resultado === true ? ['resultado' => 'error telefono'] :['resultado' => 'No Existe'];
        }

        private function validarT() {
            try {
                $this->conectarDBSeguridad();
                $validar = $this->conex2->prepare("SELECT `telefono` FROM `usuario` WHERE `telefono` = ? 
                AND status != 0");
                $validar->bindValue(1, $this->telefono);
                $validar->execute();
                $data = $validar->fetch(); 
                $this->desconectarDB();
                return !empty($data);

             } catch (Exception $error) {
                return ['resultado' => '¡Error Sistema!'];
            }
        }

        public function verificarExistenciaRol($idRol) {
                if (!preg_match("/^[0-9]+$/", $idRol)) {
                    return ['resultado' => 'Seleccionar Rol'];
                }

                $this->idRol = trim($idRol);
                $resultado = $this->verificarER();

                return $resultado === true ? ['resultado' => 'existe rol'] : ['resultado' => 'error rol'];
        }

        private function verificarER() {
            try {
                $this->conectarDBSeguridad();
                $verificar = $this->conex2->prepare("SELECT nombreRol FROM rol WHERE status = 1 AND idRol = ?");
                $verificar->bindValue(1, $this->idRol);
                $verificar->execute();
                $data = $verificar->fetch(\PDO::FETCH_ASSOC);
                $this->desconectarDB();
                return !empty($data);
                
                } catch (Exception $error) {
            return ['resultado' => '¡Error Sistema!'];
            }
        }

        public function mostrarRol() {
            try {
                $this->conectarDBSeguridad();
                $stmt = $this->conex2->prepare("SELECT idRol, nombreRol FROM rol WHERE status = 1 AND idRol != 1");
                $stmt->execute();
                $data = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
                return $data;
            } catch (\PDOException $e) {
                return []; 
            } finally {
                $this->desconectarDB();
            }
        }

        private function validarCampos($datos) {
            $errores = [];

            $reglas = [
                ['campo' => $datos['cedula'],      'patron' => "/^[0-9]{7,9}$/",                                    'mensaje' => 'Ingresar Cedula'],
                ['campo' => $datos['nombre'],      'patron' => "/^[a-zA-ZÀ-ÿ\s]{3,}$/",                             'mensaje' => 'Ingresar nombre'],
                ['campo' => $datos['segNombre'],   'patron' => "/^[a-zA-ZÀ-ÿ\s]{0,}$/",                             'mensaje' => 'Ingresar segundo nombre'],
                ['campo' => $datos['apellido'],    'patron' => "/^[a-zA-ZÀ-ÿ\s]{3,}$/",                             'mensaje' => 'Ingresar apellido'],
                ['campo' => $datos['segApellido'], 'patron' => "/^[a-zA-ZÀ-ÿ\s]{0,}$/",                             'mensaje' => 'Ingresar segundo apellido'],
                ['campo' => $datos['correo'],      'patron' => "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/",   'mensaje' => 'Ingresar Correo'],
                ['campo' => $datos['telefono'],    'patron' => "/^0\d{10}$/",                                         'mensaje' => 'Ingresar Teléfono válido sin espacios'],
                ['campo' => $datos['idRol'],       'patron' => "/^[0-9]{1,}$/",                                      'mensaje' => 'Seleccionar rol'],
                ['campo' => $datos['clave'],       'patron' => "/^[A-Za-z0-9\*\-_\.\;\,\(\)\"@#\$=\xF1\xD1À-ÿ]{8,}$/", 'mensaje' => 'Ingresar clave'],
            ];

            foreach ($reglas as $regla) {
                if (!preg_match($regla['patron'], $regla['campo'])) {
                    $errores[] = $regla['mensaje'];
                }
            }

            if (!empty($errores)) {
                return ['resultado' => implode(', ', $errores)];
            }

            return ['resultado' => 'ok'];
        }

        public function registrarUsuario($cedula, $nombre, $segNombre, $apellido, $segApellido, $correo, 
        $telefono, $idRol, $clave) {

            $datos = compact('cedula', 'nombre', 'segNombre', 'apellido', 'segApellido', 'correo',
             'telefono', 'idRol', 'clave');

            $validacion = $this->validarCampos($datos);
            if ($validacion['resultado'] !== 'ok') {
                return $validacion; 
            }

            $this->cedula      = trim($cedula);
            $this->nombre      = trim($nombre);
            $this->segNombre   = trim($segNombre);
            $this->apellido    = trim($apellido);
            $this->segApellido = trim($segApellido);
            $this->correo      = trim($correo);
            $this->telefono    = trim($telefono);
            $this->clave       = $clave;
            $this->idRol       = $idRol;
            $this->img         = 'assets/images/perfil/user.png';

    
            $resultado = $this->usuario();
            return $resultado === true ? ['resultado' => 'registro exitoso'] : ['resultado' => 'usuario no registrado'];
        }
    
        private function usuario() {
            try {
                $this->conectarDBSeguridad();
                $this->conex2->beginTransaction();

                $this->clave = password_hash($this->clave, PASSWORD_BCRYPT);

                $correoCifrado = $this->encryption->encryptData($this->correo);
               
              
                $new = $this->conex2->prepare("CALL proceRegistrarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $new->bindValue(1, $this->cedula);
                $new->bindValue(2, $this->img);
                $new->bindValue(3, $this->nombre);
                $new->bindValue(4, $this->segNombre);
                $new->bindValue(5, $this->apellido);
                $new->bindValue(6, $this->segApellido);
                $new->bindValue(7, $correoCifrado);
                $new->bindValue(8, $this->telefono);
                $new->bindValue(9, $this->clave);
                $new->bindValue(10, $this->idRol);

                $success = $new->execute();
                $new->closeCursor();

                if (!$success) {
                    $this->conex2->rollBack();
                    return false;
                }

                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Usuarios', 'Registro un nuevo usuario llamado:'.$this->nombre . ' ' .$this->apellido,
                $this->payload->cedula);

                $this->conex2->commit();

                return true;

            } catch (Exception $error) {
                $this->conex2->rollBack();
                return false;

            } finally {
                $this->desconectarDB();
            }
        }



     
       
 }
?>