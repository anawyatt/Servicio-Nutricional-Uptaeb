<?php 
namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\encryption;
use helpers\JwtHelpers;


class consultarUsuarioModelo extends connectDB{
   
    private $cedula;
    private $nombre	;
    private $apellido;
    private $correo	;
    private $clave;
    private $idRol;
    
    private $iD;
    private $id;
    private $encryption;
    private $payload;


    public function __construct(){
    parent::__construct(); 
    $this->encryption = new encryption();
    $token = $_COOKIE['jwt'];
    $this->payload = JwtHelpers::validarToken($token);
    }

    public function mostrarUsuario() {
        $cedula = $this->payload->cedula;
        $this->cedula = $cedula;
        try {
            $this->conectarDBSeguridad();
            $new = $this->conex2->prepare("SELECT cedula, img, nombre, apellido, status FROM vista_usuarios_info WHERE cedula != ?");
            $new->bindValue(1, $this->cedula);
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();

            return $data;
        } catch (\PDOException $e) {
            return ['error' => 'Error al obtener los datos'];
        }
    }
    
    public function verificarExistencia($id) {
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            return ['resultado' => 'Seleccionar Usuario'];
        }

        $this->id = $id;
        $resultado = $this->verificarE();
        return $resultado === true ? ['resultado' => 'Existe'] : ['resultado' => 'error usuario'];
    }


    private function verificarE() {
        try {
            $this->conectarDBSeguridad();
            $verificar = $this->conex2->prepare("SELECT cedula FROM usuario WHERE cedula=? AND status!=0");
            $verificar->bindValue(1, $this->id);
            $verificar->execute();
            $data = $verificar->fetchAll();
            $this->desconectarDB();

            return !empty($data);
        } catch (Exception $error) {
            return false;
        }
    }

    public function infoUsuario($id) {
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
           return ['resultado' => 'Seleccionar Usuario'];
        }
        $this->id = $id;
        return $this->info();
    }

    private function info() {
            try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT cedula, img, nombre, segNombre, apellido, segApellido, correo,
            telefono, status, idRol, nombreRol FROM vista_usuarios_info WHERE cedula = ?");
        
            $query->bindValue(1, $this->id); 
            $query->execute();
            $data = $query->fetch(\PDO::FETCH_OBJ); 
            
             if ($data) {
                $data->correo = $this->encryption->decryptData($data->correo);
                $data->telefono = $this->encryption->decryptData($data->telefono);
            }


            $this->desconectarDB();
            return $data;

            } catch (\PDOException $e) {
                return ['error' => 'Error en la consulta: ' . $e->getMessage()];
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


    public function validarCorreo($correo, $cedula) {
        if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/", $correo)) {
              return ['resultado' => 'Ingresar Correo'];
            }

            if (!preg_match("/^[0-9]{7,9}$/", $cedula)) {
                return ['resultado' => 'Ingresar Cedula'];
            }
        
        $this->correo = $correo;
        $this->cedula = trim($cedula);
        $resultado = $this->validarCO();
        return $resultado === true ? ['resultado' => 'error correo'] : ['resultado' => 'ok'];

    }
    
    private function validarCO(){
       try {
            $this->conectarDBSeguridad();
            $correoCifrado = $this->encryption->encryptData($this->correo);

            $validar=$this->conex2->prepare("SELECT `correo` FROM `usuario` WHERE `correo`= ? and cedula != ? and status != 0 ");
            $validar->bindValue(1, $correoCifrado);
            $validar->bindValue(2, $this->cedula);
            $validar->execute();
            $data=$validar->fetchAll();
            $this->desconectarDB();
            return !empty($data);
            
        } catch (Exception $error) {
            return ['resultado' => '¡Error Sistema!'];
        }
    }

    public function validarTelefono($telefono, $cedula) {
         $telefono = str_replace(' ', '', $telefono);

        if (!preg_match("/^0\d{10}$/", $telefono)) {
            return  ['resultado' => 'Ingresar Telefono']; 
        }
    
        if (!preg_match("/^[0-9]{7,9}$/", $cedula)) {
            return ['resultado' => 'Ingresar Cedula'];
        }
    
        $this->telefono = $telefono;
        $this->cedula = $cedula;
        $resultado = $this->validarT();
        return $resultado === true ? ['resultado' => 'error telefono'] : ['resultado' => 'ok'];

    }
    
    private function validarT(){
       try {
            $this->conectarDBSeguridad();
            $telefonoCifrado = $this->encryption->encryptData($this->telefono);
            $validar=$this->conex2->prepare("SELECT `telefono` FROM `usuario` WHERE `telefono`= ? and cedula != ? and status !=0 ");
            $validar->bindValue(1, $telefonoCifrado);
            $validar->bindValue(2, $this->cedula);
            $validar->execute();
            $data=$validar->fetchAll();
            $this->desconectarDB();
            return !empty($data);

          
            } catch (Exception $error) {
                return ['resultado' => '¡Error Sistema!'];
            }
    }

    private function validarCamposEditar($datos) {
        $errores = [];

        $reglas = [
            ['campo' => $datos['cedula'],      'patron' => "/^[0-9]{7,9}$/",                                    'mensaje' => 'Ingresar Cedula'],
            ['campo' => $datos['nombre'],      'patron' => "/^[a-zA-ZÀ-ÿ\s]{3,}$/",                             'mensaje' => 'Ingresar nombre'],
            ['campo' => $datos['segNombre'],   'patron' => "/^[a-zA-ZÀ-ÿ\s]{0,}$/",                             'mensaje' => 'Ingresar segundo nombre'],
            ['campo' => $datos['apellido'],    'patron' => "/^[a-zA-ZÀ-ÿ\s]{3,}$/",                             'mensaje' => 'Ingresar apellido'],
            ['campo' => $datos['segApellido'], 'patron' => "/^[a-zA-ZÀ-ÿ\s]{0,}$/",                             'mensaje' => 'Ingresar segundo apellido'],
            ['campo' => $datos['correo'],      'patron' => "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{1,}$/",  'mensaje' => 'Ingresar Correo'],
            ['campo' => $datos['telefono'],    'patron' => "/^0\d{3} \d{7}$/",                                  'mensaje' => 'Ingresar Telefono'],
            ['campo' => $datos['idRol'],       'patron' => "/^[0-9]{1,}$/",                                     'mensaje' => 'Seleccionar rol'],
            ['campo' => $datos['estado'],      'patron' => "/^[0-9]{1,}$/",                                     'mensaje' => 'Ingresar estado'],
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

    public function editarUsuario($cedula, $nombre, $segNombre, $apellido, $segApellido, $correo, $telefono, $idRol, $estado) {
        $datos = compact('cedula', 'nombre', 'segNombre', 'apellido', 'segApellido', 'correo', 'telefono', 'idRol', 'estado');
        
        $validacion = $this->validarCamposEditar($datos);
        if ($validacion['resultado'] !== 'ok') {
            return $validacion;
        }

        $this->cedula      = trim($cedula);
        $this->nombre      = trim($nombre);
        $this->segNombre   = trim($segNombre);
        $this->apellido    = trim($apellido);
        $this->segApellido = trim($segApellido);
        $this->correo      = trim($correo);
        $this->telefono = str_replace(' ', '', $telefono);
        $this->idRol       = $idRol;
        $this->estado      = $estado;

        return $this->modificar();
    }

    private function modificar() {
        try {
            $this->conectarDBSeguridad();
            $this->conex2->beginTransaction();

            $correoCifrado = $this->encryption->encryptData($this->correo);
            $telefonoCifrado = $this->encryption->encryptData($this->telefono);

            $update = $this->conex2->prepare("UPDATE `usuario` SET `nombre`= ?, `segNombre`= ?, `apellido`= ?, 
            `segApellido`= ?,`correo`=?, `telefono`= ? ,`idRol`= ?, `status` = ?  WHERE `cedula` = ?");

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->segNombre);
            $update->bindValue(3, $this->apellido);
            $update->bindValue(4, $this->segApellido);
            $update->bindValue(5, $correoCifrado);
            $update->bindValue(6, $telefonoCifrado);
            $update->bindValue(7, $this->idRol);
            $update->bindValue(8, $this->estado);
            $update->bindValue(9, $this->cedula);
            $update->execute();

            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Consultar Usuarios', 'Se ha modificado un Usuario:'.$this->nombre . ' ' .$this->apellido,  $this->payload->cedula);
        

            $this->conex2->commit();
            return ['resultado' => 'modificado'];
        } catch (\PDOException $e) {
            $this->conex2->rollBack();
            return ['resultado' => 'error', 'mensaje' => $e->getMessage()];
        } finally {
            $this->desconectarDB();
        }
    }

    public function eliminarUsuario($id) {
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            return ['resultado' => 'Seleccionar Usuario'];
                }
    
                $this->id = $id;
            $resultado = $this->borrarUsuario();
            return $resultado === true ? ['resultado' => 'eliminado'] : ['resultado' => 'no eliminado'];
    }

    private function borrarUsuario() {
        try {
            $this->conectarDBSeguridad();
            $this->conex2->beginTransaction();

            $query = $this->conex2->prepare("UPDATE `usuario` SET `status`='0' WHERE cedula = ?");
            $query->bindValue(1, $this->id);
            $success = $query->execute();

            if (!$success) {
                $this->conex2->rollBack();
                return false;
            }

            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Anular Usuarios', 'Se ha Anulado un Usuario:'.$this->nombre . ' ' .$this->apellido,  $this->payload->cedula);
        

            $this->conex2->commit();
            return true;

        } catch (Exception $e) {
            $this->conex2->rollBack();
            return false;
        } finally {
            $this->desconectarDB();
        }
    }



}
?>
