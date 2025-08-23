<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
 use modelo\reporteModelo as reporte; 


class stockAlimentosModelo extends connectDB {
	private $detalle;


	 public function __construct(){
        parent::__construct(); 
    }

    public function mostrarAlimentos($returnData = false) {
        try {
            $this->conectarDB();
            $new = $this->conex->prepare(" SELECT * FROM alimento a INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE a.status =1 and a.stock > 0 or a.reservado > 0");
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);
            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Inventario de Alimentos - Stock', 'Consultó los estocks de los alimentos', $_SESSION['cedula']);
            $this->desconectarDB();
            if ($returnData === true) {
               return $data;
           }
           else{
            echo json_encode($data);
            die(); 
           }
            
        } catch (\PDOException $e) {
            return $e;
        }
      }  

 
/*-------LA FUNCION PARA El PDFD--------*/
      public function fpdf(){
        
           try {
    
               $detalle=$this->mostrarAlimentos(true);
               $data = [
                   'detalle'=>$detalle
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
