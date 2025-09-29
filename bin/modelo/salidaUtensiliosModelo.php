<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;


class salidaUtensiliosModelo extends connectDB {


        private $tipoU;
        private $utensilios;
        private $material;
        private $payload;

    public function __construct()
{
    parent::__construct();
    if (isset($_COOKIE['jwt']) && !empty($_COOKIE['jwt'])) {
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    } else {
        $this->payload = (object) ['cedula' => '12345678'];
    }
}

    public function verificarExistenciaTipoU($tipoU) {
        if (!preg_match("/^[0-9]+$/", $tipoU)) {
            return ['resultado' => 'Seleccionar un tipo de utensilio válido'];
        }
    
        $this->tipoU = $tipoU;
        return $this->consultarExistenciaTipoU();
    }
    
    private function consultarExistenciaTipoU() {
        try {
            $this->conectarDB();
            $verificar = $this->conex->prepare("SELECT idTipoU FROM tipoutensilios WHERE status = 1 AND idTipoU = ?");
            $verificar->bindValue(1, $this->tipoU);
            $verificar->execute();
            $data = $verificar->fetchAll();
            $this->desconectarDB();
    
            if (!isset($data[0]["idTipoU"])) {
                return ['resultado' => 'no está'];
            }
    
            return ['resultado' => 'existe'];
            
        } catch (\PDOException $error) {
            return ['error' => 'Error en la base de datos', 'detalle' => $error->getMessage()];
        }
    }
    

    public function mostrarTipoUtensilio() {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("
                SELECT DISTINCT tu.idTipoU, tu.tipo 
                FROM tipoutensilios tu 
                INNER JOIN utensilios u ON tu.idTipoU = u.idTipoU 
                WHERE u.idUtensilios IN (
                    SELECT idUtensilios FROM detalleentradau WHERE status = 1
                );
            ");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
    
        } catch (\PDOException $e) {
            return ['error' => 'Error en la base de datos', 'detalle' => $e->getMessage()];
        }
    }
    


    public function verificarExistenciaUtensilio($utensilios) {
        if (!preg_match("/^[0-9]+$/", $utensilios)) {
            return ['resultado' => 'Seleccionar un utensilio válido'];
        }
    
        $this->utensilios = $utensilios;
        return $this->consultarExistenciaUtensilio();
    }
    
    private function consultarExistenciaUtensilio() {
        try {
            $this->conectarDB();
            $verificar = $this->conex->prepare("SELECT idUtensilios FROM utensilios WHERE status = 1 AND idUtensilios = ?");
            $verificar->bindValue(1, $this->utensilios);
            $verificar->execute();
            $data = $verificar->fetchAll();
            $this->desconectarDB();
    
            if (!isset($data[0]["idUtensilios"])) {
                return ['resultado' => 'no está'];
            }
    
            return ['resultado' => 'está'];
    
        } catch (\PDOException $error) {
            return ['error' => 'Error en la base de datos', 'detalle' => $error->getMessage()];
        }
    }
    
    

    public function mostrarUtensilios($tipoU) {
        if (!preg_match("/^[0-9]+$/", $tipoU)) {
            return ['resultado' => 'Seleccionar un tipo de utensilio válido'];
        }
    
        $this->tipoU = $tipoU;
        return $this->consultarUtensiliosPorTipo();
    }
    
    private function consultarUtensiliosPorTipo() {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("
                SELECT DISTINCT u.idUtensilios, u.imgUtensilios, u.nombre, u.material, u.stock 
                FROM tipoutensilios tu 
                INNER JOIN utensilios u ON tu.idTipoU = u.idTipoU 
                WHERE u.idTipoU = ? 
                AND u.idUtensilios IN (
                    SELECT idUtensilios FROM detalleentradau 
                    WHERE status = 1 AND u.status = 1
                );");
            $mostrar->bindValue(1, $this->tipoU);
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
    
            return $data;
    
        } catch (\PDOException $e) {
            return ['error' => 'Error en la base de datos', 'detalle' => $e->getMessage()];
        }
    }
    
    


    public function verificarExistenciaTipoS($tipoS) {
        
        if (!preg_match("/^[0-9]+$/", $tipoS)) {
            return ['resultado' => 'Seleccionar un tipo de salida válido'];
        }
    
        $this->tipoS = $tipoS;
        return $this->consultarExistenciaTipoSalida();
    }
    
