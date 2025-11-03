<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;
use modelo\reporteModelo as reporte;


class stockAlimentosModelo extends connectDB
{
  private $tipoA;
  private $detalle;
  private $payload;
  private $alimento;



  public function __construct()
  {
    parent::__construct();
    $token = $_COOKIE['jwt'];
    $this->payload = JwtHelpers::validarToken($token);
  }

  public function verificarExistenciaTipoA($tipoA)
  {
    if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
      return ['resultado' => 'Ingresar el tipo de alimento'];
    } else {
      $this->tipoA = $tipoA;
      $resultado = $this->verificarETA();
      return $resultado === true ? ['resultado' => 'si esta'] : ['resultado' => 'no esta'];
    }
  }

  private function verificarETA()
  {

    try {
      $this->conectarDB();
      $verificar = $this->conex->prepare("SELECT idTipoA FROM tipoalimento WHERE idTipoA=? and status = 1");
      $verificar->bindValue(1, $this->tipoA);
      $verificar->execute();
      $data = $verificar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia del tipo de alimento: ' . $e->getMessage());
    }
  }

  public function mostrarTipoAlimento()
  {
    try {
      $this->conectarDB();
      $registrar = $this->conex->prepare("SELECT * FROM `tipoalimento` WHERE status =1 ");
      $registrar->execute();
      $data = $registrar->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();
      return $data;

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar el tipo de alimento: ' . $e->getMessage());
    }
  }


  public function mostrarAlimentos($tipoA)
  {
    if (!preg_match("/^(|Seleccionar|\d+)$/", $tipoA)) {
      return ['resultado' => 'Seleccionar el tipo de alimento'];
    } else {
      $this->tipoA = $tipoA;
      return $this->mostrarA();
    }
  }

  private function consultarAlimentosPorTipo()
  {
    $consulta = $this->conex->prepare("SELECT *  FROM alimento a  INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA  WHERE a.idTipoA = ? AND a.status = 1 AND (a.stock > 0 OR a.reservado > 0)");
    $consulta->bindValue(1, $this->tipoA);
    $consulta->execute();
    return $consulta->fetchAll(\PDO::FETCH_OBJ);
  }

 private function consultarTodosLosAlimentos()
  {
    $consulta = $this->conex->prepare(" SELECT * FROM alimento a INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE a.status = 1 AND (a.stock > 0 OR a.reservado > 0)");
    $consulta->execute();
    return $consulta->fetchAll(\PDO::FETCH_OBJ);
  }

  private function mostrarA()
  {
    try {
      $this->conectarDB();

      if ($this->tipoA !== 'Seleccionar' && !empty($this->tipoA)) {
        $data = $this->consultarAlimentosPorTipo();
      } else {
        $data = $this->consultarTodosLosAlimentos();
      }

      $bitacora = new bitacoraModelo;
      $bitacora->registrarBitacora('Inventario de Alimentos - Stock', 'Consultó los estocks de los alimentos', $this->payload->cedula);
      $this->desconectarDB();
      return $data;

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar el stock de los alimentos: ' . $e->getMessage());
    }
  }

public function buscarAlimentoPaginado($alimento, $limit, $offset)
{
  $alimentoBuscado = '%' . $alimento . '%';
  try {
    $this->conectarDB();
    $consultar = $this->conex->prepare("SELECT idAlimento, imgAlimento, nombre, marca, stock, reservado FROM alimento WHERE nombre LIKE ? AND (stock > 0 OR reservado > 0) ORDER BY nombre LIMIT ? OFFSET ?");
    $consultar->bindValue(1, $alimentoBuscado);
    $consultar->bindValue(2, (int) $limit, \PDO::PARAM_INT);
    $consultar->bindValue(3, (int) $offset, \PDO::PARAM_INT);
    $consultar->execute();
    $data = $consultar->fetchAll(\PDO::FETCH_OBJ);
    $this->desconectarDB();
    return $data;
  } catch (\Exception $e) {
    throw new \RuntimeException('Error al buscar el alimento paginado: ' . $e->getMessage());
  }
}

public function alimentosPaginado($limit, $offset)
{
  try {
    $this->conectarDB();
    $consulta = $this->conex->prepare("
      SELECT a.*, ta.*
      FROM alimento a
      INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA
      WHERE a.status = 1 AND (a.stock > 0 OR a.reservado > 0)
      ORDER BY a.nombre LIMIT ? OFFSET ?
    ");
    $consulta->bindValue(1, (int) $limit, \PDO::PARAM_INT);
    $consulta->bindValue(2, (int) $offset, \PDO::PARAM_INT);
    $consulta->execute();
    $result = $consulta->fetchAll(\PDO::FETCH_ASSOC);
    $this->desconectarDB();
    return $result;
  } catch (\Exception $e) {
    throw new \RuntimeException('Error al obtener el stock paginado: ' . $e->getMessage());
  }
}

public function contarAlimentosTotales()
{
  try {
    $this->conectarDB();
    $consulta = $this->conex->prepare("SELECT COUNT(*) FROM alimento WHERE status = 1 AND (stock > 0 OR reservado > 0)");
    $consulta->execute();
    $count = $consulta->fetchColumn();
    $this->desconectarDB();
    return $count;
  } catch (\Exception $e) {
    throw new \RuntimeException('Error al contar los alimentos: ' . $e->getMessage());
  }
}

  public function fpdf($tipoA)
  {

    try {

      $detalle = $this->mostrarAlimentos($tipoA);
      $data = [
        'detalle' => $detalle
      ];

      $reporte = new reporte;
      $reporte->AddPage();
      $reporte->stockAlimentos($data);
      $reporte->Output();
      /*-------pfdf--------*/
    } catch (\PDOException $e) {
      return $e;
    }
  }

}

?>