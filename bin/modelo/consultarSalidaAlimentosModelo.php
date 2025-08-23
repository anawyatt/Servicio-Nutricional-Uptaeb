<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
use modelo\reporteModelo as reporte; 


class consultarSalidaAlimentosModelo extends connectDB {
	private $tipoA;
	private $alimento;
	private $marca;
	private $cantidad;
	private $imagen;
	private $id;

	 public function __construct(){
        parent::__construct(); 
    }

 

     public function mostrarSalidaAlimentos($fechaInicio, $fechaFin, $returnJson=true) {
      $errores = [];
      $regexFecha = "/^\d{4}-\d{2}-\d{2}$/";
  
      // Verificar que ambas fechas puedan estar vacías o en formato válido
      if (!empty($fechaInicio) && !preg_match($regexFecha, $fechaInicio)) {
          $errores[] = "La fecha de inicio debe estar en formato YYYY-MM-DD o estar vacía.";
      }
      if (!empty($fechaFin) && !preg_match($regexFecha, $fechaFin)) {
          $errores[] = "La fecha de fin debe estar en formato YYYY-MM-DD o estar vacía.";
      }
      // Validar que la fecha de inicio no sea mayor que la fecha de fin, solo si ambas están presentes
      if (!empty($fechaInicio) && !empty($fechaFin) && strtotime($fechaInicio) > strtotime($fechaFin)) {
          $errores[] = "La fecha de inicio no puede ser mayor que la fecha de fin.";
      }
      // Si hay errores, retornar el mensaje
      if (!empty($errores)) {
          $mensaje = ['resultado' => implode(", ", $errores)];
          if ($returnJson) {
              echo json_encode($mensaje);
              die();
          }
          return $mensaje;
      } else {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin= $fechaFin;
        return $this->mostrarSA();
       }
     }

     
    private function mostrarSA(){
        try {
           if(!empty($this->fechaInicio) && !empty($this->fechaFin)){ 
               $this->mostrarSAconFiltros();
            }else{
                $this->mostrarSAsinFiltros();
            }
            
        } catch (\PDOException $e) {
            return $e;
        }

      }  


      private function mostrarSAconFiltros($returnJson=true){
        try {
             $this->conectarDB();
            $new = $this->conex->prepare("SELECT * FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA WHERE sa.status =1 and ts.tipoSalida != 'Menú' and  sa.fecha BETWEEN ? AND ?");
            $new->bindValue(1, $this->fechaInicio);
            $new->bindValue(2, $this->fechaFin);
            $new->execute();
            $salidaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
             $bitacora = new bitacoraModelo;
             $bitacora->registrarBitacora('Inventario de los Alimentos - Salida', 'Consultó las salidas de los alimentos de la fecha : '.$this->fechaInicio.' hasta la fecha: '.$this->fechaFin, $_SESSION['cedula']);
             if ($returnJson) {
                echo json_encode($salidaAlimentos);
                die();
              }
             return $salidaAlimentos;
            
        }catch(exection $error){
            return array("Sistema", "¡Error Sistema!");
        }
 
      }

      private function mostrarSAsinFiltros($returnJson=true){
        try {
             $this->conectarDB();
            $new = $this->conex->prepare(" SELECT * FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA WHERE sa.status =1 and ts.tipoSalida != 'Menú'; ");
            $new->execute();
            $salidaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
             $bitacora = new bitacoraModelo;
             $bitacora->registrarBitacora('Inventario de los Alimentos - Salida', 'Consultó las salidas de los alimentos', $_SESSION['cedula']);
             if ($returnJson) {
                echo json_encode($salidaAlimentos);
                die();
              }
             return $salidaAlimentos;
            
        }catch(exection $error){
            return array("Sistema", "¡Error Sistema!");
        }
      }


