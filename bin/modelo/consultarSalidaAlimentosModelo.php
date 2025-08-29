<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;
use modelo\reporteModelo as reporte;


class consultarSalidaAlimentosModelo extends connectDB
{
  private $tipoA;
  private $alimento;
  private $marca;
  private $cantidad;
  private $imagen;
  private $id;
  private $payload;
  private $fechaInicio;
  private $fechaFin;



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


  public function mostrarSalidaAlimentos($fechaInicio, $fechaFin)
  {
    $errores = [];
    $regexFecha = "/^\d{4}-\d{2}-\d{2}$/";

    if (!empty($fechaInicio) && !preg_match($regexFecha, $fechaInicio)) {
      $errores[] = "La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía.";
    }
    if (!empty($fechaFin) && !preg_match($regexFecha, $fechaFin)) {
      $errores[] = "La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía.";
    }
    if (!empty($fechaInicio) && !empty($fechaFin) && strtotime($fechaInicio) > strtotime($fechaFin)) {
      $errores[] = "La fecha de inicio no puede ser mayor que la fecha de fin.";
    }
    if (!empty($errores)) {
      return ['resultado' => implode(", ", $errores)];
    } else {
      $this->fechaInicio = $fechaInicio;
      $this->fechaFin = $fechaFin;
      return $this->mostrarSA();
    }
  }


  private function mostrarSA()
  {
    try {
      if (!empty($this->fechaInicio) && !empty($this->fechaFin)) {
        return $this->mostrarSAconFiltros();
      } else {
        return $this->mostrarSAsinFiltros();
      }

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al validar las fechas: ' . $e->getMessage());
    }
  }


  private function mostrarSAconFiltros()
  {
    try {
      $this->conectarDB();
      $new = $this->conex->prepare("SELECT * FROM vista_salida_alimentos WHERE  fecha BETWEEN ? AND ?");
      $new->bindValue(1, $this->fechaInicio);
      $new->bindValue(2, $this->fechaFin);
      $new->execute();
      $salidaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
      $bitacora = new bitacoraModelo;
      $bitacora->registrarBitacora('Inventario de los Alimentos - Salida', 'Consultó las salidas de los alimentos de la fecha : ' . $this->fechaInicio . ' hasta la fecha: ' . $this->fechaFin, $this->payload->cedula);
      $this->desconectarDB();
      return $salidaAlimentos;

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar las entradas de alimentos sin filtros: ' . $e->getMessage());
    }

  }

  private function mostrarSAsinFiltros()
  {
    try {
      $this->conectarDB();
      $new = $this->conex->prepare(" SELECT * FROM vista_salida_alimentos ");
      $new->execute();
      $salidaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
      $bitacora = new bitacoraModelo;
      $bitacora->registrarBitacora('Inventario de los Alimentos - Salida', 'Consultó las salidas de los alimentos', $this->payload->cedula);
      $this->desconectarDB();
      return $salidaAlimentos;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar las entradas de alimentos con filtros: ' . $e->getMessage());
    }
  }


