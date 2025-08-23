<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;

class consultarAlimentosModelo extends connectDB {

	private $tipoA;
	private $alimento;
	private $marca;
	private $unidad;
	private $imagen;
	private $id;

	 public function __construct(){
        parent::__construct(); 
    }

     public function mostrarAlimentos($tipoA, $returnJson=true) {
      if (!preg_match("/^(|Seleccionar|\d+)$/", $tipoA)) {
        $resultado = ['resultado' => 'Seleccionar el tipo de alimento'];
        if ($returnJson) {
            echo json_encode($resultado);
            die();
        } 
        return $resultado; 
    }
    else {
        $this->tipoA=$tipoA;
        return $this->mostrarA($returnJson);
       }
     }

    private function mostrarA($returnJson) {
        try {
        $this->conectarDB();
          if($this->tipoA != 'Seleccionar' && !empty($this->tipoA)){ 
            $new = $this->conex->prepare(" SELECT * FROM alimento a INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE a.status =1 and ta.idTipoA = ? ");
            $new->bindValue(1, $this->tipoA);
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);

          }
          else{
             $new = $this->conex->prepare(" SELECT * FROM alimento a INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE a.status =1 ");
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);
          }

          $this->desconectarDB();
          if ($returnJson) {
            echo json_encode($data);
            die();
          } 
          return $data; 
        } catch (\PDOException $e) {
            
            return $e;
        }
      }  

  public function verificarExistencia($id, $returnJson=true){

    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $resultado = ['resultado' => 'id del alimento'];
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
      $mostrar=$this->conex->prepare(" SELECT * FROM alimento WHERE idAlimento = ? and status =1");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();
      

       if (!isset( $data[0]["idAlimento"])) {
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

  public function infoAlimento($id, $returnJson=true) {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $resultado = ['resultado' => 'Seleccionar el  alimento'];
      if ($returnJson) {
          echo json_encode($resultado);
          die();
      } 
      return $resultado; 
     } else {
       $this->id = $id;
       return $this->infoA($returnJson);
     }
  }


  private function infoA($returnJson) {

         try {
            $this->conectarDB();
            $query = $this->conex->prepare("SELECT * FROM alimento a INNER JOIN tipoalimento ta ON a.idTipoA = ta.idTipoA WHERE  a.idAlimento =?");
            $query->bindValue(1, $this->id);
            $query->execute();
            $data = $query->fetchAll();
            $this->desconectarDB();

            if ($returnJson) {
              echo json_encode($data);
              die();
            } 
            return $data; 
          
          } catch (\PDOException $e) {
              return $e;
          }
   }


    public function verificarExistenciaTipoA($tipoA, $returnJson=true){
      if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
        $resultado = ['resultado' => 'Seleccionar el tipo de alimento'];
        if ($returnJson) {
            echo json_encode($resultado);
            die();
        } 
        return $resultado; 
       } else {
        $this->tipoA=$tipoA;
        return $this->verificarETA($returnJson);
       }

    }

    private function verificarETA($returnJson){
      try{
        $this->conectarDB();
        $verificar=$this->conex->prepare("SELECT idTipoA FROM tipoalimento WHERE status=1  and idTipoA=? ");
        $verificar->bindValue(1, $this->tipoA);
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (!isset( $data[0]["idTipoA"])) {
          $mensaje = ['resultado' => 'no esta'];
          if ($returnJson) {
            echo json_encode($mensaje);
            die();
          } 
          return $mensaje; 
        }
        else{
          $mensaje = ['resultado' => 'si esta'];
          return $mensaje;
        }
      }
      catch(exection $error){
        
        return array("Sistema", "¡Error Sistema!");
      }
      
    }

	 public function mostrarTipoAlimento(){
        try{
            $this->conectarDB();
            $registrar = $this->conex->prepare("SELECT * FROM `tipoalimento` WHERE status =1 ");
            $registrar->execute();
            $data = $registrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();

        }catch(\PDOException $e){
            return $e;
         }
     }

public function verificarBoton($id, $returnJson=true){
  if (!preg_match("/^[0-9]{1,}$/", $id)) {
    $resultado = ['resultado' => 'Seleccionar el alimento'];
    if ($returnJson) {
        echo json_encode($resultado);
        die();
    } 
    return $resultado; 
   } else {
    $this->id=$id;
    return $this->verificarB($returnJson);
   }
}