    private function consultarExistenciaTipoSalida() {
        try {
            $this->conectarDB();
            $verificar = $this->conex->prepare("SELECT idTipoSalidas FROM tiposalidas WHERE status = 1 AND idTipoSalidas = ?");
            $verificar->bindValue(1, $this->tipoS);
            $verificar->execute();
            $data = $verificar->fetchAll();
            $this->desconectarDB();
    
            if (!isset($data[0]["idTipoSalidas"])) {
                return ['resultado' => 'no está'];
            }
    
           
            return ['resultado' => 'existe'];
    
        } catch (\PDOException $error) {
            return ['error' => 'Error en la base de datos', 'detalle' => $error->getMessage()];
        }
    }
    
    


    public function mostrarTipoSalida() {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM tiposalidas WHERE status = 1 AND tipoSalida NOT IN ('Menu', 'Menú', 'MenÃº');");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
    
            return $data;
    
        } catch (\PDOException $e) {
            return ['error' => 'Error en la base de datos', 'detalle' => $e->getMessage()];
        }
    }


    public function infoUtensilio($utensilio) {
        if (!preg_match("/^[0-9]+$/", $utensilio)) {
            return ['resultado' => 'Seleccionar un utensilio válido'];
        }
    
        $this->utensilio = $utensilio;
    
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM utensilios WHERE status = 1 AND idUtensilios = ?");
            $mostrar->bindValue(1, $this->utensilio);
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
    
            return $data;
        } catch (\PDOException $e) {
            return ['error' => 'Error en la base de datos', 'detalle' => $e->getMessage()];
        }
    }
    

    public function registrarSalidaU($fecha, $hora, $tipoS, $descripcion) {
        $errores = [];

        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
            $errores[] = 'Fecha inválida, debe ser en formato YYYY-MM-DD';
        }
        if (!preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $hora)) {
            $errores[] = 'Hora inválida, debe ser en formato HH:MM';
        }
        if (!preg_match("/^[0-9]+$/", $tipoS)) {
            $errores[] = 'Seleccionar un tipo de salida válido';
        }
        if (strlen($descripcion) < 5) {
            $errores[] = 'Ingresar una descripción válida con al menos 5 caracteres';
        }

        if (!empty($errores)) {
            return ['resultado' => implode(' | ', $errores)];
        }

        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->tipoS = $tipoS;
        $this->descripcion = $descripcion;

        return $this->registrar();
    }
    
    private function registrar() {
        try {
            $this->conectarDB();
            $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
            $this->conex->beginTransaction();
    
            $registrar = $this->conex->prepare("INSERT INTO `salidautensilios`(`fecha`, `descripcion`, `idTipoSalidas`, `status`) VALUES (?, ?, ?, 1)");
            $registrar->bindValue(1, $this->fecha);
            $registrar->bindValue(2, $this->descripcion);
            $registrar->bindValue(3, $this->tipoS);
            
            $registrar->execute();
    
            // Registrar en bitácora
            $bitacora = new bitacoraModelo();
            $bitacora->registrarBitacora('Salida Utensilios', 'Registró una salida de Utensilios el día ' . $this->fecha . ' con la siguiente descripción: ' . $this->descripcion, $this->payload->cedula);
    
            $this->notificaciones($this->fecha, $this->hora, $this->descripcion);
            $this->id = $this->conex->lastInsertId();
    
            $this->conex->commit();
            $this->desconectarDB();
    
            return ['id' => $this->id];
        } catch (\Exception $error) {
            $this->conex->rollBack();
            $this->desconectarDB();
            return ['error' => 'Error en la base de datos', 'detalle' => $error->getMessage()];
        }
    }
    
    public function registrarDetalleSalidaU($utensilio, $cantidad, $id) {
    $errores = [];

    if (!preg_match("/^[0-9]+$/", $utensilio)) {
        $errores[] = 'Ingresar el utensilio para el registro';
    }
    if (!preg_match("/^[1-9][0-9]*$/", $cantidad)) {
        $errores[] = 'Ingresar la cantidad';
    }
    if (!preg_match("/^[0-9]+$/", $id)) {
        $errores[] = 'Ingresar el id del registro';
    }

    if (!empty($errores)) {
        return ['resultado' => implode(' | ', $errores)];
    }

    $this->utensilio = $utensilio;
    $this->cantidad = $cantidad;
    $this->id = $id;

    return $this->registrarDetalle();
}
    
    private function registrarDetalle() {
        try {
            $this->conectarDB();

            $stmt = $this->conex->prepare("CALL sp_registrar_detalle_salida(?, ?, ?)");
            $stmt->bindValue(1, $this->utensilio);
            $stmt->bindValue(2, $this->cantidad);
            $stmt->bindValue(3, $this->id);
            $stmt->execute();

            $this->notificaciones2($this->utensilio); 
            $this->desconectarDB();

            return ['resultado' => 'exitoso'];
        } catch (\PDOException $error) {
            $this->desconectarDB();
            return ['error' => 'Error en la base de datos', 'detalle' => $error->getMessage()];
        }
    }