  public function verificarExistencia($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar la Salida de alimentos'];
    } else {
      $this->id = $id;
      $resultado = $this->verificarE();
      return $resultado === true ? ['resultado' => 'si existe'] : ['resultado' => 'ya no existe'];
    }
  }

  private function verificarE()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare(" SELECT * FROM salidaalimentos  WHERE idSalidaA = ? and status =1");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia de la salida de alimentos: ' . $e->getMessage());
    }
  }

  public function tipoalimento($id): array
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar los tipos de alimentos del registro'];
    } else {
      $this->id = $id;
      return $this->tipoA();
    }
  }

  private function tipoA()
  {
    try {
      $this->conectarDB();
      $query = $this->conex->prepare("SELECT DISTINCT ta.idTipoA, ta.tipo, a.marca FROM salidaalimentos sa INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE sa.idSalidaA = ?");
      $query->bindValue(1, $this->id);
      $query->execute();
      $tipoalimento = $query->fetchAll();
      $this->desconectarDB();
      return $tipoalimento;

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar los  tipos de alimentos: ' . $e->getMessage());
    }

  }

  public function alimento($idTipoA, $idInventarioA)
  {
    $errores = [];
    if (!preg_match("/^[0-9]{1,}$/", $idTipoA)) {
      $errores[] = 'Ingresar el  id del tipo';
    }
    if (!preg_match("/^[0-9]{1,}$/", $idInventarioA)) {
      $errores[] = 'Ingresar el id de la salida';
    }
    if (!empty($errores)) {
      return ['resultado' => implode(", ", $errores)];

    } else {
      $this->tipoA = $idTipoA;
      $this->id = $idInventarioA;
      return $this->muestraA();
    }
  }

  private function muestraA()
  {
    try {
      $this->conectarDB();
      $query = $this->conex->prepare("SELECT imgAlimento, codigo, nombre, marca, unidadMedida, cantidad, fecha, hora, descripcion, tipoSalida  FROM vista_detalle_salida_alimentos WHERE idTipoA = ? AND idSalidaA = ?");
      $query->bindValue(1, $this->tipoA);
      $query->bindValue(2, $this->id);
      $query->execute();
      $alimento = $query->fetchAll();
      $this->desconectarDB();
      return $alimento;

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar los alimentos: ' . $e->getMessage());
    }
  }

  public function verificarAnulacion($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar el id del registro'];
    } else {
      $this->id = $id;
      $resultado = $this->verificarA();
      return $resultado === true ? ['resultado' => 'no se puede'] : ['resultado' => 'se puede'];
    }
  }

  private function verificarA()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare(" SELECT sa.idSalidaA FROM salidaalimentos sa INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento WHERE sa.idSalidaA = ? AND sa.fecha < CURRENT_DATE;");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      return array("Sistema", "¡Error Sistema!");
    }

  }

  public function anularSalidaAlimento($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar el id del registro a anular'];
    } 

    if($this->verificarExistencia($id)['resultado'] === 'ya no existe'){
      return ['resultado' => 'ya no existe'];
    }
    if($this->verificarAnulacion($id)['resultado'] === 'no se puede'){
      return ['resultado' => 'no se puede'];
    }
      $this->id = $id;
      return $this->anular();
    
  }

  private function anular()
  {
    try {
      $this->conectarDB();
      $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
      $this->conex->beginTransaction();
      $query = $this->conex->prepare("SELECT * FROM salidaalimentos WHERE idSalidaA = ? FOR UPDATE");
      $query->bindValue(1, $this->id);
      $query->execute();
      $data = $query->fetchAll();

      if ($data) {
        $fecha = $data[0]['fecha'];
        $descripcion = $data[0]['descripcion'];
        $new = $this->conex->prepare("UPDATE `salidaalimentos` SET status = 0 WHERE `idSalidaA` = ?");
        $new->bindValue(1, $this->id);
        $new->execute();

        $this->anularDetalle($this->id);
        $this->restarCantidadStock($this->id);

        if ($new->rowCount() > 0) {

          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Inventario de Alimentos - Salida', 'Se anuló la salida de alimentos de la fecha: ' . $fecha . 'con la descripcion: ' . $descripcion, $this->payload->cedula);

          $this->conex->commit();
          return ['resultado' => 'eliminado'];
        } else {
          $this->conex->rollBack();
          return ['mensaje' => 'No se encontró el alimento o no se pudo anular'];
        }
      } else {
        $this->conex->rollBack();
        return ['mensaje' => 'No se encontró alimentos'];
      }
    } catch (\PDOException $e) {

      $this->conex->rollBack();
      throw new \RuntimeException('Error al anular la entrada de alimentos: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

  private function anularDetalle($id)
  {
    try {
      $new = $this->conex->prepare("UPDATE `detallesalidaa` SET status = 0 WHERE `idSalidaA` = ?");
      $new->bindValue(1, $id);
      $new->execute();
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al eliminar el detalle: ' . $e->getMessage());
    }

  }

  private function restarCantidadStock($id)
  {
    try {

      $query = $this->conex->prepare("SELECT a.idAlimento, a.stock, SUM(dsa.cantidad) as totalCantidad FROM salidaalimentos sa INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento WHERE sa.idSalidaA = ? GROUP BY a.idAlimento, a.stock;");
      $query->bindValue(1, $id);
      $query->execute();
      $data = $query->fetchAll(PDO::FETCH_OBJ);

      foreach ($data as $cant) {
        $nuevoStock = $cant->stock + $cant->totalCantidad;
        $idA = $cant->idAlimento;

        $updateStock = $this->conex->prepare("UPDATE alimento SET stock = ? WHERE idAlimento = ?");
        $updateStock->bindValue(1, $nuevoStock);
        $updateStock->bindValue(2, $idA);
        $updateStock->execute();
      }

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al retar el stock: ' . $e->getMessage());
    }

  }

  private function detalleAlimento($id, $returnData = false)
  {

    try {

      $this->id = $id;
      $this->conectarDB();
      $mostrar = $this->conex->prepare("SELECT * FROM vista_detalle_salida_alimentos WHERE idSalidaA = ? AND statusDetalle = 1 ");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();
      if ($returnData === true) {
        return $data;
      }

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar el detalle de alimentos: ' . $e->getMessage());
    }
  }

  private function detalleAlimentoTotal($fechaI, $fechaF, $returnData = false)
  {

    try {
      $this->conectarDB();
      if (!empty($fechaI) && !empty($fechaF)) {

        $new = $this->conex->prepare(" SELECT * FROM vista_detalle_salida_alimentos  WHERE statusDetalle = 1 AND fecha BETWEEN ? AND ?");
        $new->bindValue(1, $fechaI);
        $new->bindValue(2, $fechaF);
        $new->execute();
        $data = $new->fetchAll(\PDO::FETCH_OBJ);

      } else {
        $mostrar = $this->conex->prepare(" SELECT * FROM vista_detalle_salida_alimentos WHERE statusDetalle = 1 ");
        $mostrar->execute();
        $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
      }
      $this->desconectarDB();

      if ($returnData === true) {
        return $data;
      }

    } catch (\Exception $e) {
      throw new \RuntimeException('Error del total alimentos: ' . $e->getMessage());
    }
  }

  /*-------LA FUNCION PARA El PDFD--------*/
  public function fpdf($id)
  {

    try {
      $this->id = $id;
      $this->conectarDB();
      $new = $this->conex->prepare(" SELECT * FROM salidaalimentos sa INNER JOIN tiposalidas ts ON sa.idTipoSalidaA = ts.idTipoSalidas  WHERE sa.idSalidaA =? ");
      $new->bindValue(1, $this->id);
      $new->execute();
      $info = $new->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();

      $descripcion = $info;
      $detalle = $this->detalleAlimento($this->id, true);

      $data = [
        'descripcion' => $descripcion,
        'detalle' => $detalle
      ];

      /*-------fDFD--------*/

      $reporte = new reporte;
      $reporte->AddPage();
      $reporte->salidaAlimentos($data);
      $reporte->Output();
      /*-------pfdf--------*/
    } catch (\PDOException $e) {
      return $e;
    }
  }


  public function fpdf2($fechaI, $fechaF)
  {
    $this->fechaI = $fechaI;
    $this->fechaF = $fechaF;
    try {
      $detalle = $this->detalleAlimentoTotal($this->fechaI, $this->fechaF, true);
      $data = [
        'fechaI' => $this->fechaI,
        'fechaF' => $this->fechaF,
        'detalle' => $detalle
      ]; // Convertir $data en un objeto de tipo stdClass
      $reporte = new reporte;
      $reporte->AddPage();
      $reporte->salidaAlimentosTotal($data);
      $reporte->Output();
    } catch (\PDOException $e) {
      return $e;
    }
  }


}

?>