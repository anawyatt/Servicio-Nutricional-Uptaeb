<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;


class alimentosModelo extends connectDB {

private $tipoA;
private $alimento;
private $marca;
private $unidad;
private $imagen;

    public function __construct(){
        parent::__construct(); 
    }

    public function verificarExistenciaTipoA($tipoA, $returnJson = true){
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


    public function verificarAlimento($tipoA, $alimento, $marca, $returnJson=true){
      $errores = [];
        
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
        return $this->verificarA($returnJson);
      }
        
    }

    private function verificarA($returnJson){

      try{
         $this->conectarDB();
        $verificar=$this->conex->prepare("SELECT nombre FROM alimento WHERE status =1  and idTipoA =? and nombre =? and marca =? ");
        $verificar->bindValue(1, $this->tipoA);
        $verificar->bindValue(2, $this->alimento);
        $verificar->bindValue(3, $this->marca);
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (isset( $data[0]["nombre"])) {
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

    public function registrarAlimento($imagen, $men, $tipoA, $alimento, $marca, $unidad, $returnJson = true) {
      $errores = [];
  
      if (!in_array($men, ['SI', 'NO'])) {
          $errores[] = 'Valor inválido para men';
      }
  
      if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
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
          $this->img = $imagen;
          $codigo = $this->generarCodigo($alimento, $marca);
          $ruta = "assets/images/alimentos/";
          $this->codigo = $codigo;
          $this->tipoA = $tipoA;
          $this->alimento = $alimento;
          $this->marca = $marca;
          $this->unidad = $unidad;
  
          if ($men === 'NO') {
            $imagen = $ruta . 'alimentoPredeterminado.png';
            $this->imagen = $imagen;
          } else if ($men === 'SI' && $imagen !== null) {
            $imagen = $ruta . $codigo . '.png';
            $this->imagen = $imagen;
            move_uploaded_file($this->img, $this->imagen);
          }
  
          return $this->registrar($returnJson);
      }
  }
  
  private function registrar($returnJson) {
      try {
          $this->conectarDB();
          $this->conex->beginTransaction();
          $registrar = $this->conex->prepare("INSERT INTO `alimento`(`idAlimento`, `codigo`, `imgAlimento`, `nombre`, `unidadMedida`, `marca`, `stock`, `reservado`, `idTipoA`, `status`) VALUES (DEFAULT, ?, ?, ?, ?, ?, 0, 0, ?, 1)");
          $registrar->bindValue(1, $this->codigo);
          $registrar->bindValue(2, $this->imagen);
          $registrar->bindValue(3, $this->alimento);
          $registrar->bindValue(4, $this->unidad);
          $registrar->bindValue(5, $this->marca);
          $registrar->bindValue(6, $this->tipoA);
          $registrar->execute();
          
          // Registro en la bitácora
          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Alimentos', 'Registró un Alimento llamado: ' . $this->alimento, $_SESSION['cedula']);
          
          $this->conex->commit();
          $mensaje = ['resultado' => 'registrado'];
          if ($returnJson) {
              echo json_encode($mensaje);
              die();
          } 
          return $mensaje;
      } catch (Exception $e) {
          $this->conex->rollBack();
          echo json_encode(['error' => $e->getMessage()]);
      } finally {
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

    $palabra1 = $this->quitarAcentos($palabra1);
    $palabra2 = $this->quitarAcentos($palabra2);
  
    $palabra1 = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $palabra1));
    $palabra2 = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $palabra2));
    
    $parte1 = substr($palabra1, 0, 3);
    $parte2 = substr($palabra2, 0, 3);
   
    $numerosAleatorios = rand(10, 99);

    $codigo = $parte1 . $parte2 . $numerosAleatorios;
    
    return $codigo;
}


}


