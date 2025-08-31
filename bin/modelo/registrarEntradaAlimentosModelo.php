<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;


class registrarEntradaAlimentosModelo extends connectDB
{
  private $tipoA;
  private $alimento;
  private $marca;
  private $unidad;
  private $payload;
  private $fecha;
  private $hora;
  private $descripcion;
  private $cantidad;
  private $id;


  public function __construct()
{
    parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    
}


  public function mostrarTipoAlimento()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare("SELECT idTipoA, tipo FROM tipoalimento ta WHERE status =1 and EXISTS (SELECT 1 FROM alimento a WHERE ta.idTipoA=a.idTipoA AND a.status=1) ");
      $mostrar->execute();
      $tipoA = $mostrar->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();
      return $tipoA;

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al motrar el tipo de alimento: ' . $e->getMessage());
    }
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



  public function mostrarAlimento($tipoA)
  {
    if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
      return ['resultado' => 'Ingresar el alimento'];
    } else {
      $this->tipoA = $tipoA;
      return $this->mostrarA();
    }
  }

  private function mostrarA()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare("SELECT * FROM `alimento` WHERE  status =1 and idTipoA=? ");
      $mostrar->bindValue(1, $this->tipoA);
      $mostrar->execute();
      $alimentos = $mostrar->fetchAll();
      $this->desconectarDB();
      return $alimentos;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar el alimento: ' . $e->getMessage());
    }
  }

  public function verificarExistenciaAlimento($alimento)
  {
    if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
      return ['resultado' => 'Ingresar el  alimento'];
    } else {
      $this->alimento = $alimento;
      $resultado = $this->verificarEA();
      return $resultado === true ? ['resultado' => 'si esta'] : ['resultado' => 'no esta'];
    }
  }

  private function verificarEA()
  {
    try {
      $this->conectarDB();
      $verificar = $this->conex->prepare("SELECT idAlimento FROM alimento WHERE status=1  and idAlimento=? ");
      $verificar->bindValue(1, $this->alimento);
      $verificar->execute();
      $data = $verificar->fetchAll();
      $this->desconectarDB();
      return !empty($data);

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia del alimento: ' . $e->getMessage());
    }
  }

  public function infoAlimento($alimento)
  {
    if (!preg_match("/^[0-9]{1,}$/", $alimento)) {
      return ['resultado' => 'Seleccionar el  alimento'];
    } else {
      $this->alimento = $alimento;
      return $this->infoA();
    }
  }

  private function infoA()
  {

    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare("SELECT * FROM alimento  WHERE  status =1 and idAlimento=? ");
      $mostrar->bindValue(1, $this->alimento);
      $mostrar->execute();
      $informacion = $mostrar->fetchAll();
      $this->desconectarDB();
      return $informacion;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar la info del alimento: ' . $e->getMessage());
    }
  }


  public function registrarEntradaA($fecha, $hora, $descripcion)
  {
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
      return ['resultado' => implode(", ", $errores)];
    } else {
      $this->fecha = $fecha;
      $this->hora = $hora;
      $this->descripcion = $descripcion;
      return $this->registrar();
    }
  }

  private function registrar()
  {

    try {
      $this->conectarDB();
      $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
      $this->conex->beginTransaction();
      $registrar = $this->conex->prepare(" INSERT INTO `entradaalimento`(`idEntradaA`,`fecha`, `hora`, `descripcion`, `status`) VALUES(DEFAULT, ?,?, ?, 1)");
      $registrar->bindValue(1, $this->fecha);
      $registrar->bindValue(2, $this->hora);
      $registrar->bindValue(3, $this->descripcion);
      $registrar->execute();
      $this->id = $this->conex->lastInsertId();
      $this->notificaciones($this->fecha, $this->hora, $this->descripcion);
      $mensaje = ['respuesta' => 'registrado', 'id' => $this->id];
      $bitacora = new bitacoraModelo;
      $bitacora->registrarBitacora('Inventario de Alimentos - Entrada', 'Registró una entrada de alimentos en la fecha y hora: ' 
      . $this->fecha . ' - ' . $this->hora . ' la cual describe que es :  ' . $this->descripcion, $this->payload->cedula);
      $this->conex->commit();

      return $mensaje;

    } catch (\Exception $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al registrar el inventario del alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

  public function registrarDetalleEntradaA($alimento, $cantidad, $id)
  {
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
      return ['resultado' => implode(", ", $errores)];
    } else {
      $this->alimento = $alimento;
      $this->cantidad = $cantidad;
      $this->id = $id;
      return $this->registrarDetalle();
    }
  }


  private function registrarDetalle()
  {

    try {
      $this->conectarDB();
      $this->conex->exec("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
      $this->conex->beginTransaction();
      $registrar = $this->conex->prepare(" INSERT INTO `detalleentradaa`(`idDetalleA`, `cantidad`, `idAlimento`,`idEntradaA`, `status`) VALUES(DEFAULT, ?, ?,?, 1)");
      $registrar->bindValue(1, $this->cantidad);
      $registrar->bindValue(2, $this->alimento);
      $registrar->bindValue(3, $this->id);
      $registrar->execute();
      $this->actualizarStock($this->alimento, $this->cantidad);
      $this->conex->commit();
      return ['resultado' => 'exitoso'];

    } catch (\Exception $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al registrar el detalle del alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }

  }


 private function actualizarStock($idAlimento, $cantidad)
{
    $this->alimento = $idAlimento;
    $this->cantidad = $cantidad;

    try {
        $query = $this->conex->prepare("SELECT stock FROM `alimento` WHERE `idAlimento` = ? FOR UPDATE");
        $query->bindValue(1, $this->alimento);
        $query->execute();

        $row = $query->fetch(\PDO::FETCH_ASSOC);
        $nuevoStock = $row['stock'] + $this->cantidad;

        $registrar = $this->conex->prepare("UPDATE `alimento` SET stock = ? WHERE `idAlimento` = ?");
        $registrar->bindValue(1, $nuevoStock);
        $registrar->bindValue(2, $this->alimento);
        $registrar->execute();

    } catch (\Exception $e) {
        throw new \RuntimeException('Error al actualizar el stock: ' . $e->getMessage());
    }
}


  private function notificaciones($fecha, $hora, $descripcion)
  {
    try {
      $this->conectarDBSeguridad();
      $titulo = "Registro de Entrada de Alimentos";
      $mensaje = 'Se registro una entrada de alimentos en la fecha y hora: ' . $this->fecha . ' - ' . $this->hora . ' la cual describe que es :  ' . $this->descripcion;
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


    } catch (\Exception $e) {

      error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
    }
  }

}


