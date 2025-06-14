<?php 
namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;

class tipoUtensilioModelo extends connectDB{

    private $tipo;
    private $payload;


    public function __construct(){
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    private function validarDato($dato, $tipoDato, $mensajeError) {
        $expresionesRegulares = array(
            'soloLetras' => '/^[a-zA-Z\s]+$/'
        );
    
        if (empty($dato) || !preg_match($expresionesRegulares[$tipoDato], $dato)) {
            return $mensajeError;
        }
    
        return true;
    }

    public function mostrarTiposTabla() {
        try {
            $this->conectarDB();
    
            $consulta = $this->conex->prepare("SELECT * FROM vista_tipos_utensilios_activos");
            $consulta->execute();
            $datos = $consulta->fetchAll(\PDO::FETCH_OBJ);
    
            return empty($datos)
                ? ['resultado' => 'No se encontraron tipos de utensilios.']
                : $datos;
    
        } catch (\PDOException $e) {
            return ['error' => 'Error al consultar los tipos de utensilios'];
        } finally {
            $this->desconectarDB();
        }
    }
    

    public function validarTipo($tipo) {
        if (!preg_match("/^[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\#\=]{3,30}$/", $tipo)) {
            return ['resultado' => 'Tipo inválido'];
        }
    
        $this->tipo = $tipo;
        return $this->consultarTipo();
    }
    
    private function consultarTipo() {
        try {
            $this->conectarDB();
    
            $sql = "SELECT tipo FROM tipoutensilios WHERE tipo = ? AND status != 0";
            $query = $this->conex->prepare($sql);
            $query->bindValue(1, $this->tipo);
            $query->execute();
    
            $existe = $query->fetch();
            return ['resultado' => $existe ? 'Ya existe' : 'disponible'];
    
        } catch (\PDOException $e) {
            return ['resultado' => 'error', 'mensaje' => $e->getMessage()];
        } finally {
            $this->desconectarDB();
        }
    }
    
    
    

    public function registrarTipo($tipo) {
        if (!preg_match("/^(?!\s*$)[a-zA-Z0-9À-ÿ\s\*\/\-\_\.\;\,\(\)\"\@\#\$\=]{1,50}$/", $tipo)) {
            return ['resultado' => 'Tipo invalido'];
        }
    
        $this->tipo = $tipo;
        return $this->nuevoTipo();
    }
    
    private function nuevoTipo() {
        try {
            $this->conectarDB();
    
            $stmt = $this->conex->prepare("CALL registrar_tipo_utensilio(?, @resultado)");
            $stmt->bindValue(1, $this->tipo);
            $stmt->execute();
    
            $stmt = $this->conex->query("SELECT @resultado AS resultado");
            $resultados = $stmt->fetchAll(\PDO::FETCH_OBJ);
  
            if (!empty($resultados) && $resultados[0]->resultado === 'exitoso') {
                $bitacora = new bitacoraModelo();
                $bitacora->registrarBitacora('Tipos Utensilios', 'Registró un Tipo Utensilios llamado: ' . $this->tipo, $this->payload->cedula);
               
            }
            $this->notificaciones($this->tipo);
            return ['resultado' => $resultados[0]->resultado ?? 'sin resultado'];
            
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        } finally {
            $this->desconectarDB();
        }
    }   
    

    private function notificaciones($tipo)
{
    try {
        $this->conectarDBSeguridad();
        $this->conex2->beginTransaction();

        $titulo = "Nuevo Tipo de Utensilio";
        $mensaje = "Se ha registrado un nuevo tipo de utensilio llamado: {$this->tipo}";
        $tipomsj = "informacion";

        // Insertar notificación principal
        $stmt = $this->conex2->prepare(
            "INSERT INTO notificaciones (titulo, mensaje, tipo) VALUES (?, ?, ?)"
        );
        $stmt->execute([$titulo, $mensaje, $tipomsj]);
        $notificacionId = $this->conex2->lastInsertId();

        // Obtener usuarios con permiso de consulta en el módulo correspondiente
        $usuarios = $this->conex2->query("
            SELECT u.cedula
            FROM usuario u
            JOIN rol r ON u.idRol = r.idRol
            JOIN permiso p ON p.idRol = r.idRol
            JOIN modulo m ON m.idModulo = p.idModulo
            WHERE m.nombreModulo = 'Tipos de Utensilios'
              AND p.nombrePermiso = 'consultar'
              AND p.status = 1
              AND u.status = 1
        ")->fetchAll(\PDO::FETCH_COLUMN);

        // Insertar notificaciones individuales
        $insertStmt = $this->conex2->prepare(
            "INSERT INTO notificaciones_usuarios (cedula, idNotificaciones, leida) VALUES (?, ?, 0)"
        );
        foreach ($usuarios as $cedula) {
            $insertStmt->execute([$cedula, $notificacionId]);
        }

        $this->conex2->commit();

        $this->enviarNotificacionWebSocket($notificacionId, $titulo, $mensaje);
    } catch (\Exception $e) {
        $this->conex2->rollBack();
        error_log("Error al registrar notificación: " . $e->getMessage());
    } finally {
        $this->desconectarDB();
    }
}

private function enviarNotificacionWebSocket($notificacionId, $titulo, $mensaje)
{
    $titulo = escapeshellarg($titulo);
    $mensaje = escapeshellarg($mensaje);
    $ruta = __DIR__ . "/../helpers/enviarNotificacion.php";

    $comando = "php $ruta $notificacionId $titulo $mensaje > /dev/null 2>&1 &";
    exec($comando);
}
    

    public function verTipos($id) {
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido'];
        }
    
        $this->id = $id;
        return $this->infoTipos();
    }
    
    private function infoTipos() {
        try {
            $this->conectarDB();
    
            $consulta = $this->conex->prepare("
                SELECT idTipoU, tipo, status 
                FROM tipoutensilios 
                WHERE idTipoU = ?
            ");
            $consulta->bindValue(1, $this->id);
            $consulta->execute();
    
            $datos = $consulta->fetchAll(\PDO::FETCH_OBJ);
    
            return empty($datos)
                ? ['resultado' => 'Tipo no encontrado']
                : $datos;
    
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        } finally {
            $this->desconectarDB();
        }
    }

    public function existeTipo($id) {
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido'];
        }
    
        $this->id = $id;
        return $this->consultarExistenciaTipo();
    }
    
    private function consultarExistenciaTipo() {
        try {
            $this->conectarDB();
            $stmt = $this->conex->prepare("SELECT idTipoU FROM tipoutensilios WHERE idTipoU = ? AND status != 0");
            $stmt->bindValue(1, $this->id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $this->desconectarDB();
    
            if (!isset($data[0]["idTipoU"])) {
                return ['resultado' => 'ya no existe'];
            }
    
            return ['resultado' => 'existe'];
    
        } catch (Exception $e) {
            return ['resultado' => '¡Error Sistema!'];
        }
    }
    
    

    public function validarModificar($id) {
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido'];
        }
    
        $this->id = $id;
        return $this->validarM();
    }
    
    private function validarM() {
        try {
            $this->conectarDB();
    
            $consulta = $this->conex->prepare("
                SELECT tipo 
                FROM tipoutensilios 
                WHERE idTipoU = ? 
                  AND idTipoU IN (
                    SELECT idTipoU 
                    FROM utensilios 
                    WHERE status = 1
                  )
            ");
            $consulta->bindValue(1, $this->id);
            $consulta->execute();
    
            $datos = $consulta->fetchAll();
    
            return isset($datos[0]["tipo"])
                ? ['resultado' => 'no se puede']
                : ['resultado' => 'se puede'];
    
        } catch (\Exception $e) {
            return ['error' => '¡Error Sistema!'];
        } finally {
            $this->desconectarDB();
        }
    }
    

    
    public function validarTipo2($tipo, $id) {
        // Validación del tipo
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,30}$/", $tipo)) {
            return ['resultado' => 'Tipo inválido'];
        }
    
        // Validación del ID
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido'];
        }
    
