<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;


class registrarEntradaAlimentosModelo extends connectDB {


         private $tipoA;
         private $alimento;
         private $marca;
         private $unidad;

     public function __construct(){
        parent::__construct(); 
    }

  

	 public function mostrarTipoAlimento(){
        try{
          $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM `tipoalimento` WHERE status =1 and idTipoA IN (SELECT idTipoA FROM alimento WHERE status=1) ");
            $mostrar->execute();
            $tipoA = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();

            echo json_encode($tipoA);
            die();

        }catch(\PDOException $e){
            return $e;
         }
     }

      public function verificarExistenciaTipoA($tipoA, $returnJson = true){
       if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
          $resultado = ['resultado' => 'Ingresar el tipo de alimento'];
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
        $verificar=$this->conex->prepare("SELECT idTipoA FROM tipoalimento WHERE idTipoA=? and status = 1");
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

    

    public function mostrarAlimento($tipoA, $returnJson=true){
      if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
        $resultado = ['resultado' => 'Ingresar el alimento'];
        if ($returnJson) {
            echo json_encode($resultado);
            die();
        } 
        return $resultado; 
       } else {
        $this->tipoA=$tipoA;
        return $this->mostrarA($returnJson);
       }
    }

    private function mostrarA($returnJson){

        try{
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM `alimento` WHERE  status =1 and idTipoA=? ");
            $mostrar->bindValue(1, $this->tipoA);
            $mostrar->execute();
            $alimentos = $mostrar->fetchAll();
            $this->desconectarDB();
            if ($returnJson) {
              echo json_encode($alimentos);
              die();
          } 
          return $alimentos; 

        }catch(\PDOException $e){
            return $e;
        }
     }

