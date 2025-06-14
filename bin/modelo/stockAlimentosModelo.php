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


  /*-------LA FUNCION PARA El PDFD--------*/
  public function fpdf($tipoA)
  {

    try {

      $detalle = $this->mostrarAlimentos($tipoA, false);
      $data = [
        'detalle' => $detalle
      ];

      /*-------fDFD--------*/

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