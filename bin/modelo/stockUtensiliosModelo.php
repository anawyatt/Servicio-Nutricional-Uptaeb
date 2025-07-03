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

  public function buscarUtensilio($utensilio) {
    if (empty($utensilio)) {
      return ['resultado' => 'Ingrese el nombre del utensilio'];
    } else {
      $this->utensilio = $utensilio;
      return $this->mostrarUtensilioBuscador();
    }
  }

  private function mostrarUtensilioBuscador() {
    $utensilioBuscado = '%' . $this->utensilio . '%';
    try {
      $this->conectarDB();
      $consultar = $this->conex->prepare("
        SELECT idUtensilios, imgUtensilios, nombre, material, stock
        FROM utensilios
        WHERE nombre LIKE ? AND stock > 0 AND status = 1
      ");
      $consultar->bindValue(1, $utensilioBuscado);
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
      $detalle = $this->mostrarUtensilios(false);
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
