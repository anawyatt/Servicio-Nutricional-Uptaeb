<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
use helpers\JwtHelpers;
use modelo\reporteModelo as reporte; 


class consultarEntradaUtensiliosModelo extends connectDB {
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

   public function mostrarEntradaUtensilios($fechaInicio, $fechaFin) {
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
            $data = $this->consultarPorFecha($this->fechaInicio, $this->fechaFin);
            $this->registrarBitacoraConsulta($this->fechaInicio, $this->fechaFin);
        } else {
            $data = $this->consultarSinFechas();
        }

        return $data;

    } catch (\PDOException $e) {
        return ['error' => '¡Error en el sistema!'];
    } finally {
        $this->desconectarDB();
    }
}

private function consultarPorFecha($fechaInicio, $fechaFin) {
    $stmt = $this->conex->prepare("SELECT * FROM entradau WHERE status = 1 AND fecha BETWEEN ? AND ?");
    $stmt->bindValue(1, $fechaInicio);
    $stmt->bindValue(2, $fechaFin);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}

private function consultarSinFechas() {
    $stmt = $this->conex->prepare("SELECT * FROM entradau WHERE status = 1");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}

private function registrarBitacoraConsulta($fechaInicio, $fechaFin) {
    $bitacora = new bitacoraModelo;
    $bitacora->registrarBitacora(
        'Consultar Entrada Utensilios', 
        'Se realizó una consulta de la fecha ' . $fechaInicio . ' hasta la fecha ' . $fechaFin, 
        $this->payload->cedula
    );
}
  
public function verificarExistencia($id) {
    if (!preg_match("/^[0-9]+$/", $id)) {
        return ['resultado' => 'Seleccionar un ID válido'];
    }

    $this->id = $id;

    try {
        $this->conectarDB();

        $stmt = $this->conex->prepare("SELECT idEntradaU FROM entradau WHERE idEntradaU = ? AND status = 1");
        $stmt->bindValue(1, $this->id);
        $stmt->execute();
        $data = $stmt->fetch();

        return $data ? null : ['resultado' => 'ya no existe'];
    } catch (\PDOException $e) {
        return ['error' => '¡Error en el sistema!'];
    } finally {
        $this->desconectarDB();
    }
}

public function tipoutensilios($id) {
    if (!preg_match("/^[0-9]+$/", $id)) {
        return ['resultado' => 'Seleccionar un ID válido'];
    }

    $this->id = $id;
    return $this->tipo();
}

