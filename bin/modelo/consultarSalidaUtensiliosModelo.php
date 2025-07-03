<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;
use modelo\reporteModelo as reporte; 


class consultarSalidaUtensiliosModelo extends connectDB {
	private $tipoU;
	private $utensilio;
	private $material;
	private $cantidad;
	private $imagen;
	private $id;
    private $payload;

    public function __construct() {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    public function mostrarSalidaUtensilios($fechaInicio, $fechaFin) {
        // Validar fechas si no están vacías
        if (!empty($fechaInicio) && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $fechaInicio)) {
            return ['resultado' => 'Fecha de inicio inválida. Formato requerido: YYYY-MM-DD'];
        }
        if (!empty($fechaFin) && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $fechaFin)) {
            return ['resultado' => 'Fecha de fin inválida. Formato requerido: YYYY-MM-DD'];
        }
    
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    
        try {
            $this->conectarDB();
    
            if (!empty($this->fechaInicio) && !empty($this->fechaFin)) {
                $data = $this->consultarSalidaPorFecha($this->fechaInicio, $this->fechaFin);
                $this->registrarBitacoraSalida($this->fechaInicio, $this->fechaFin);
            } else {
                $data = $this->consultarSalidaSinFechas();
            }
    
            return $data;
    
        } catch (\PDOException $e) {
            return ['error' => '¡Error en el sistema!'];
        } finally {
            $this->desconectarDB();
        }
    }
    
    
    private function consultarSalidaPorFecha($fechaInicio, $fechaFin) {
        $stmt = $this->conex->prepare("
            SELECT * FROM salidautensilios su 
            INNER JOIN tiposalidas ts ON ts.idTipoSalidas = su.idTipoSalidas 
            WHERE su.status = 1 AND fecha BETWEEN ? AND ?
        ");
        $stmt->bindValue(1, $fechaInicio);
        $stmt->bindValue(2, $fechaFin);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    private function consultarSalidaSinFechas() {
        $stmt = $this->conex->prepare("
            SELECT * FROM salidautensilios su 
            INNER JOIN tiposalidas ts ON ts.idTipoSalidas = su.idTipoSalidas 
            WHERE su.status = 1
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    private function registrarBitacoraSalida($fechaInicio, $fechaFin) {
        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora(
            'Consultar Salida Utensilios',
            'Se realizó una consulta de la fecha ' . $fechaInicio . ' hasta la fecha ' . $fechaFin,
            $this->payload->cedula
        );
    }

    public function verificarExistencia($id) {
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido.'];
        }
    
        $this->id = $id;
    
        try {
            $this->conectarDB();
            $stmt = $this->conex->prepare("SELECT * FROM salidautensilios WHERE idSalidaU = ? AND status = 1");
            $stmt->bindValue(1, $this->id);
            $stmt->execute();
            $data = $stmt->fetchAll();
    
            return (empty($data) || !isset($data[0]["idSalidaU"]))
                ? ['resultado' => 'ya no existe']
                : ['resultado' => 'existe'];
    
        } catch (\Exception $e) {
            return ['error' => '¡Error en el sistema!'];
        } finally {
            $this->desconectarDB();
        }
    }
    
    public function tipoutensilios($id) {
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido.'];
        }
    
        $this->id = $id;
    
        try {
            $this->conectarDB();
            $stmt = $this->conex->prepare("
                SELECT DISTINCT tu.idTipoU, tu.tipo 
                FROM salidautensilios su 
                INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU 
                INNER JOIN utensilios u ON u.idUtensilios = dsu.idUtensilios 
                INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU 
                WHERE su.idSalidaU = ?
            ");
            $stmt->bindValue(1, $this->id);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
    
            return empty($data)
                ? ['resultado' => 'No se encontraron tipos de utensilios.']
                : $data;
    
        } catch (\PDOException $e) {
            return ['error' => '¡Error en el sistema!'];
        } finally {
            $this->desconectarDB();
        }
    }
    
    public function utensilios($idTipoU, $idInventarioU) {
        
        if (!preg_match("/^[0-9]+$/", $idTipoU) || !preg_match("/^[0-9]+$/", $idInventarioU)) {
            return ['resultado' => 'IDs inválidos.'];
        }
    
        $this->tipoU = $idTipoU;
        $this->id = $idInventarioU;
    
        try {
            $this->conectarDB();
            $stmt = $this->conex->prepare("
                SELECT *
                FROM salidautensilios su
                INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU
                INNER JOIN utensilios u ON u.idUtensilios = dsu.idUtensilios
                INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU
                WHERE tu.idTipoU = ? AND su.idSalidaU = ? AND u.status != 0
            ");
            $stmt->bindValue(1, $this->tipoU);
            $stmt->bindValue(2, $this->id);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
    
            return empty($data)
                ? ['resultado' => 'No se encontraron utensilios.']
                : $data;
    
        } catch (\PDOException $e) {
            return ['error' => '¡Error en el sistema!'];
        } finally {
            $this->desconectarDB();
        }
    }
    
    
    public function verificarAnulacion($id) {
        
        if (!preg_match("/^[0-9]+$/", $id)) {
            return ['resultado' => 'ID inválido.'];
        }
    
        $this->id = $id;
    
        try {
            $this->conectarDB();
            $stmt = $this->conex->prepare("
                SELECT su.idSalidaU 
                FROM salidautensilios su
                INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU
                INNER JOIN utensilios u ON u.idUtensilios = dsu.idUtensilios
                WHERE su.idSalidaU = ? AND su.fecha < CURRENT_DATE;
            ");
            $stmt->bindValue(1, $this->id);
            $stmt->execute();
            $data = $stmt->fetchAll();
    
            if (isset($data[0]["idSalidaU"])) {
                return ['resultado' => 'no se puede'];
            } else {
                return ['resultado' => 'se puede'];
            }
    
        } catch (\PDOException $error) {
            return ['error' => '¡Error en el sistema!'];
        } finally {
            $this->desconectarDB();
        }
    }
    
    public function anularSalidaUtensilios($id) {
        if (!ctype_digit($id)) {
         return ['resultado' => 'Seleccionar una salida válida'];
        }

        $this->id = $id;
        return $this->anular();
    }
    
    private function anular() {
    try {
        $this->conectarDB();
        $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
        $this->conex->beginTransaction();

        $stmt = $this->conex->prepare("UPDATE salidautensilios SET status = 0 WHERE idSalidaU = ?");
        $stmt->bindValue(1, $this->id);
        $stmt->execute();

        $detalle = $this->detalleSalidaUtensilios($this->id, true);
        $datos = $detalle[0] ?? null;

        if ($datos) {
            $bitacora = new bitacoraModelo();
            $bitacora->registrarBitacora(
                'Consultar Salida Utensilios',
                'Se ha anulado la entrada de Utensilios el día ' . $datos->fecha . ' con la siguiente descripción: ' . $datos->descripcion,
                $this->payload->cedula 
            );
        }

        $this->anularDetalle($this->id);
        $this->restarCantidadStock($this->id);

        $this->conex->commit();
        return ['resultado' => 'eliminado'];
    } catch (Exception $e) {
        $this->conex->rollBack();
        return ['error' => 'Error al anular: ' . $e->getMessage()];
    } finally {
        $this->desconectarDB();
    }
}

    
    private function anularDetalle($id) {
        try {
            $stmt = $this->conex->prepare("UPDATE detallesalidau SET status = 0 WHERE idSalidaU = ?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
        } catch (PDOException $e) {
            // Podrías loguear el error o manejarlo
            return $e->getMessage();
        }
    }
    
    private function restarCantidadStock($id) {
        try {
            $query = $this->conex->prepare("
                SELECT u.idUtensilios, u.stock, SUM(dsu.cantidad) as totalCantidad 
                FROM salidautensilios su 
                INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU 
                INNER JOIN utensilios u ON u.idUtensilios = dsu.idUtensilios 
                WHERE su.idSalidaU = ? 
                GROUP BY u.idUtensilios, u.stock;
            ");
            $query->bindValue(1, $id);
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_OBJ);
    
            foreach ($data as $cant) {
                $nuevoStock = $cant->stock + $cant->totalCantidad;
                $updateStock = $this->conex->prepare("UPDATE utensilios SET stock = ? WHERE idUtensilios = ?");
                $updateStock->bindValue(1, $nuevoStock);
                $updateStock->bindValue(2, $cant->idUtensilios);
                $updateStock->execute();
            }
    
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    private function detalleSalidaUtensilios($id, $returnData = false) {
        try {
            $stmt = $this->conex->prepare("
                SELECT * 
                FROM salidautensilios su 
                INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU 
                WHERE su.idSalidaU = ? AND su.status = 0;
            ");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            if ($returnData) {
                return $data;
            }
            return $data;
        } catch (Exception $error) {
            return ['error' => '¡Error Sistema!'];
        }
    }
    

private function detalleUtensilios($id, $returnData = false) {
    try {
        $this->conectarDB();

        $stmt = $this->conex->prepare("
            SELECT * 
            FROM salidautensilios su
            INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU
            INNER JOIN utensilios u ON u.idUtensilios = dsu.idUtensilios
            INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU
            WHERE su.idSalidaU = ? AND su.status = 1
        ");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        $this->desconectarDB();
        return $returnData ? $data : null;
    } catch (Exception $e) {
        return ['error' => '¡Error Sistema!'];
    }
}

 private function detalleUtensiliosTotal($fechaI, $fechaF, $returnData = false) {
    try {
        $this->conectarDB();
        if (!empty($fechaI) && !empty($fechaF)) {
            $data = $this->consultarDetallePorFecha($fechaI, $fechaF);
        } else {
            $data = $this->consultarDetalleSinFechas();
        }
         $this->desconectarDB();

        if ($returnData === true) {
            return $data;
        }

    } catch (\Exception $error) {
        return array("Sistema", "¡Error Sistema!");
    }
}

private function consultarDetallePorFecha($fechaI, $fechaF) {
    $new = $this->conex->prepare("SELECT * FROM salidautensilios su 
        INNER JOIN tiposalidas ts ON ts.idTipoSalidas = su.idTipoSalidas
        INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU 
        INNER JOIN utensilios u ON u.idUtensilios = dsu.idUtensilios 
        INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU 
        WHERE su.status = 1 AND su.fecha BETWEEN ? AND ?
    ");
    $new->bindValue(1, $fechaI);
    $new->bindValue(2, $fechaF);
    $new->execute();
    return $new->fetchAll(\PDO::FETCH_OBJ);
}

private function consultarDetalleSinFechas() {
    $mostrar = $this->conex->prepare("
        SELECT * FROM salidautensilios su 
        INNER JOIN tiposalidas ts ON ts.idTipoSalidas = su.idTipoSalidas 
        INNER JOIN detallesalidau dsu ON dsu.idSalidaU = su.idSalidaU 
        INNER JOIN utensilios u ON u.idUtensilios = dsu.idUtensilios 
        INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU
        WHERE su.status = 1
    ");
    $mostrar->execute();
    return $mostrar->fetchAll(\PDO::FETCH_OBJ);
}



      public function fpdf($id){
        
           try {
            $this->id = $id;
            $this->conectarDB();
            $new = $this->conex->prepare(" SELECT * FROM salidautensilios su INNER JOIN tiposalidas ts ON su.idTipoSalidas = ts.idTipoSalidas  WHERE su.idSalidaU =? ");
            $new->bindValue(1,$this->id );
            $new->execute();
            $info = $new->fetchAll(\PDO::FETCH_OBJ);
             $this->desconectarDB();

               $descripcion=  $info;
               $detalle=$this->detalleUtensilios($this->id, true);
              
               $data = [
                   'descripcion' => $descripcion,
                   'detalle'=>$detalle
               ];
          
              $reporte = new reporte;
              $reporte->AddPage();
              $reporte->salidaUtensilios($data);
              $reporte->Output();

           } catch (\PDOException $e) {
               return $e;
           }
       }

       public function fpdf2($fechaI, $fechaF){
        $this->fechaI=$fechaI;
        $this->fechaF=$fechaF;
          try {
              $detalle = $this->detalleUtensiliosTotal($this->fechaI,  $this->fechaF, true);
              $data = [
                'fechaI'=> $this->fechaI,
                'fechaF'=> $this->fechaF,
                'detalle' => $detalle
              ]; // Convertir $data en un objeto de tipo stdClass
              $reporte = new reporte;
              $reporte->AddPage();
              $reporte->salidaUtensiliosTotal($data);
              $reporte->Output();
          } catch (\PDOException $e) {
              return $e;
          }
      }



}

?>
