<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;


class entradaUtensiliosModelo extends connectDB {

private $tipoU;
private $utensilio;
private $material;
private $payload;

    public function __construct() {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    } 

    public function mostrarTipoUtensilio() {
        try {
            $this->conectarDB();
            $stmt = $this->conex->prepare("SELECT * FROM tipoutensilios WHERE status = 1 AND idTipoU IN (SELECT idTipoU FROM utensilios WHERE status = 1)");
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
    
            return !empty($data)
                ? $data
                : ['resultado' => 'No se encontraron tipos de utensilios.'];
    
        } catch (\PDOException $e) {
            return ['error' => 'Error al consultar los tipos de utensilios'];
        } finally {
            $this->desconectarDB();
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
            $stmt = $this->conex->prepare("
                SELECT idTipoU 
                FROM tipoutensilios 
                WHERE status = 1 AND idTipoU = ?
            ");
            $stmt->bindValue(1, $this->tipoU);
            $stmt->execute();
            $data = $stmt->fetchAll();
    
            return isset($data[0]["idTipoU"])
                ? ['resultado' => 'existe']
                : ['resultado' => 'no está'];
    
        } catch (\Exception $e) {
            return [
                'error' => 'Error en la base de datos',
                'detalle' => $e->getMessage()
            ];
        } finally {
            $this->desconectarDB();
        }
    }
    


    public function verificarExistenciaUtensilio($utensilio) {
        
        if (!preg_match("/^[0-9]+$/", $utensilio)) {
            return ['resultado' => 'Seleccionar un utensilio válido'];
        }
    
        $this->utensilio = $utensilio;
        return $this->consultarExistenciaUtensilio();
    }
    
    private function consultarExistenciaUtensilio() {
        try {
            $this->conectarDB();
    
            $stmt = $this->conex->prepare("
                SELECT idUtensilios 
                FROM utensilios 
                WHERE status = 1 AND idUtensilios = ?
            ");
            $stmt->bindValue(1, $this->utensilio);
            $stmt->execute();
            $data = $stmt->fetchAll();
    
            return isset($data[0]["idUtensilios"])
                ? ['resultado' => 'existe']
                : ['resultado' => 'no está'];
    
        } catch (\Exception $e) {
            return [
                'error' => 'Error en la base de datos',
                'detalle' => $e->getMessage()
            ];
        } finally {
            $this->desconectarDB();
        }
    }

    
    public function mostrarUtensilio($tipoU) {
        $this->tipoU = $tipoU;
        return $this->consultarUtensiliosPorTipo();
    }
    
    private function consultarUtensiliosPorTipo() {
        try {
            $this->conectarDB();
    
            $stmt = $this->conex->prepare("
                SELECT * 
                FROM utensilios 
                WHERE status = 1 AND idTipoU = ?
            ");
            $stmt->bindValue(1, $this->tipoU);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
    
            if (empty($data)) {
                return ['resultado' => 'No se encontraron utensilios.'];
            }
    
            return $data;
    
        } catch (\PDOException $e) {
            return ['error' => '¡Error en el sistema!'];
        } finally {
            $this->desconectarDB();

        }
    }    
    
  

public function infoUtensilio($utensilio) {
    
    if (!preg_match("/^[0-9]+$/", $utensilio)) {
        return ['resultado' => 'Seleccionar un utensilio válido'];
    }

    $this->utensilio = $utensilio;

    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("SELECT * FROM utensilios WHERE status = 1 AND idUtensilios = ?");
        $stmt->bindValue(1, $this->utensilio);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $this->desconectarDB();

        if (empty($data)) {
            return ['resultado' => 'No se encontró el utensilio.'];
        }

        return $data;

    } catch (\PDOException $e) {
        return ['error' => '¡Error en el sistema!'];
    }
}
    



public function registrarEntradaU($fecha, $hora, $descripcion) {
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha) || !preg_match("/^([01]\d|2[0-3]):([0-5]\d)$/", $hora)) {
        return ['resultado' => 'Fecha o hora no válidas.'];
    }

    $this->fecha = $fecha;
    $this->hora = $hora;
    $this->descripcion = $descripcion;

    return $this->registrar();
}

private function registrar() {
    $this->conectarDB();
    try {
        $this->conex->beginTransaction();

        $stmt = $this->conex->prepare("INSERT INTO `entradau`(`idEntradaU`, `fecha`, `hora`, `descripcion`, `status`) VALUES(DEFAULT, ?, ?, ?, 1)");
        $stmt->bindValue(1, $this->fecha);
        $stmt->bindValue(2, $this->hora);
        $stmt->bindValue(3, $this->descripcion);
        $stmt->execute();

        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora(
            'Entrada Utensilios',
            'Registró una entrada de Utensilios el día ' . $this->fecha . ' a la hora ' . $this->hora . ' con la siguiente descripción: ' . $this->descripcion,
            $this->payload->cedula
        );

        $this->id = $this->conex->lastInsertId();
        $this->conex->commit(); 

        $this->notificaciones($this->fecha, $this->hora, $this->descripcion);

        return ['id' => $this->id];
    } catch (Exception $e) {
        if ($this->conex->inTransaction()) {
            $this->conex->rollBack();
        }
        return ['error' => '¡Error en el sistema!'];
    } finally {
        $this->desconectarDB();
    }
}


public function registrarDetalleEntradaU($utensilio, $cantidad, $id) {
    $this->utensilio = $utensilio;
    $this->cantidad = $cantidad;
    $this->id = $id;

    if ($cantidad <= 0) {
        return ['resultado' => 'La cantidad debe ser mayor a cero.'];
    }

    return $this->registrarDetalle();
}

private function registrarDetalle() {
    try {
        $this->conectarDB();

        $stmt = $this->conex->prepare("CALL sp_registrarDetalleEntrada(?, ?, ?)");
        $stmt->bindValue(1, $this->cantidad);
        $stmt->bindValue(2, $this->utensilio);
        $stmt->bindValue(3, $this->id);
        $stmt->execute();

        $this->desconectarDB();
        return ['resultado' => 'exitoso'];
    } catch (Exception $e) {
        return ['error' => '¡Error en el sistema!', 'detalle' => $e->getMessage()];
    }
}


private function actualizarStock($idUtensilio, $cantidad) {
    try {
        $stmt = $this->conex->prepare("SELECT stock FROM utensilios WHERE status = 1 AND idUtensilios = ? FOR UPDATE");
        $stmt->bindValue(1, $idUtensilio);
        $stmt->execute();
        $info = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$info) {
            throw new Exception('Utensilio no encontrado');
        }

        $nuevoStock = $info["stock"] + $cantidad;

        $update = $this->conex->prepare("UPDATE utensilios SET stock = ? WHERE idUtensilios = ?");
        $update->bindValue(1, $nuevoStock);
        $update->bindValue(2, $idUtensilio);
        $update->execute();
    } catch (Exception $e) {
        throw $e;
    }
}


     private function notificaciones($fecha, $hora, $descripcion) {
        try {
          $this->conectarDBSeguridad();
          $titulo = "Registro de Entrada de Utensilios";
          $mensaje = 'Se registro una entrada de utensilios en la fecha y hora: '.$this->fecha. ' - '.$this->hora. ' la cual describe que es :  '.$this->descripcion;
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

}