        $this->tipo = $tipo;
        $this->id = $id;
        return $this->consultarTipo2();
    }
    
    private function consultarTipo2() {
        try {
            $this->conectarDB();
            $stmt = $this->conex->prepare("SELECT idTipoU FROM tipoutensilios WHERE tipo = ? AND idTipoU != ? AND status != 0");
            $stmt->bindValue(1, $this->tipo);
            $stmt->bindValue(2, $this->id);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $this->desconectarDB();
    
            if (isset($data[0]["idTipoU"])) {
                return ['resultado' => 'error2'];
            }
    
            return ['resultado' => 'disponible'];
    
        } catch (Exception $e) {
            return ['resultado' => '¡Error Sistema!'];
        }
    }
    
    
    
    public function editarTipo($tipo, $id) {
        // Validación de ID
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido'];
        }
    
        // Validación del nombre
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,30}$/", $tipo)) {
            return ['resultado' => 'Nombre inválido'];
        }
    
        $this->tipo = $tipo;
        $this->id = $id;
    
        return $this->actualizarTipo();
    }
    
    private function actualizarTipo() {
        try {
            $this->conectarDB();
    
            $stmt = $this->conex->prepare("CALL actualizar_tipo_utensilio(?, ?, @resultado)");
            $stmt->bindValue(1, $this->id);
            $stmt->bindValue(2, $this->tipo);
            $stmt->execute();
    
            $stmt = $this->conex->query("SELECT @resultado AS resultado");
            $resultados = $stmt->fetchAll(\PDO::FETCH_OBJ);
    
            if (!empty($resultados) && $resultados[0]->resultado === 'actualizado') {
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora(
                    'Tipos Utensilios',
                    'Se modificó un Tipo Utensilios llamado: ' . $this->tipo,
                    $this->payload->cedula
                );
                return ['mensaje' => 'Tipo de utensilio actualizado exitosamente'];
            } else {
                return ['mensaje' => 'No se encontró el tipo de utensilio o no hubo cambios'];
            }
    
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        } finally {
            $this->desconectarDB();
        }
    }
    
    
    public function eliminarTipo($id) {
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido'];
        }
    
        $this->id = $id;
    
        try {
            return $this->anularTipo();
        } catch (\Exception $e) {
            return ['error' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }
    
    private function anularTipo() {
        try {
            $this->conectarDB();
    
            $stmt = $this->conex->prepare("CALL anular_tipo_utensilio(?, @resultado, @tipo_nombre)");
            $stmt->bindValue(1, $this->id);
            $stmt->execute();
    
            $stmt = $this->conex->query("SELECT @resultado AS resultado, @tipo_nombre AS tipo_nombre");
            $resultados = $stmt->fetchAll(\PDO::FETCH_OBJ);
    
            if (!empty($resultados) && $resultados[0]->resultado === 'anulado') {
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora(
                    'Tipos Utensilios',
                    'Se anuló un Tipo Utensilios llamado: ' . $resultados[0]->tipo_nombre,
                    $this->payload->cedula
                );
                return ['resultado' => 'Anulado correctamente.'];
            }
    
            return ['resultado' => $resultados[0]->resultado ?? 'Error desconocido'];
    
        } catch (PDOException $e) {
            return ['error' => 'Error al procesar la anulación: ' . $e->getMessage()];
        } finally {
            $this->desconectarDB();
        }
    }
    
    
    
    
    
        
        

}

?>