private function verificarB($returnJson){
    try{
      $this->conectarDB();
      $mostrar=$this->conex->prepare(" SELECT idAlimento FROM alimento WHERE idAlimento=? and idAlimento IN (SELECT idAlimento FROM detalleentradaa WHERE status=1)");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();

       if (isset( $data[0]["idAlimento"])) {
      
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

   public function verificarAlimento($id,$tipoA, $alimento, $marca, $returnJson=true){
    $errores = [];
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $errores[] = 'Ingresar el codigo del alimento';
    }    
    if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
        $errores[] = 'Ingresar un tipo alimento correctamente';
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $alimento)) {
        $errores[] = 'Ingresar un alimento correctamente';
    }
    
    if (!preg_match("/^(Sin Marca|[a-zA-ZÀ-ÿ\s]{3,})$/", trim($marca))) {
      $errores[] = 'Ingresar una marca correctamente';
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
    
        $this->tipoA=$tipoA;
        $this->alimento=$alimento;
        $this->marca=$marca;
        $this->id=$id;
        return $this->verificarA($returnJson);
    }
  }

  private function verificarA($returnJson){
        
      try{
        $this->conectarDB();
        $verificar=$this->conex->prepare("SELECT nombre FROM alimento WHERE status =1  and idTipoA =? and nombre =? and marca =? and idAlimento !=? ");
        $verificar->bindValue(1, $this->tipoA);
        $verificar->bindValue(2, $this->alimento);
        $verificar->bindValue(3, $this->marca);
        $verificar->bindValue(4, $this->id);
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (isset($data[0]["nombre"])) {
          $mensaje = ['resultado' => 'existe'];
          if ($returnJson) {
            echo json_encode($mensaje);
            die();
          } 
          return $mensaje;
        }
        else{
          $mensaje = ['resultado' => 'no esta duplicado'];
          return $mensaje;
        }
      }
      catch(exection $error){
        
        return array("Sistema", "¡Error Sistema!");
      }
    }


  public function modificarAlimentos($id, $tipoA, $alimento, $marca,
  	$unidad, $returnJson=true){
      $errores = [];
      if (!preg_match("/^[0-9]{1,}$/", $id)) {
        $errores[] = 'Ingresar el id del alimento correctamente';
      }
      if (!preg_match("/^[0-9]{1,}$/", $tipoA)){
          $errores[] = 'Ingresar un tipo alimento correctamente';
      }
      if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $alimento)) {
          $errores[] = 'Ingresar un alimento correctamente';
      }
      if (!preg_match("/^(Sin Marca|[a-zA-ZÀ-ÿ\s]{3,})$/", $marca)) {
          $errores[] = 'Ingresar una marca correctamente';
      }
      if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{2,}$/", $unidad)) {
          $errores[] = 'Ingresar la unidad correctamente';
      }
  
      if (!empty($errores)) {
          var_dump($errores);
          $mensaje = ['resultado' => implode(", ", $errores)];
          if ($returnJson) {
              echo json_encode($mensaje);
              die();
          } 
          return $mensaje;
      } else {
  	    $codigo =$this->generarCodigo($alimento, $marca);
  	    $this->codigo=$codigo;
        $this->tipoA=$tipoA;
        $this->alimento=$alimento;
        $this->marca=$marca;
        $this->unidad=$unidad;
        $this->id=$id;
        return $this->modificarA($returnJson);
     }
  }

  private function modificarA($returnJson){

    try {
      $this->conectarDB();
      $this->conex->beginTransaction();

      $modificar=$this->conex->prepare(" UPDATE `alimento` SET `codigo`=?,`nombre`=?,`unidadMedida`=?,`marca`=?,`idTipoA`=? WHERE  idAlimento =?");
      $modificar->bindValue(1, $this->codigo);
      $modificar->bindValue(2, $this->alimento);
      $modificar->bindValue(3, $this->unidad);
      $modificar->bindValue(4, $this->marca);
      $modificar->bindValue(5, $this->tipoA);
      $modificar->bindValue(6, $this->id);
      $modificar->execute();

      if ($modificar->rowCount() > 0) {
            
            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Consultar Alimentos', 'Se Modificó los datos del Alimento:' . $this->alimento, $_SESSION['cedula']);
            $this->conex->commit();
            $mensaje=['resultado' => 'modificado'];
            if ($returnJson) {
              echo json_encode($mensaje);
              die();
            } 
            return $mensaje;

        } else {
            
            $this->conex->rollBack();
            $mensaje=['resultado' => 'No se encontró el alimento o no hubo cambios'];
            if ($returnJson) {
              echo json_encode($mensaje);
            } 
            return $mensaje;
        }
           
      } catch (\PDOException $e) {
        
        $this->conex->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
    finally {
         $this->desconectarDB();
    }
  }


  public function modificarImagen($imagen, $id,$returnJson=true) {
    $errores = [];
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $errores[] = 'Ingresar el id del alimento correctamente';
    }
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
      $errores[] = 'Error al cargar el archivo. Asegúrate de subir una imagen válida.';
     } else {
      $tipoArchivo = $_FILES['imagen']['type'];
      $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
  
      if (!in_array($tipoArchivo, $tiposPermitidos)) {
          $errores[] = 'Ingresar una imagen correctamente (jpg, jpeg, png, gif)';
      }
    }
    if (!empty($errores)) {
      var_dump($errores);
      $mensaje = ['resultado' => implode(", ", $errores)];
      if ($returnJson) {
          echo json_encode($mensaje);
          die();
      } 
      return $mensaje;
    } else {
        $info= $this->infoAlimento($id, false);
        $rand = $this->generarCodigo($info[0]['nombre'], $info[0]['marca']);
        $this->img = $imagen;
        $ruta = "assets/images/alimentos/";
        $imagen = $ruta . $rand . '.png';
        $this->imagen = $imagen;
        move_uploaded_file($this->img, $this->imagen);
        $this->id = $id;
        return $this->modificarI($returnJson);
    }
  }

  private function modificarI($returnJson) {
        try {
           $this->conectarDB();
           $this->conex->beginTransaction();
            $query = $this->conex->prepare("SELECT imgAlimento FROM  alimento WHERE idAlimento = ?");
            $query->bindValue(1, $this->id);
            $query->execute();
            $data = $query->fetchAll();
            if (isset($data[0]["imgAlimento"])) {
                $imagen = $data[0]["imgAlimento"];
                $this->delete($imagen);
            }
            $new = $this->conex->prepare("UPDATE alimento SET imgAlimento = ? WHERE `idAlimento` = ? AND `status` = 1");
            $new->bindValue(1, $this->imagen);
            $new->bindValue(2, $this->id);
            $new->execute();
            $this->conex->commit();
            $resultado = ['resultado' => 'imagen modificado'];
            if ($returnJson) {
              echo json_encode($resultado);
              die();
            } 
            return $resultado;
        } catch (\PDOException $e) {
        
        $this->conex->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
    }
    finally {
         $this->desconectarDB();
      }

  }