      public function verificarExistencia($id, $returnJson=true){
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            $resultado = ['resultado' => 'Seleccionar la Salida de alimentos'];
            if ($returnJson) {
                echo json_encode($resultado);
                die();
            } 
            return $resultado; 
        } else {
        $this->id=$id;
        return $this->verificarE($returnJson);
        }
      }
    
      private function verificarE($returnJson){
    
        try{
             $this->conectarDB();
    
          $mostrar=$this->conex->prepare(" SELECT * FROM salidaalimentos  WHERE idSalidaA = ? and status =1");
          $mostrar->bindValue(1, $this->id);
          $mostrar->execute();
          $data = $mostrar->fetchAll();
          $this->desconectarDB();
    
           if (!isset( $data[0]["idSalidaA"])) {
          
            $mensaje = ['resultado' => 'ya no existe'];
            if ($returnJson) {
              echo json_encode($mensaje);
              die();
            } 
            return $mensaje;
          }
          else{
            $mensaje = ['resultado' => 'si existe'];
            return $mensaje;
          }
        }
        catch(exection $error){
                return array("Sistema", "¡Error Sistema!");
    
        }
      }

    public function tipoalimento($id, $returnJson=true) {
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            $resultado = ['resultado' => 'Seleccionar los tipos de alimentos del registro'];
            if ($returnJson) {
                echo json_encode($resultado);
                die();
            } 
            return $resultado; 
           } else {
            $this->id = $id;
            return $this->tipoA($returnJson);
           }
    }

    private  function tipoA($returnJson) {
         try {
             $this->conectarDB();
            $query = $this->conex->prepare("SELECT DISTINCT ta.idTipoA, ta.tipo FROM salidaalimentos sa INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE sa.idSalidaA = ?");
            $query->bindValue(1, $this->id);
            $query->execute();
            $tipoalimento = $query->fetchAll();
            $this->desconectarDB();

             if ($returnJson) {
                echo json_encode($tipoalimento);
                die();
              } 
              return $tipoalimento; 
      
           } catch (\PDOException $e) {
              return $e;
          }
          
        }

    public function alimento($idTipoA, $idInventarioA, $returnJson=true) {
        $errores = [];
        if (!preg_match("/^[0-9]{1,}$/", $idTipoA)) {
           $errores[] = 'Ingresar el  id del tipo';
        } 
        if (!preg_match("/^[0-9]{1,}$/", $idInventarioA)) {
           $errores[] = 'Ingresar el id de la salida';
        }
        if (!empty($errores)) {
           $mensaje= ['resultado' => implode(", ", $errores)];
        if ($returnJson) {
           echo json_encode($mensaje);
           die();
        } 
          return $mensaje;
    }
    else{ 
         $this->tipoA = $idTipoA;
         $this->id = $idInventarioA;
         return $this->muestraA($returnJson);
    }
    }

    private function muestraA($returnJson) {
         try {
             $this->conectarDB();
            $query = $this->conex->prepare("SELECT a.imgAlimento, a.codigo, a.nombre, a.marca, a.unidadMedida, dsa.cantidad, sa.fecha, sa.hora, sa.descripcion, ts.tipoSalida  FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE ta.idTipoA= ? and sa.idSalidaA =?");
            $query->bindValue(1, $this->tipoA);
            $query->bindValue(2, $this->id);
            $query->execute();
            $alimento = $query->fetchAll();
            $this->desconectarDB();

            if ($returnJson) {
                echo json_encode($alimento);
                die();
              } 
              return $alimento;
      
           } catch (\PDOException $e) {
              return $e;
          }
        }

public function verificarAnulacion($id, $returnJson=true){
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
        $resultado = ['resultado' => 'Seleccionar el id del registro'];
        if ($returnJson) {
            echo json_encode($resultado);
            die();
        } 
        return $resultado; 
       } else {
         $this->id=$id;
         return $this->verificarA($returnJson);
       }
}

private function verificarA($returnJson){
    try{
      $this->conectarDB();
      $mostrar=$this->conex->prepare(" SELECT sa.idSalidaA FROM salidaalimentos sa INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento WHERE sa.idSalidaA = ? AND sa.fecha < CURRENT_DATE;");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();

       if (isset( $data[0]["idSalidaA"])) {
      
        $mensaje = ['resultado' => 'no se puede'];
        if ($returnJson) {
          echo json_encode($mensaje);
          die();
        } 
        return $mensaje; 
      }
      else{
        $mensaje = ['resultado' => 'se puede'];
        if ($returnJson) {
          echo json_encode($mensaje);
          die();
        } 
        return $mensaje; 
      }
    }
    catch(exection $error){
            return array("Sistema", "¡Error Sistema!");

    }
    
  }

 public function anularSalidaAlimento($id, $returnJson=true) {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
        $resultado = ['resultado' => 'Seleccionar el id del registro a anular'];
        if ($returnJson) {
           echo json_encode($resultado);
           die();
        } 
        return $resultado; 
      } else {
        $this->id = $id;
        return $this->anular($returnJson);
      }
}

