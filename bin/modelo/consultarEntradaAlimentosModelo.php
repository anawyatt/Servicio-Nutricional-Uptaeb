<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
 use modelo\reporteModelo as reporte; 


class consultarEntradaAlimentosModelo extends connectDB {
	private $tipoA;
	private $alimento;
	private $marca;
	private $cantidad;
	private $imagen;
	private $id;

	 public function __construct(){
        parent::__construct(); 
    }

    public function mostrarEntradaAlimentos($fechaInicio, $fechaFin, $returnJson = true) { 
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
          // Asignar las fechas a las propiedades de la clase si son válidas
          $this->fechaInicio = $fechaInicio;
          $this->fechaFin = $fechaFin;
          return $this->mostrarEA();
      }
  }
  
  
  
    private function mostrarEA() {
        try {
            
            if(!empty($this->fechaInicio) && !empty($this->fechaFin)){ 

               $this->mostrarEAconFiltros();

            }else{

                $this->mostrarEAsinFiltros();
            }
             

        } catch (\PDOException $e) {
            return $e;
        }
      } 


  private function mostrarEAconFiltros($returnJson=true){
        try {
          $this->conectarDB();
           $new = $this->conex->prepare(" SELECT * FROM entradaalimento  WHERE status =1 and  fecha BETWEEN ? AND ?");
            $new->bindValue(1, $this->fechaInicio);
            $new->bindValue(2, $this->fechaFin);
            $new->execute();
            $entradaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
             $bitacora = new bitacoraModelo;
             $bitacora->registrarBitacora('Inventario de los Alimentos - Entrada', 'Consultó las entradas  de los alimentos de la fecha : '.$this->fechaInicio.' hasta la fecha: '.$this->fechaFin, $_SESSION['cedula']);
             $this->desconectarDB();
             if ($returnJson) {
              echo json_encode($entradaAlimentos);
              die();
            }
           return $entradaAlimentos;
        }catch(exection $error){
            return array("Sistema", "¡Error Sistema!");
        }
         
      }

      private function mostrarEAsinFiltros($returnJson=true){
        try {
           $this->conectarDB();
           $new = $this->conex->prepare(" SELECT * FROM entradaalimento  WHERE status =1 ");
           $new->execute();
           $entradaAlimentos = $new->fetchAll(\PDO::FETCH_OBJ);
           $bitacora = new bitacoraModelo;
           $bitacora->registrarBitacora('Inventario de los Alimentos - Entrada', 'Consultó las entradas de los alimentos', $_SESSION['cedula']);
            $this->desconectarDB();
            if ($returnJson) {
              echo json_encode($entradaAlimentos);
              die();
            }
           return $entradaAlimentos;
            
        }catch(exection $error){
            return array("Sistema", "¡Error Sistema!");
        }
         
      }

  public function verificarExistencia($id,$returnJson=true){
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $resultado = ['resultado' => 'Seleccionar la entrada de alimentos'];
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
      $mostrar=$this->conex->prepare(" SELECT * FROM entradaalimento WHERE idEntradaA = ? and status =1");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
       $this->desconectarDB();

       if (!isset( $data[0]["idEntradaA"])) {

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
         return $this->tipo($returnJson);
     }
   }


     private function tipo($returnJson) {
     
         try {
            $this->conectarDB();
            $query = $this->conex->prepare("SELECT DISTINCT ta.idTipoA, ta.tipo FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE ea.idEntradaA = ?");
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
      $errores[] = 'Ingresar el id de la entrada';
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
            $query = $this->conex->prepare("SELECT a.imgAlimento, a.codigo, a.nombre, a.marca, a.unidadMedida, dea.cantidad, ea.fecha, ea.hora, ea.descripcion FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE ta.idTipoA= ? and ea.idEntradaA =  ?");
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
      $mostrar=$this->conex->prepare("SELECT ea.idEntradaA, dea.idAlimento FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA LEFT JOIN detallesalidaa dsa ON dsa.idAlimento = dea.idAlimento AND dsa.status = 1 LEFT JOIN salidaalimentos sa ON sa.idSalidaA = dsa.idSalidaA AND sa.status = 1 LEFT JOIN detallesalidamenu dsm ON dsm.idAlimento = dea.idAlimento AND dsm.status = 1 LEFT JOIN menu m ON m.idMenu = dsm.idMenu AND m.status = 1 WHERE ea.idEntradaA = ? AND ea.fecha <= COALESCE(sa.fecha, m.feMenu) AND (dsa.idAlimento IS NOT NULL OR dsm.idAlimento IS NOT NULL);");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
       $this->desconectarDB();

       if (isset( $data[0]["idEntradaA"])) {
      
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

 public function anularEntradaAlimento($id, $returnJson=true) {
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
       $query = $this->conex->prepare("SELECT * FROM  entradaalimento WHERE idEntradaA = ?");
        $query->bindValue(1, $this->id);
        $query->execute();
        $data = $query->fetchAll();

        if ($data) {  
        $fecha = $data[0]['fecha'];
        $descripcion= $data[0]['descripcion'];
        $new = $this->conex->prepare("UPDATE `entradaalimento` SET status = 0 WHERE `idEntradaA` = ?");
        $new->bindValue(1, $this->id);
        $new->execute();

        $anularDetalleInventario = $this->anularDetalle($this->id);
        $restaurarStock = $this->restarCantidadStock($this->id);
          if ($new->rowCount() > 0) {
                
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Inventario de Alimentos - Entrada', 'Se anuló la entrada de alimentos de la fecha: ' . $fecha. 'con la descripcion: '.$descripcion, $_SESSION['cedula']);
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
}


private function anularDetalle($id) {
    try {
        $new = $this->conex->prepare("UPDATE `detalleentradaa` SET status = 0 WHERE `idEntradaA` = ?");
        $new->bindValue(1, $id);
        $new->execute();
    } catch (PDOException $e) {
        return $e->getMessage();
    }
    
}

private function restarCantidadStock($id) {
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

    } catch (PDOException $e) {
        return $e->getMessage();
    }
    
}

private function detalleAlimento($id, $returnData = false){
 
    try{
        $this->conectarDB();
        $this->id = $id;
         $mostrar=$this->conex->prepare(" SELECT * FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE ea.idEntradaA = ? and ea.status=1; ");
         $mostrar->bindValue(1, $this->id);
         $mostrar->execute();
         $this->desconectarDB();
         
         $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
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

            $new = $this->conex->prepare(" SELECT * FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE  ea.status=1 and  ea.fecha BETWEEN ? AND ?");
            $new->bindValue(1, $fechaI);
            $new->bindValue(2, $fechaF);
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);

       }else{
            $mostrar=$this->conex->prepare("SELECT * FROM entradaalimento ea INNER JOIN detalleentradaa dea ON dea.idEntradaA = ea.idEntradaA INNER JOIN alimento a ON a.idAlimento = dea.idAlimento INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE  ea.status=1");
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
            $new = $this->conex->prepare(" SELECT * FROM entradaalimento  WHERE idEntradaA =? and status=1");
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
              $reporte->entradaAlimentos($data);
              $reporte->Output();
               /*-------pfdf--------*/
           } catch (\PDOException $e) {
               return $e;
           }
           finally {
          $this->cerrarConex;
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