private function quitarAcentos($cadena) {
    $acentos = array(
        'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú',
        'à', 'è', 'ì', 'ò', 'ù', 'À', 'È', 'Ì', 'Ò', 'Ù',
        'ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü',
        'â', 'ê', 'î', 'ô', 'û', 'Â', 'Ê', 'Î', 'Ô', 'Û',
        'ã', 'õ', 'ñ', 'Ã', 'Õ', 'Ñ', 'ç', 'Ç'
    );
    $sin_acentos = array(
        'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U',
        'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U',
        'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U',
        'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U',
        'a', 'o', 'n', 'A', 'O', 'N', 'c', 'C'
    );
    return str_replace($acentos, $sin_acentos, $cadena);
}

private function generarCodigo($palabra1, $palabra2) {
    // Eliminar acentos
    $palabra1 = $this->quitarAcentos($palabra1);
    $palabra2 = $this->quitarAcentos($palabra2);
    
    // Eliminar caracteres no alfanuméricos y convertir a mayúsculas
    $palabra1 = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $palabra1));
    $palabra2 = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $palabra2));
    
    
    // Obtener los dos primeros caracteres de cada palabra
    $parte1 = substr($palabra1, 0, 3);
    $parte2 = substr($palabra2, 0, 3);
   
    // Generar dos números aleatorios
    $numerosAleatorios = rand(10, 99); // Dos dígitos aleatorios entre 10 y 99
    
    // Concatenar las partes
    $codigo = $parte1 . $parte2 . $numerosAleatorios;
    
    return $codigo;
}

function delete($imagen){
    $imagen;
    if (file_exists($imagen)) {
        if (unlink($imagen)) {
            return "La imagen ha sido eliminada correctamente.";
        } else {
            return "Error al intentar eliminar la imagen.";
        }
    } else {
        return "La imagen no existe en el directorio especificado.";
    }
}


public function anularAlimento($id, $returnJson=true) {
  if (!preg_match("/^[0-9]{1,}$/", $id)) {
    $resultado = ['resultado' => 'Seleccionar el  alimento a anular'];
    if ($returnJson) {
        echo json_encode($resultado);
        die();
    } 
    return $resultado; 
   } else {
    $this->id=$id;
    return $this->anular($returnJson);
   }
    
}

private function anular($returnJson) {
  
    try {
        $this->conectarDB();
        $this->conex->beginTransaction();
        $query = $this->conex->prepare("SELECT * FROM  alimento WHERE idAlimento = ?");
        $query->bindValue(1, $this->id);
        $query->execute();
        $data = $query->fetchAll();

        if ($data) {
            $alimento = $data[0]['nombre'];
        if(isset($data[0]["imgAlimento"]) ){
           $imagen= $data[0]["imgAlimento"];
           $this->delete($imagen);
        }

         $new = $this->conex->prepare("UPDATE `alimento` SET status = 0  WHERE `idAlimento` = ? ");
        $new->bindValue(1, $this->id);
        $new->execute();

         if ($new->rowCount() > 0) {
                
                $bitacora = new bitacoraModelo;
                $bitacora->registrarBitacora('Tipos de Alimentos', 'Se anuló un Tipo de alimento llamado: ' . $alimento, $_SESSION['cedula']);

                
            $this->conex->commit();
            $mensaje = ['resultado' => 'eliminado'];
            if ($returnJson) {
              echo json_encode($mensaje);
              die();
            } 
            return $mensaje; 
           } else {
                
                $this->conex->rollBack();
                $mensaje=['mensaje' => 'No se encontró el alimento o no se pudo anular'];
                if ($returnJson) {
                  echo json_encode($mensaje);
                  die();
                } 
                return $mensaje; 
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



}