private function tipo() {
    try {
        $this->conectarDB();

        $stmt = $this->conex->prepare("
            SELECT DISTINCT tu.idTipoU, tu.tipo 
            FROM entradau iu
            INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU 
            INNER JOIN utensilios u ON u.idUtensilios = diu.idUtensilios  
            INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU
            WHERE iu.idEntradaU = ?
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
        return ['resultado' => 'Seleccionar un tipo de utensilio y un inventario válidos'];
    }

    $this->tipoU = $idTipoU;
    $this->id = $idInventarioU;

    return $this->muestraU();
}

private function muestraU() {
    try {
        $this->conectarDB();

        $stmt = $this->conex->prepare("
            SELECT *
            FROM entradau iu 
            INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU  
            INNER JOIN utensilios u ON u.idUtensilios = diu.idUtensilios  
            INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU
            WHERE tu.idTipoU = ? AND iu.idEntradaU = ?
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
        return ['resultado' => 'ID de entrada no válido'];
    }
    $this->id = $id;
   try {
        $this->conectarDB();

        $stmt = $this->conex->prepare("
            SELECT iu.idEntradaU 
            FROM entradau iu
            INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU  
            INNER JOIN utensilios u ON u.idUtensilios = diu.idUtensilios  
            INNER JOIN detallesalidau dsu ON dsu.idUtensilios = u.idUtensilios  
            INNER JOIN salidautensilios su ON su.idSalidaU = dsu.idSalidaU  
            WHERE iu.idEntradaU = ?
              AND iu.fecha <= su.fecha
              AND diu.idUtensilios IN (
                  SELECT idUtensilios FROM detallesalidau WHERE status = 1
              )
        ");
        $stmt->bindValue(1, $this->id);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return isset($data[0]->idEntradaU)
            ? ['resultado' => 'no se puede']
            : ['resultado' => 'se puede'];
    } catch (\PDOException $e) {
        return ['error' => '¡Error en el sistema!'];
    } finally {

        $this->desconectarDB();
    }
}

  
  
  
public function anularEntradaUtensilios($id) {
    if (!preg_match("/^[0-9]+$/", $id)) {
        return ['resultado' => 'Seleccionar un ID de entrada válido'];
    }

    $this->id = $id;

    try {
        $this->conectarDB();
        $this->conex->beginTransaction();

        $stmt = $this->conex->prepare("UPDATE entradau SET status = 0 WHERE idEntradaU = ?");
        $stmt->bindValue(1, $this->id);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            $this->conex->rollBack();
            return ['resultado' => 'No se pudo anular la entrada.'];
        }

        $detalle = $this->detalleEntradaUtensilios($this->id);
        if (empty($detalle)) {
            $this->conex->rollBack();
            return ['resultado' => 'No se encontró información de la entrada.'];
        }

        $datos = $detalle[0];

        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora(
            'Anular Entrada Utensilios',
            'Se ha anulado la entrada de utensilios del día ' . $datos->fecha . 
            ' a la hora ' . $datos->hora . ' con descripción: ' . $datos->descripcion,
            $this->payload->cedula
        );

        $this->anularDetalle($this->id);
        $this->restarCantidadStock($this->id);

        $this->conex->commit();
        return ['resultado' => 'eliminado'];
    } catch (\PDOException $e) {
        $this->conex->rollBack();
        return ['error' => '¡Error en el sistema!'];
    } finally {
        $this->desconectarDB();
    }
}

private function anularDetalle($id) {
    $stmt = $this->conex->prepare("UPDATE detalleentradau SET status = 0 WHERE idEntradaU = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

private function restarCantidadStock($id) {
    $stmt = $this->conex->prepare("
        SELECT u.idUtensilios, u.stock, SUM(diu.cantidad) AS totalCantidad 
        FROM entradau iu
        INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU  
        INNER JOIN utensilios u ON u.idUtensilios = diu.idUtensilios 
        WHERE iu.idEntradaU = ?
        GROUP BY u.idUtensilios, u.stock
    ");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $datos = $stmt->fetchAll(\PDO::FETCH_OBJ);

    foreach ($datos as $item) {
        $nuevoStock = $item->stock - $item->totalCantidad;
        $update = $this->conex->prepare("UPDATE utensilios SET stock = ? WHERE idUtensilios = ?");
        $update->bindValue(1, $nuevoStock);
        $update->bindValue(2, $item->idUtensilios);
        $update->execute();
    }
}

private function detalleEntradaUtensilios($id) {
    $stmt = $this->conex->prepare("
        SELECT * 
        FROM entradau iu
        INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU  
        WHERE iu.idEntradaU = ? AND iu.status = 0
    ");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}


 private function detalleUtensiliosTotal($fechaI, $fechaF, $returnData = false) {
  try {
     $this->conectarDB();
      if (!empty($fechaI) && !empty($fechaF)) {
          $data = $this->consultarEntradaPorFecha($fechaI, $fechaF);
      } else {
          $data = $this->consultarEntradaSinFechas();
      }
      $this->desconectarDB();

      if ($returnData === true) {
          return $data;
      }

  } catch (\Exception $error) {
      return array("Sistema", "¡Error Sistema!");
  }
}

private function detalleUtensilios($id, $returnData = false){
 
    try{
        $this->id = $id;
        $this->conectarDB();
         $mostrar=$this->conex->prepare("SELECT * FROM entradau iu INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU INNER JOIN utensilios u ON u.idUtensilios = diu.idUtensilios INNER JOIN tipoutensilios tu ON u.idTipoU  = tu.idTipoU WHERE iu.idEntradaU = ? and iu.status=1; ");
         $mostrar->bindValue(1, $this->id);
         $mostrar->execute();
         $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
         $this->desconectarDB();
          if ($returnData === true) {
               return $data;
           }
         
    }
    catch(exection $error){
         
         return array("Sistema", "¡Error Sistema!");
    }
 }

private function consultarEntradaPorFecha($fechaI, $fechaF) {
 
  $new = $this->conex->prepare("
      SELECT * FROM entradau iu 
      INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU 
      INNER JOIN utensilios u ON u.idUtensilios = diu.idUtensilios 
      INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU 
      WHERE iu.status = 1 AND iu.fecha BETWEEN ? AND ?
  ");
  $new->bindValue(1, $fechaI);
  $new->bindValue(2, $fechaF);
  $new->execute();
  return $new->fetchAll(\PDO::FETCH_OBJ);
}

private function consultarEntradaSinFechas() {
  $mostrar = $this->conex->prepare("
      SELECT * FROM entradau iu 
      INNER JOIN detalleentradau diu ON diu.idEntradaU = iu.idEntradaU 
      INNER JOIN utensilios u ON u.idUtensilios = diu.idUtensilios 
      INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU 
      WHERE iu.status = 1
  ");
  $mostrar->execute();
  return $mostrar->fetchAll(\PDO::FETCH_OBJ);
  
}



public function fpdf($id){
        
    try {
     $this->id = $id;
     $this->conectarDB();
     $new = $this->conex->prepare(" SELECT * FROM entradau WHERE idEntradaU  =? ");
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
       $reporte->entradaUtensilios($data);
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
          ]; 
          
          $reporte = new reporte;
          $reporte->AddPage();
          $reporte->entradaUtensiliosTotal($data);
          $reporte->Output();
      } catch (\PDOException $e) {
          return $e;
      }
  }



}

?>