private function actualizarStock($idUtensilio, $cantidad) {
    try {
        
        $stmt = $this->conex->prepare("SELECT stock FROM utensilios WHERE status = 1 AND idUtensilios = ? FOR UPDATE");
        $stmt->bindValue(1, $idUtensilio);
        $stmt->execute();
        $info = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$info) {
            throw new Exception('Utensilio no encontrado o inactivo');
        }

        $nuevoStock = $info['stock'] - $cantidad;
        if ($nuevoStock < 0) {
            throw new Exception('Stock insuficiente para realizar la salida');
        }

        $update = $this->conex->prepare("UPDATE utensilios SET stock = ? WHERE idUtensilios = ?");
        $update->bindValue(1, $nuevoStock);
        $update->bindValue(2, $idUtensilio);
        $update->execute();
    } catch (\Exception $e) {
        throw $e; // Se propaga a registrarDetalle()
    }
}


     private function notificaciones($fecha, $hora, $descripcion) {
        try {
           $this->conectarDBSeguridad();
          $titulo = "Registro de Salida de Utensilios";
          $mensaje = 'Se registro una salida de Utensilios en la fecha y hora: '.$this->fecha. ' - '.$this->hora. ' la cual describe que es :  '.$this->descripcion;
          $tipomsj = "informacion";
          $query = $this->conex2->prepare("INSERT INTO `notificaciones` (`titulo`, `mensaje`, `tipo`) VALUES (?, ?, ?)");
            $query->bindValue(1, $titulo);
            $query->bindValue(2, $mensaje);
            $query->bindValue(3, $tipomsj);
            $query->execute();
    
          $notificacionId = $this->conex2->lastInsertId();
    
          $query = $this->conex2->prepare("SELECT * FROM usuario u INNER JOIN rol r ON u.idRol = r.idRol INNER JOIN permiso p ON p.idRol = r.idRol INNER JOIN modulo m ON m.idModulo = p.idModulo WHERE m.nombreModulo = 'Inventario de Utensilios' and p.nombrePermiso = 'consultar' and p.status = 1 and u.status = 1;");
          $query->execute();
          $usuarios = $query->fetchAll(\PDO::FETCH_OBJ);
    
          $query = $this->conex2->prepare("INSERT INTO `notificaciones_usuarios` (`cedula`, `idNotificaciones`, `leida`) VALUES (?, ?, 0)");
          foreach ($usuarios as $usuario) {
              $query->bindValue(1, $usuario->cedula);
              $query->bindValue(2, $notificacionId);
              $query->execute();
          }
    
        } catch (Exception $e) {
            
            error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
        }
    }
    private function notificaciones2($utensilio) {
        try {
           $this->conectarDBSeguridad();
          $query = $this->conex->prepare("SELECT stock, nombre FROM `utensilios` WHERE idUtensilios = ?");
            $query->bindValue(1, $this->utensilio);
            $query->execute();
       
            $result = $query->fetch(\PDO::FETCH_ASSOC);
      
            if ($result) {
              $stock = $result['stock'];
              $nombre = $result['nombre'];
      
              if ($stock == 0) {
      
              $titulo = "Stock Vacio";
              $mensaje = "El Stock del Utensilio ".$nombre. " se encuentra vacio." ;
              $tipomsj = "informacion";
              $query = $this->conex2->prepare("INSERT INTO `notificaciones` (`titulo`, `mensaje`, `tipo`) VALUES (?, ?, ?)");
              $query->bindValue(1, $titulo);
              $query->bindValue(2, $mensaje);
              $query->bindValue(3, $tipomsj);
              $query->execute();
        
              $notificacionId = $this->conex2->lastInsertId();
        
              $query = $this->conex2->prepare("SELECT * FROM usuario u INNER JOIN rol r ON u.idRol = r.idRol INNER JOIN permiso p ON p.idRol = r.idRol INNER JOIN modulo m ON m.idModulo = p.idModulo WHERE m.nombreModulo = 'Inventario de Alimentos' and p.nombrePermiso = 'consultar' and p.status = 1 and u.status = 1;");
              $query->execute();
              $usuarios = $query->fetchAll(\PDO::FETCH_OBJ);
        
              $query = $this->conex2->prepare("INSERT INTO `notificaciones_usuarios` (`cedula`, `idNotificaciones`, `leida`) VALUES (?, ?, 0)");
              foreach ($usuarios as $usuario) {
                  $query->bindValue(1, $usuario->cedula);
                  $query->bindValue(2, $notificacionId);
                  $query->execute();
              }
              } else {
                
              }
            } else {
              echo "No se encontró el alimento con idAlimento = .";
            }
      
      
        } catch (Exception $e) {
            
            error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
        }
      }


}


