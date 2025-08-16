<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;

class tipoAlimentoModelo extends connectDB
{
  private $tipoA;
  private $id;
  private $payload;

  public function __construct()
{
    parent::__construct();
    if (isset($_COOKIE['jwt']) && !empty($_COOKIE['jwt'])) {
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    } else {
        $this->payload = (object) ['cedula' => '12345678'];
    }
}


  private function validarTipoA($tipoA)
  {
    return preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $tipoA);
  }

  private function validarId($id)
  {
    return preg_match("/^[0-9]{1,}$/", $id);
  }


  public function verificarTipoAlimento($tipoA)
  {
    if (!$this->validarTipoA($tipoA)) {
      return ['resultado' => 'Ingresar el tipo de alimento correctamente'];

    } else {
      $this->tipoA = $tipoA;
      $resultado = $this->verificarTA();
      return $resultado === true ? ['resultado' => 'error tipo'] : ['resultado' => 'no esta duplicado'];
    }
  }
  private function verificarTA()
  {
    try {
      $this->conectarDB();
      $new = $this->conex->prepare("SELECT tipo FROM `tipoalimento` WHERE  tipo = ? and status =1");
      $new->bindValue(1, $this->tipoA);
      $new->execute();
      $data = $new->fetch();
      $this->desconectarDB();

      return !empty($data);

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar tipo de alimento: ' . $e->getMessage());
    }

  }
  public function registrarTipoAlimento($tipoA)
  {
    if (!$this->validarTipoA($tipoA)) {
      return ['resultado' => 'Ingresar el tipo de alimento correctamente'];
    } else {
      if ($this->verificarTipoAlimento($tipoA)['resultado'] === 'error tipo') {
        return ['resultado' => 'error tipo'];
      } else {
      $this->tipoA = $tipoA;
      return $this->registrar();
      }
    }

  }
  private function registrar()
  {
    try {
      $this->conectarDB();
      $this->conex->beginTransaction();

      $new = $this->conex->prepare("INSERT INTO tipoalimento(idTipoA, tipo, status) VALUES (DEFAULT,?,1)");
      $new->bindValue(1, $this->tipoA);
      $new->execute();

      $bitacora = new bitacoraModelo;

      $bitacora->registrarBitacora('Tipos De Alimentos', 'Registró un Tipo de Alimento llamado: ' . $this->tipoA, $this->payload->cedula);
      $this->conex->commit();
      return ['resultado' => 'registrado'];

    } catch (\Exception $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al registrar el tipo de alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

  public function tabla()
  {

    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare(" SELECT * FROM tipoalimento WHERE status=1 ");
      $mostrar->execute();
      $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();
      return $data;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar los tipos de alimentos: ' . $e->getMessage());
    }
  }

  public function mostrarTipoA($id)
  {

    if (!$this->validarId($id)) {
      return ['resultado' => 'Ingresar el id del tipo de alimento correctamente'];
    } else {
      $this->id = $id;
      return $this->mostrarTA();
    }
  }

  private function mostrarTA()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare(" SELECT * FROM tipoalimento WHERE idTipoA = ? ");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();

      return $data;
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar el tipo de alimento: ' . $e->getMessage());
    }
  }

  public function verificarBoton($id)
  {
    if (!$this->validarId($id)) {
      return ['resultado' => 'Ingresar el id del tipo de alimento correctamente'];
    } else {
      $this->id = $id;
      $resultado = $this->verificarB();
      return $resultado === true ? ['resultado' => 'no se puede'] : ['resultado' => 'se puede'];
    }
  }

  private function verificarB()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare(" SELECT tipo FROM tipoalimento t WHERE idTipoA=? and EXISTS (SELECT 1 FROM alimento a WHERE a.idTipoA = t.idTipoA AND a.status=1)");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetch();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar si se puede modificar: ' . $e->getMessage());
    }
  }

  public function verificarExistencia($id)
  {
    if (!$this->validarId($id)) {
      return ['resultado' => 'Ingresar el id del tipo de alimento correctamente'];
    } else {
      $this->id = $id;
      $resultado = $this->verificarE();
      return $resultado === true ? ['resultado' => 'si existe'] : ['resultado' => 'ya no existe'];
    }
  }

  private function verificarE()
  {
    try {
      $this->conectarDB();
      $mostrar = $this->conex->prepare(" SELECT * FROM tipoalimento WHERE idTipoA = ? and status=1");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetch();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia del tipo de alimento: ' . $e->getMessage());
    }

  }

  public function verificarTipoA2($tipoA, $id)
  {
    $errores = [];

    if (!$this->validarId($id)) {
      $errores[] = 'Ingresar el id del tipo alimento correctamente';
    }
    if (!$this->validarTipoA($tipoA)) {
      $errores[] = 'Ingresar el tipo correctamente';
    }
    if (!empty($errores)) {
      return ['resultado' => implode(", ", $errores)];
    } else {
      $this->tipoA = $tipoA;
      $this->id = $id;
      $resultado = $this->verificar2();
      return $resultado === true ? ['resultado' => 'error tipo2'] : ['resultado' => 'no esta duplicado'];
    }

  }
  private function verificar2()
  {

    try {
      $this->conectarDB();
      $verificar = $this->conex->prepare("SELECT tipo FROM `tipoalimento` WHERE  tipo = ? and idTipoA!=? and status =1");
      $verificar->bindValue(1, $this->tipoA);
      $verificar->bindValue(2, $this->id);
      $verificar->execute();
      $data = $verificar->fetch();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar duplicacion en modificado: ' . $e->getMessage());
    }

  }

  public function modificarTipoAlimento($tipoA, $id)
  {
    $errores = [];

    if (!$this->validarId($id)) {
      $errores[] = 'Ingresar el id del tipo alimento correctamente';
    }
    if (!$this->validarTipoA($tipoA)) {
      $errores[] = 'Ingresar el tipo correctamente';
    }
    if (!empty($errores)) {
      return ['resultado' => implode(", ", $errores)];
    } else {
      if ($this->verificarTipoA2($tipoA, $id)['resultado'] === 'error tipo2') {
        return ['resultado' => 'error tipo2'];
      }
      if ($this->verificarExistencia($id)['resultado'] === 'ya no existe') {
        return ['resultado' => 'ya no existe'];
      }
      if ($this->verificarBoton($id)['resultado'] === 'no se puede') {
        return ['resultado' => 'no se puede'];
      }
      
      $this->tipoA = $tipoA;
      $this->id = $id;
      return $this->modificar();
    }
  }

  private function modificar()
  {
    try {

      $this->conectarDB();
      $this->conex->beginTransaction();
      $modificar = $this->conex->prepare("UPDATE tipoalimento SET tipo=? WHERE idTipoA = ? ");
      $modificar->bindValue(1, $this->tipoA);
      $modificar->bindValue(2, $this->id);
      $modificar->execute();

      if ($modificar->rowCount() > 0) {

        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora('Tipos de Alimentos', 'Se Modificó un Tipo de Alimento llamado:' . $this->tipoA, $this->payload->cedula);

        $this->conex->commit();
        return ['resultado' => 'Editado correctamente'];

      } else {
        $this->conex->rollBack();
        return ['resultado' => 'no hubo cambios'];
      }

    } catch (\PDOException $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al registrar el tipo de alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

  public function anularTipoAlimento($id)
  {
    if (!$this->validarId($id)) {
      return ['resultado' => 'Ingresar el id del tipo de alimento correctamente'];
    } else {
      if ($this->verificarExistencia($id)['resultado'] === 'ya no existe') {
        return ['resultado' => 'ya no existe'];
      }
      if ($this->verificarBoton($id)['resultado'] === 'no se puede') {
        return ['resultado' => 'no se puede'];
      }
      $this->id = $id;
      return $this->anular();
    }
  }

  private function anular()
  {

    try {
      $this->conectarDB();
      $this->conex->beginTransaction();
      $querySelect = $this->conex->prepare("SELECT `tipo` FROM `tipoalimento` WHERE idTipoA = ? AND status = 1");
      $querySelect->bindValue(1, $this->id);
      $querySelect->execute();
      $resultado = $querySelect->fetch(\PDO::FETCH_ASSOC);

      if ($resultado) {
        $nombreTipo = $resultado['tipo'];
        $anular = $this->conex->prepare("UPDATE tipoalimento SET status = 0 WHERE idTipoA=? ");
        $anular->bindValue(1, $this->id);
        $anular->execute();

        if ($anular->rowCount() > 0) {

          $bitacora = new bitacoraModelo;
          $bitacora->registrarBitacora('Tipos de Alimentos', 'Se anuló un Tipo de alimento llamado: ' . $nombreTipo, $this->payload->cedula);
          $this->conex->commit();
          return ['resultado' => 'anulado correctamente.'];

        } else {
          $this->conex->rollBack();
          return ['resultado' => 'No se encontró el tipo de alimento o no se pudo anular'];
        }
      } else {
        $this->conex->rollBack();
        return ['resultado' => 'No se encontró el tipo de alimento'];
      }
    } catch (\PDOException $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al registrar el tipo de alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

}
?>