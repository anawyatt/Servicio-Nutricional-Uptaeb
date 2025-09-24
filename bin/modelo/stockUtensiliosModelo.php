<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;
use modelo\reporteModelo as reporte; 

class stockUtensiliosModelo extends connectDB {
  private $tipoU;
  private $utensilios;
  private $material;
  private $imagen;
  private $id;
  private $payload;
  private $utensilio;

  public function __construct()
  {
    parent::__construct();
    $token = $_COOKIE['jwt'];
    $this->payload = JwtHelpers::validarToken($token);
  }

  public function mostrarUtensilios() {
    try {
      $this->conectarDB();
      $stmt = $this->conex->prepare("
        SELECT * FROM utensilios u
        INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU
        WHERE u.status = 1 AND u.stock > 0
      ");
      $stmt->execute();
      $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();

      return $data;
    } catch (\PDOException $e) {
      $this->desconectarDB();
      return ['error' => 'Error en la base de datos', 'detalle' => $e->getMessage()];
    }
  }

public function mostrarUtensiliosPaginado($limite, $offset) {
  try {
    $this->conectarDB();
    $stmt = $this->conex->prepare("
      SELECT * FROM utensilios u
      INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU
      WHERE u.status = 1 AND u.stock > 0
      LIMIT :limite OFFSET :offset
    ");
    $stmt->bindValue(':limite', (int) $limite, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
    $this->desconectarDB();
    return $data;
  } catch (\PDOException $e) {
    $this->desconectarDB();
    return ['error' => 'Error en la base de datos', 'detalle' => $e->getMessage()];
  }
}

public function buscarUtensilioPaginado($utensilio, $limite, $offset) {
  if (empty($utensilio)) {
    return $this->mostrarUtensiliosPaginado($limite, $offset);
  } else {
    $this->utensilio = $utensilio;
    return $this->mostrarUtensilioBuscadorPaginado($limite, $offset);
  }
}

private function mostrarUtensilioBuscadorPaginado($limite, $offset) {
  $utensilioBuscado = '%' . $this->utensilio . '%';
  try {
    $this->conectarDB();
    $consultar = $this->conex->prepare("
      SELECT idUtensilios, imgUtensilios, nombre, material, stock
      FROM utensilios
      WHERE nombre LIKE ? AND stock > 0 AND status = 1
      LIMIT ? OFFSET ?
    ");
    $consultar->bindValue(1, $utensilioBuscado);
    $consultar->bindValue(2, (int) $limite, \PDO::PARAM_INT);
    $consultar->bindValue(3, (int) $offset, \PDO::PARAM_INT);
    $consultar->execute();
    $data = $consultar->fetchAll(\PDO::FETCH_OBJ);
    $this->desconectarDB();
    return $data;
  } catch (\Exception $e) {
    throw new \RuntimeException('Error al mostrar los utensilios: ' . $e->getMessage());
  }
}

  public function fpdf() {
    try {
      $detalle = $this->mostrarUtensilios();
      $data = [
        'detalle' => $detalle
      ];

      $reporte = new reporte;
      $reporte->AddPage();
      $reporte->stockUtensilios($data);
      $reporte->Output();
    } catch (\PDOException $e) {
      return $e;
    }
  }

}
?>
