<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;
use modelo\reporteModelo as reporte;


class consultarEntradaAlimentosModelo extends connectDB
{
  private $tipoA;
  private $alimento;
  private $marca;
  private $cantidad;
  private $imagen;
  private $id;
  private $fechaInicio;
  private $fechaFin;
  private $payload;

  public function __construct()
  {
    parent::__construct();
    $token = $_COOKIE['jwt'];
    $this->payload = JwtHelpers::validarToken($token);
  }

  public function mostrarEntradaAlimentos($fechaInicio, $fechaFin)
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
      return $this->mostrarEA();
    }
  }



  private function mostrarEA()
  {
    try {
      if (!empty($this->fechaInicio) && !empty($this->fechaFin)) {
        return $this->mostrarEAconFiltros();
      } else {
        return $this->mostrarEAsinFiltros();
      }

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al validar las fechas: ' . $e->getMessage());
    }
  }


  private function mostrarEAconFiltros()
  {
    try {
      $this->conectarDB();
      $new = $this->conex->prepare(" SELECT * FROM entradaalimento  WHERE status =1 and  fecha BETWEEN ? AND ?");
      $new->bindValue(1, $this->fechaInicio);
      $new->bindValue(2, $this->fechaFin);
      $new->execute();
      $entradaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
      $bitacora = new bitacoraModelo;
      $bitacora->registrarBitacora('Inventario de los Alimentos - Entrada', 'Consultó las entradas  de los alimentos de la fecha : ' . $this->fechaInicio . ' hasta la fecha: ' . $this->fechaFin, $this->payload->cedula);
      $this->desconectarDB();
      return $entradaAlimentos;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar las entradas de alimentos sin filtros: ' . $e->getMessage());
    }

  }

  private function mostrarEAsinFiltros()
  {
    try {
      $this->conectarDB();
      $new = $this->conex->prepare(" SELECT * FROM entradaalimento  WHERE status =1 ");
      $new->execute();
      $entradaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
      $bitacora = new bitacoraModelo;
      $bitacora->registrarBitacora('Inventario de los Alimentos - Entrada', 'Consultó las entradas de los alimentos', $this->payload->cedula);
      $this->desconectarDB();
      return $entradaAlimentos;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar las entradas de alimentos con filtros: ' . $e->getMessage());
    }

  }

  public function verificarExistencia($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar la entrada de alimentos'];
    } else {
      $this->id = $id;
      $resultado = $this->verificarE();
      return $resultado === true ? ['resultado' => 'si esta'] : ['resultado' => 'no esta'];
    }
  }

  private function verificarE()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare(" SELECT * FROM entradaalimento WHERE idEntradaA = ? and status =1");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia de la entrada de alimentos: ' . $e->getMessage());
    }
  }

  public function tipoalimento($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar los tipos de alimentos del registro'];
    } else {
      $this->id = $id;
      return $this->tipo();
    }
  }


  private function tipo()
  {

    try {
      $this->conectarDB();
      $query = $this->conex->prepare("SELECT DISTINCT ta.idTipoA, ta.tipo, a.marca FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE ea.idEntradaA = ?");
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
      $errores[] = 'Ingresar el id de la entrada';
    }
    if (!empty($errores)) {
      $mensaje = ['resultado' => implode(", ", $errores)];
      return $mensaje;
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
      $query = $this->conex->prepare(" SELECT imgAlimento, codigo, nombre, marca, unidadMedida, cantidad, fecha, hora, descripcion  FROM vista_alimentos_entrada  WHERE idTipoA = ? AND idEntradaA = ? AND status = 1");
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
      $mostrar = $this->conex->prepare("SELECT ea.idEntradaA, dea.idAlimento FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA LEFT JOIN detallesalidaa dsa ON dsa.idAlimento = dea.idAlimento AND dsa.status = 1 LEFT JOIN salidaalimentos sa ON sa.idSalidaA = dsa.idSalidaA AND sa.status = 1 LEFT JOIN detallesalidamenu dsm ON dsm.idAlimento = dea.idAlimento AND dsm.status = 1 LEFT JOIN menu m ON m.idMenu = dsm.idMenu AND m.status = 1 WHERE ea.idEntradaA = ? AND ea.fecha <= COALESCE(sa.fecha, m.feMenu) AND (dsa.idAlimento IS NOT NULL OR dsm.idAlimento IS NOT NULL);");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar los alimentos: ' . $e->getMessage());
    }

  }

  public function anularEntradaAlimento($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar el id del registro a anular'];
    } else {
      $this->id = $id;
      return $this->anular();
    }
  }

  private function anular()
  {
    try {
      $this->conectarDB();
      $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
      $this->conex->beginTransaction();
      $query = $this->conex->prepare("SELECT * FROM entradaalimento WHERE idEntradaA = ? FOR UPDATE ");
      $query->bindValue(1, $this->id);
      $query->execute();
      $data = $query->fetchAll();

      if ($data) {
        $fecha = $data[0]['fecha'];
        $descripcion = $data[0]['descripcion'];
        $new = $this->conex->prepare("UPDATE `entradaalimento` SET status = 0 WHERE `idEntradaA` = ?");
        $new->bindValue(1, $this->id);
        $new->execute();

        $this->anularDetalle($this->id);
        $this->restarCantidadStock($this->id);
        if ($new->rowCount() > 0) {

          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Inventario de Alimentos - Entrada', 'Se anuló la entrada de alimentos de la fecha: ' . $fecha . 'con la descripcion: ' . $descripcion, $this->payload->cedula);
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
      $new = $this->conex->prepare("UPDATE `detalleentradaa` SET status = 0 WHERE `idEntradaA` = ?");
      $new->bindValue(1, $id);
      $new->execute();
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al eliminar el detalle: ' . $e->getMessage());
    }

  }

  private function restarCantidadStock($id)
  {
    try {
      $query = $this->conex->prepare("SELECT a.idAlimento, a.stock, SUM(dea.cantidad) as totalCantidad FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento WHERE ea.idEntradaA = ? GROUP BY a.idAlimento, a.stock");
      $query->bindValue(1, $id);
      $query->execute();
      $data = $query->fetchAll(PDO::FETCH_OBJ);

      foreach ($data as $cant) {
        $nuevoStock = $cant->stock - $cant->totalCantidad;
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
      $this->conectarDB();
      $this->id = $id;
      $mostrar = $this->conex->prepare(" SELECT * FROM vista_alimentos_entrada WHERE idEntradaA = ? AND status = 1");
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

        $new = $this->conex->prepare("SELECT * FROM vista_alimentos_entrada WHERE status = 1 AND fecha BETWEEN ? AND ?");
        $new->bindValue(1, $fechaI);
        $new->bindValue(2, $fechaF);
        $new->execute();
        $data = $new->fetchAll(\PDO::FETCH_OBJ);

      } else {
        $mostrar = $this->conex->prepare("SELECT * FROM vista_alimentos_entrada WHERE status = 1");
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
      $new = $this->conex->prepare(" SELECT * FROM entradaalimento  WHERE idEntradaA =? and status=1");
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
      $reporte->entradaAlimentos($data);
      $reporte->Output();
      /*-------pfdf--------*/
    } catch (\PDOException $e) {
      return $e;
    } finally {
      $this->cerrarConex;
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
      ];
      $reporte = new reporte;
      $reporte->AddPage();
      $reporte->entradaAlimentosTotal($data);
      $reporte->Output();
    } catch (\PDOException $e) {
      return $e;
    }
  }
}

?>