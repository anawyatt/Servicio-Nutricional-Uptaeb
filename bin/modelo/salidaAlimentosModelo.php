<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;


class salidaAlimentosModelo extends connectDB
{

  private $tipoA;
  private $alimento;
  private $marca;
  private $unidad;
  private $tipoS;
  private $fecha;
  private $hora;
  private $descripcion;
  private $cantidad;
  private $payload;

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
      $mostrar = $this->conex->prepare("SELECT DISTINCT ta.idTipoA, ta.tipo FROM tipoalimento ta INNER JOIN alimento a ON ta.idTipoA = a.idTipoA WHERE EXISTS (SELECT 1 FROM detalleentradaa daa WHERE a.idAlimento = daa.idAlimento AND status=1 AND stock > 0)");
      $mostrar->execute();
      $tipoAlimento = $mostrar->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();
      return $tipoAlimento;

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
      $verificar = $this->conex->prepare("SELECT idTipoA FROM tipoalimento ta WHERE idTipoA=? AND EXISTS (SELECT 1 FROM alimento a WHERE ta.idTipoA = a.idTipoA AND status=1 AND stock > 0);");
      $verificar->bindValue(1, $this->tipoA);
      $verificar->execute();
      $data = $verificar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar el tipo de alimento: ' . $e->getMessage());
    }
  }


  public function mostrarAlimento($tipoA)
  {
    if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
      return ['resultado' => 'Ingresar alimento'];
    } else {
      $this->tipoA = $tipoA;
      return $this->mostrarA();
    }
  }

  public function mostrarA()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare("SELECT DISTINCT a.idAlimento, a.codigo, a.imgAlimento, a.nombre, a.unidadMedida, a.marca, a.stock FROM tipoalimento ta INNER JOIN alimento a ON ta.idTipoA = a.idTipoA WHERE a.idTipoA =? and a.stock > 0 and EXISTS (SELECT 1 FROM detalleentradaa daa WHERE a.idAlimento = daa.idAlimento AND status=1);");
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
      $verificar = $this->conex->prepare("SELECT idAlimento FROM alimento WHERE status=1  and idAlimento=? and stock > 0 ");
      $verificar->bindValue(1, $this->alimento);
      $verificar->execute();
      $data = $verificar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia del alimento: ' . $e->getMessage());
    }
  }


  public function mostrarTipoSalida()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare("SELECT * FROM `tiposalidas` WHERE status =1 and tipoSalida != 'Menú' ");
      $mostrar->execute();
      $tipoSalida = $mostrar->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();
      return $tipoSalida;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar el tipo de salida: ' . $e->getMessage());
    }
  }

  public function verificarExistenciaTipoS($tipoS)
  {
    if (!preg_match("/^[0-9]{1,}$/", $tipoS)) {
      return ['resultado' => 'Ingresar el tipo de salida'];
    } else {
      $this->tipoS = $tipoS;
      $resultado = $this->verificarETS();
      return $resultado === true ? ['resultado' => 'si esta'] : ['resultado' => 'no esta'];
    }
  }

  private function verificarETS()
  {
    try {
      $this->conectarDB();
      $verificar = $this->conex->prepare("SELECT idTipoSalidas FROM tiposalidas WHERE status=1  and idTipoSalidas=? ");
      $verificar->bindValue(1, $this->tipoS);
      $verificar->execute();
      $data = $verificar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia del tipo de salida: ' . $e->getMessage());
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
      throw new \RuntimeException('Error al mostrar la infor del alimento: ' . $e->getMessage());
    }
  }

  public function registrarSalidaA($fecha, $hora, $tipoS, $descripcion)
  {
    $errores = [];

    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
      $errores[] = 'Ingresar la fecha en formato YYYY-MM-DD';
    }

    if (!preg_match("/^(?:[01]\d|2[0-3]):[0-5]\d$/", $hora)) {
      $errores[] = 'Ingresar la hora en formato HH:MM';
    }

    if (!preg_match("/^[0-9]{1,}$/", $tipoS)) {
      $errores[] = 'Ingresar el tipo de salida';
    }

    if (!preg_match("/^[\w\sÀ-ÿ]{5,}$/", $descripcion)) {
      $errores[] = 'Ingresar una descripción válida con al menos 5 caracteres';
    }

    if (!empty($errores)) {
      return ['resultado' => implode(", ", $errores)];
    } else {
      $this->fecha = $fecha;
      $this->hora = $hora;
      $this->tipoS = $tipoS;
      $this->descripcion = $descripcion;
      return $this->registrar();
    }
  }

  private function registrar()
  {

    try {
      $this->conectarDB();
      $this->conex->beginTransaction();
      $registrar = $this->conex->prepare(" INSERT INTO `salidaalimentos`(`idSalidaA`,`fecha`, `hora`, `descripcion`, `idTipoSalidaA`, `status`) VALUES(DEFAULT, ?, ?, ?,?, 1)");
      $registrar->bindValue(1, $this->fecha);
      $registrar->bindValue(2, $this->hora);
      $registrar->bindValue(3, $this->descripcion);
      $registrar->bindValue(4, $this->tipoS);
      $registrar->execute();
      $this->id = $this->conex->lastInsertId();
      $mensaje = ['respuesta' => 'registrado', 'id' => $this->id];
      $bitacora = new bitacoraModelo;
      $bitacora->registrarBitacora('Inventario de Alimentos - Salida', 'Registró una salida de alimentos  en la fecha y hora: ' . $this->fecha . ' - ' . $this->fecha . ' la cual describe el motivo :  ' . $this->descripcion, $this->payload->cedula);
      $this->notificaciones($this->fecha, $this->hora, $this->descripcion);
      $this->notificaciones3($this->tipoS, $this->fecha, $this->hora);

      $this->conex->commit();

      return $mensaje;
    } catch (\Exception $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al registrar la salida del alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

  public function registrarDetalleSalidaA($alimento, $cantidad, $id)
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
      $this->conex->beginTransaction();
      $registrar = $this->conex->prepare(" INSERT INTO `detallesalidaa`(`idDetalleSalidaA`, `cantidad`, `idAlimento`,`idSalidaA`, `status`) VALUES(DEFAULT, ?, ?,?, 1)");
      $registrar->bindValue(1, $this->cantidad);
      $registrar->bindValue(2, $this->alimento);
      $registrar->bindValue(3, $this->id);
      $registrar->execute();
      $this->actualizarStock($this->alimento, $this->cantidad);
      $this->notificaciones2($this->alimento);
      $this->conex->commit();

      return ['resultado' => 'exitoso'];

    } catch (\Exception $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al registrar el detalle de la salida del alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

  private function actualizarStock($idAlimento, $cantidad)
  {
    $this->alimento = $idAlimento;
    $this->cantidad = $cantidad;
    try {

      $info = $this->infoAlimento2($this->alimento);
      $actualizarStock = $info[0]["stock"] - $this->cantidad;
      $registrar = $this->conex->prepare(" UPDATE `alimento` SET stock = ?  WHERE `idAlimento` = ? ");
      $registrar->bindValue(1, $actualizarStock);
      $registrar->bindValue(2, $this->alimento);
      $registrar->execute();
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al actualizar el stock: ' . $e->getMessage());
    }
  }

  private function infoAlimento2($alimento)
  {
    $this->alimento = $alimento;

    try {
      $mostrar = $this->conex->prepare("SELECT * FROM alimento WHERE status = 1 AND idAlimento = ? FOR UPDATE");
      $mostrar->bindValue(1, $this->alimento);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      return $data;

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar la info del alimento: ' . $e->getMessage());
    }
  }

  private function notificaciones($fecha, $hora, $descripcion)
  {
    try {
      $this->conectarDBSeguridad();
      $titulo = "Registro de Salida de Alimentos";
      $mensaje = 'Se registro una salida de alimentos en la fecha y hora: ' . $this->fecha . ' - ' . $this->hora . ' la cual describe que es :  ' . $this->descripcion;
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

  private function notificaciones2($alimento)
  {
    try {
      $this->conectarDBSeguridad();
      $query = $this->conex->prepare("SELECT stock, nombre FROM `alimento` WHERE idAlimento = ?");
      $query->bindValue(1, $this->alimento);
      $query->execute();

      $result = $query->fetch(\PDO::FETCH_ASSOC);

      if ($result) {
        $stock = $result['stock'];
        $nombre = $result['nombre'];

        if ($stock == 0) {

          $titulo = "Stock Vacio";
          $mensaje = "El Stock del alimento " . $nombre . " se encuentra vacio.";
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
        } else {

        }
      } else {
        echo "No se encontró el alimento con idAlimento = .";
      }


    } catch (\Exception $e) {

      error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
    }
  }

  private function notificaciones3($tipoS)
  {
    try {
      $this->conectarDBSeguridad();
      $query = $this->conex->prepare("SELECT tipoSalida FROM `tiposalidas` WHERE idTipoSalidas = ?");
      $query->bindValue(1, $this->tipoS);
      $query->execute();

      $result = $query->fetch(\PDO::FETCH_ASSOC);

      if ($result) {
        $tipoSalida = $result['tipoSalida'];

        if ($tipoSalida == "Merma") {

          $titulo = "Salida de Merma";
          $mensaje = "Se ha realizado una salida por motivo de Merma en la fecha y hora:" . $this->fecha . "-" . $this->hora;
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
        } else {

        }
      } else {
        echo "No se encontró el alimento con idAlimento = .";
      }



    } catch (\Exception $e) {

      error_log("Error al enviar notificación a través de WebSocket: " . $e->getMessage());
    }
  }



}