private function anular($returnJson) {
    try { 
         $this->conectarDB();
       $this->conex->beginTransaction();
       $query = $this->conex->prepare("SELECT * FROM  salidaalimentos WHERE idSalidaA = ?");
        $query->bindValue(1, $this->id);
        $query->execute();
        $data = $query->fetchAll();

        if ($data) {
            $fecha = $data[0]['fecha'];
            $descripcion= $data[0]['descripcion'];
        $new = $this->conex->prepare("UPDATE `salidaalimentos` SET status = 0 WHERE `idSalidaA` = ?");
        $new->bindValue(1, $this->id);
        $new->execute();

        $anularDetalleInventario = $this->anularDetalle($this->id);
        $restaurarStock = $this->restarCantidadStock($this->id);

        if ($new->rowCount() > 0) {
                
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Inventario de Alimentos - Salida', 'Se anuló la salida de alimentos de la fecha: ' . $fecha. 'con la descripcion: '.$descripcion, $_SESSION['cedula']);

                
            $this->conex->commit();
            $mensaje = ['resultado' => 'eliminado'];
            if ($returnJson) {
              echo json_encode($mensaje);
              die();
           } 
           return $mensaje;
           } else {
                
                $this->conex->rollBack();
                echo json_encode(['mensaje' => 'No se encontró el alimento o no se pudo anular']);
            }
       } else {
            
            $this->conex->rollBack();
            echo json_encode(['mensaje' => 'No se encontró alimentos']);
        }
      }
        catch (\PDOException $e) {
        
        $this->conex->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
    finally {
            $this->desconectarDB();
         }
    die();
}

private function anularDetalle($id) {
    try {
        $new = $this->conex->prepare("UPDATE `detallesalidaa` SET status = 0 WHERE `idSalidaA` = ?");
        $new->bindValue(1, $id);
        $new->execute();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    
}

private function restarCantidadStock($id) {
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

    } catch (PDOException $e) {
        return $e->getMessage();
    }
   
}

private function detalleAlimento($id, $returnData = false){
 
    try{

        $this->id = $id;
         $this->conectarDB();
         $mostrar=$this->conex->prepare(" SELECT  * FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE sa.idSalidaA = ? and sa.status=1 ");
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

 private function detalleAlimentoTotal($fechaI, $fechaF,$returnData = false){
 
    try{
         $this->conectarDB();
      if(!empty($fechaI) && !empty($fechaF)){ 

            $new = $this->conex->prepare(" SELECT  * FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE  sa.status=1 and  sa.fecha BETWEEN ? AND ?");
            $new->bindValue(1, $fechaI);
            $new->bindValue(2, $fechaF);
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);

       }else{
            $mostrar=$this->conex->prepare(" SELECT  * FROM salidaalimentos sa INNER JOIN tiposalidas ts ON ts.idTipoSalidas = sa.idTipoSalidaA INNER JOIN detallesalidaa dsa ON dsa.idSalidaA = sa.idSalidaA INNER JOIN alimento a ON a.idAlimento = dsa.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE  sa.status=1; ");
             $mostrar->execute();
             $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
        }
        $this->desconectarDB();

         if ($returnData === true) {
               return $data;
           }
         
    }
    catch(exection $error){
         
         return array("Sistema", "¡Error Sistema!");
    }
 }

/*-------LA FUNCION PARA El PDFD--------*/
      public function fpdf($id){
        
           try {
            $this->id = $id;
             $this->conectarDB();
            $new = $this->conex->prepare(" SELECT * FROM salidaalimentos sa INNER JOIN tiposalidas ts ON sa.idTipoSalidaA = ts.idTipoSalidas  WHERE sa.idSalidaA =? ");
            $new->bindValue(1,$this->id );
            $new->execute();
            $info = $new->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();

               $descripcion=  $info;
               $detalle=$this->detalleAlimento($this->id, true);
              
               $data = [
                   'descripcion' => $descripcion,
                   'detalle'=>$detalle
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


 public function fpdf2($fechaI, $fechaF){
  $this->fechaI=$fechaI;
  $this->fechaF=$fechaF;
    try {
        $detalle = $this->detalleAlimentoTotal($this->fechaI,  $this->fechaF, true);
        $data = [
          'fechaI'=> $this->fechaI,
          'fechaF'=> $this->fechaF,
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
