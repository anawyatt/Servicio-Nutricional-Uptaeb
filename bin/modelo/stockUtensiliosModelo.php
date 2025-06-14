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

    public function __construct() {
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

      public function fpdf(){
        
        try {
 
            $detalle=$this->mostrarUtensilios(false);
            $data = [
                'detalle'=>$detalle
            ];
    
            /*-------fDFD--------*/
       
           $reporte = new reporte;
           $reporte->AddPage();
           $reporte->stockUtensilios($data);
           $reporte->Output();
            /*-------pfdf--------*/
        } catch (\PDOException $e) {
            return $e;
        }
    }

}

?>