      public function verificarExistenciaAlimento($alimento, $returnJson = true){
         if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
          $resultado = ['resultado' => 'Ingresar el  alimento'];
          if ($returnJson) {
              echo json_encode($resultado);
              die();
          } 
          return $resultado; 
         } else {
           $this->alimento=$alimento;
           return $this->verificarEA($returnJson);
        }
      }

     private function verificarEA($returnJson){
      try{
        $this->conectarDB();
        $verificar=$this->conex->prepare("SELECT idAlimento FROM alimento WHERE status=1  and idAlimento=? ");
        $verificar->bindValue(1, $this->alimento);
        $verificar->execute();
        $data=$verificar->fetchAll();
        $this->desconectarDB();
       
       if (!isset( $data[0]["idAlimento"])) {
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

    public function infoAlimento($alimento, $returnJson=true){
      if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
        $resultado = ['resultado' => 'Seleccionar el  alimento'];
        if ($returnJson) {
            echo json_encode($resultado);
            die();
        } 
        return $resultado; 
       } else {
         $this->alimento=$alimento;
         return $this->infoA($returnJson);
       }
    }

    private function infoA($returnJson){
        
        try{
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM alimento  WHERE  status =1 and idAlimento=? ");
            $mostrar->bindValue(1, $this->alimento);
            $mostrar->execute();
            $informacion = $mostrar->fetchAll();
            $this->desconectarDB();
            if ($returnJson) {
              echo json_encode($informacion);
              die();
             } 
             return $informacion;
        }catch(\PDOException $e){
            return $e;
        }
         
     }

      
  public function registrarEntradaA($fecha,$hora, $descripcion,$returnJson=true){
    $errores = [];

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
        $errores[] = 'Ingresar la fecha en formato YYYY-MM-DD';
    }

    if (!preg_match("/^(?:[01]\d|2[0-3]):[0-5]\d$/", $hora)) {
       $errores[] = 'Ingresar la hora en formato HH:MM';
    }

    if (!preg_match("/^[\w\sÀ-ÿ]{5,}$/", $descripcion)) {
       $errores[] = 'Ingresar una descripción válida con al menos 5 caracteres';
    }

    if (!empty($errores)) {
       $mensaje = ['resultado' => implode(", ", $errores)];
       if ($returnJson) {
          echo json_encode($mensaje);
          die();
       }
       return $mensaje;
   }
   else{
    $this->fecha=$fecha;
    $this->hora=$hora;
  	$this->descripcion=$descripcion;
    return $this->registrar($returnJson);
   }
  }

  private function registrar($returnJson){

  try {
      $this->conectarDB();
      $this->conex->beginTransaction();

      $registrar=$this->conex->prepare(" INSERT INTO `entradaalimento`(`idEntradaA`,`fecha`, `hora`, `descripcion`, `status`) VALUES(DEFAULT, ?,?, ?, 1)");
      $registrar->bindValue(1, $this->fecha);
      $registrar->bindValue(2, $this->hora);
  	  $registrar->bindValue(3, $this->descripcion);
      $registrar->execute();
      $this->id = $this->conex->lastInsertId();
      $this->notificaciones($this->fecha, $this->hora, $this->descripcion);
      $mensaje=['respuesta' => 'registrado', 'id' => $this->id];
       $bitacora = new bitacoraModelo;
       $bitacora->registrarBitacora('Inventario de Alimentos - Entrada', 'Registró una entrada de alimentos en la fecha y hora: '.$this->fecha. ' - '.$this->hora. ' la cual describe que es :  '.$this->descripcion, $_SESSION['cedula']);
       $this->conex->commit();
    
      if ($returnJson) {
        echo json_encode($mensaje);
        die();
      }
       return $mensaje;
  } catch (Exception $e) {
     $this->conex->rollBack();
     echo json_encode(['error' => $e->getMessage()]);
    }
    finally {
      $this->desconectarDB();
    }
  }

  public function registrarDetalleEntradaA($alimento,$cantidad,$id, $returnJson=true){
    $errores = [];
    if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
      $errores[] = 'Ingresar el  alimento para el registro';
    } 
    if (!preg_match("/^[1-9][0-9]*$/", $cantidad)) {
      $errores[] = 'Ingresar la cantidad';
    }
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $errores[] = 'Ingresar el  id del registro';
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
  	$this->alimento=$alimento;
    $this->cantidad=$cantidad;
    $this->id=$id;
    return $this->registrarDetalle($returnJson);
   }
  }


  private function registrarDetalle($returnJson){
    
  	 try {
      $this->conectarDB();
      $this->conex->beginTransaction();
      $registrar=$this->conex->prepare(" INSERT INTO `detalleentradaa`(`idDetalleA`, `cantidad`, `idAlimento`,`idEntradaA`, `status`) VALUES(DEFAULT, ?, ?,?, 1)");
      $registrar->bindValue(1, $this->cantidad);
  	  $registrar->bindValue(2, $this->alimento);
  	  $registrar->bindValue(3, $this->id);
      $registrar->execute();
      $actualizarStock= $this->actualizarStock($this->alimento, $this->cantidad);
      $this->conex->commit();
  	  $mensaje =['resultado' => 'exitoso'];
      if ($returnJson) {
        echo json_encode($mensaje);
        die();
      } 
      return $mensaje;
      } catch (Exception $e) {

        $this->conex->rollBack();
        echo json_encode(['error' => $e->getMessage()]);
      }
      finally {
          $this->desconectarDB();
      }

    }

    
  private function actualizarStock($idAlimento, $cantidad){
  	$this->alimento=$idAlimento;
    $this->cantidad=$cantidad;
   try {
      $info= $this->infoAlimento2($this->alimento);
      $actualizarStock= $info[0]["stock"] + $this->cantidad;
      $registrar=$this->conex->prepare(" UPDATE `alimento` SET stock = ?  WHERE `idAlimento` = ? ");
      $registrar->bindValue(1, $actualizarStock);
  	  $registrar->bindValue(2, $this->alimento);
      $registrar->execute();
   }
   
   catch(exection $error){
            return array("Sistema", "¡Error Sistema!");

   }

  }

  private function infoAlimento2($alimento){
        $this->alimento=$alimento;
        
        try{
            $mostrar = $this->conex->prepare("SELECT * FROM alimento  WHERE  status =1 and idAlimento=? ");
            $mostrar->bindValue(1, $this->alimento);
            $mostrar->execute();
            $data = $mostrar->fetchAll();
              return $data;

        }catch(\PDOException $e){
            return $e;
        }
        
     }

  private function notificaciones($fecha, $hora, $descripcion) {
    try {
      $this->conectarDBSeguridad();
      $titulo = "Registro de Entrada de Alimentos";
      $mensaje = 'Se registro una entrada de alimentos en la fecha y hora: '.$this->fecha. ' - '.$this->hora. ' la cual describe que es :  '.$this->descripcion;
      $tipomsj = "informacion";
      $query = $this->conex2->prepare("INSERT INTO `notificaciones` (`titulo`, `mensaje`, `tipo`) VALUES (?, ?, ?)");
      $query->bindValue(1, $titulo);
      $query->bindValue(2, $mensaje);
      $query->bindValue(3, $tipomsj);
      $query->execute();

      $notificacionId = $this->conex2->lastInsertId();

      $query = $this->conex2->prepare("SELECT * FROM usuario u INNER JOIN rol r ON u.idRol = r.idRol INNER JOIN permiso p ON p.idRol = r.idRol INNER JOIN modulo m ON m.idModulo = p.idModulo WHERE m.nombreModulo = 'Inventario de Alimentos' and p.nombrePermiso = 'consultar' and p.status = 1 and u.status = 1;");
      $query->execute();
      $usuarios = $query->fetchAll(\PDO::FETCH_OBJ);

      $query = $this->conex2->prepare("INSERT INTO `notificaciones_usuarios` (`cedula`, `idNotificaciones`, `leida`) VALUES (?, ?, 0)");
      foreach ($usuarios as $usuario) {
          $query->bindValue(1, $usuario->cedula);
          $query->bindValue(2, $notificacionId);
          $query->execute();
      }


    } catch (Exception $e) {
        
        error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
    }
}

}


