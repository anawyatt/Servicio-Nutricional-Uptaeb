<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;

class consultarAlimentosModelo extends connectDB
{

  private $tipoA;
  private $alimento;
  private $marca;
  private $unidad;
  private $imagen;
  private $id;
  private $payload;
  private $codigo;
  

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

  public function mostrarAlimentos($tipoA)
  {
    if (!preg_match("/^(|Seleccionar|\d+)$/", $tipoA)) {
      return ['resultado' => 'Seleccionar el tipo de alimento'];
    } else {
      $this->tipoA = $tipoA;
      return $this->mostrarA();
    }
  }


  private function mostrarA()
  {
    try {
      
      if ($this->tipoA != 'Seleccionar' && !empty($this->tipoA)) {
        return $this->mostrarAconFiltros();
      } else {
        return $this->mostrarAsinFiltros();
      }

    } catch (\Exception $e) {
      throw new \RuntimeException('Error al mostrar los alimentos: ' . $e->getMessage());
    }
  }

  private function mostrarAconFiltros()
  {
    $this->conectarDB();
    $new = $this->conex->prepare(" SELECT * FROM vista_alimentos WHERE idTipoA = ? ");
    $new->bindValue(1, $this->tipoA);
    $new->execute();
    $data = $new->fetchAll(\PDO::FETCH_OBJ);
    $this->desconectarDB();
    return $data;

  }

  private function mostrarAsinFiltros()
  {
    $this->conectarDB();
    $new = $this->conex->prepare(" SELECT * FROM vista_alimentos ");
    $new->execute();
    $data = $new->fetchAll(\PDO::FETCH_OBJ);
    $this->desconectarDB();
    return $data;

  }

  public function verificarExistencia($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'ingrese el id del alimento'];
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
      $mostrar = $this->conex->prepare(" SELECT * FROM alimento WHERE idAlimento = ? and status =1");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia de los alimentos: ' . $e->getMessage());
    }
  }

  public function infoAlimento($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar el  alimento'];
    } else {
      $this->id = $id;
      return $this->infoA();
    }
  }

  private function infoA()
{
    try {
        $this->conectarDB();
        $query = $this->conex->prepare("SELECT * FROM vista_alimentos WHERE idAlimento=?");
        $query->bindValue(1, $this->id);
        $query->execute();
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);
        $this->desconectarDB();

        // Procesar campo unidadMedida
        foreach ($data as &$row) {
            if (!empty($row['unidadMedida'])) {
                $valor = trim($row['unidadMedida']);
            
                if (preg_match('/^(\d+)\s*([a-zA-Z]+)$/', $valor, $matches)) {
                    $row['cantidad'] = $matches[1];
                    $row['unidad']   = $matches[2];
                } elseif (preg_match('/^([a-zA-Z]+)$/', $valor, $matches)) {
                    $row['cantidad'] = null;
                    $row['unidad']   = $matches[1];
                } else {
                    $row['cantidad'] = null;
                    $row['unidad']   = null;
                }
            } else {
                $row['cantidad'] = null;
                $row['unidad']   = null;
            }
        }

        return $data;

    } catch (\Exception $e) {
        throw new \RuntimeException('Error al mostrar la informacion del alimento: ' . $e->getMessage());
    }
}



  public function verificarExistenciaTipoA($tipoA)
  {
    if (!preg_match("/^[0-9]{1,}$/", $tipoA)) {
      return ['resultado' => 'Seleccionar el tipo de alimento'];
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
      $verificar = $this->conex->prepare("SELECT idTipoA FROM tipoalimento WHERE status=1  and idTipoA=? ");
      $verificar->bindValue(1, $this->tipoA);
      $verificar->execute();
      $data = $verificar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la existencia del alimento: ' . $e->getMessage());
    }

  }

  public function mostrarTipoAlimento()
  {
    try {
      $this->conectarDB();
      $registrar = $this->conex->prepare("SELECT * FROM `tipoalimento` WHERE status =1 ");
      $registrar->execute();
      $data = $registrar->fetchAll(\PDO::FETCH_OBJ);
      $this->desconectarDB();
      return $data;
    } catch (\PDOException $e) {
      return $e;
    }
  }

  public function verificarBoton($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar el alimento'];
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
      $mostrar = $this->conex->prepare(" SELECT idAlimento FROM alimento a WHERE idAlimento=? and EXISTS 
      (SELECT 1 FROM detalleentradaa da WHERE a.idAlimento = da.idAlimento AND  da.status=1)");
      $mostrar->bindValue(1, $this->id);
      $mostrar->execute();
      $data = $mostrar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar el boton de la info del alimento: ' . $e->getMessage());
    }

  }

  public function verificarAlimento($id,  $alimento, $marca, $unidad)
  {
    $errores = [];
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $errores[] = 'Ingresar el codigo del alimento';
    }
    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $alimento)) {
      $errores[] = 'Ingresar un alimento correctamente';
    }

    if (!preg_match("/^(Sin Marca|[a-zA-ZÀ-ÿ\s]{3,})$/", trim($marca))) {
      $errores[] = 'Ingresar una marca correctamente';
    }
    if (!preg_match("/^\d*\s*[a-zA-Z]+$/", $unidad)) {  
      $errores[] = 'Ingresar la unidad correctamente';
    }

    if (!empty($errores)) {
      return ['resultado' => implode(", ", $errores)];
    } 

    else {

      $this->alimento = $alimento;
      $this->marca = $marca;
      $this->unidad = $unidad;
      $this->id = $id;
      $resultado = $this->verificarA();
      return $resultado === true ? ['resultado' => 'existe'] : ['resultado' => 'no esta duplicado'];
    }
  }

  private function verificarA()
  {
    try {
      $this->conectarDB();
      $verificar = $this->conex->prepare("SELECT nombre FROM alimento WHERE status =1  and  nombre =? and marca =? and unidadMedida=? and idAlimento !=? ");
      $verificar->bindValue(1, $this->alimento);
      $verificar->bindValue(2, $this->marca);
      $verificar->bindValue(3, $this->unidad);
      $verificar->bindValue(4, $this->id);
      $verificar->execute();
      $data = $verificar->fetchAll();
      $this->desconectarDB();
      return !empty($data);
    } catch (\Exception $e) {
      throw new \RuntimeException('Error al verificar la duplicacion del alimento: ' . $e->getMessage());
    }
  }


  public function modificarAlimentos(
    $id,
    $tipoA,
    $alimento,
    $marca,
    $unidad
  ) {
    $errores = [];
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      $errores[] = 'Ingresar el id del alimento correctamente';
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
   if (!preg_match("/^\d*\s*[a-zA-Z]+$/", $unidad)) {
            $errores[] = 'Ingresar la unidad correctamente';
    }
    if (!empty($errores)) {
      var_dump($errores);
      return ['resultado' => implode(", ", $errores)];
    }
    if ($this->verificarAlimento($id, $alimento, $marca, $unidad)['resultado'] == 'existe') {
      return ['resultado' => 'existe'];
    }
    
    else {
      $codigo = $this->generarCodigo($alimento, $marca);
      $this->codigo = $codigo;
      $this->tipoA = $tipoA;
      $this->alimento = $alimento;
      $this->marca = $marca;
      $this->unidad = $unidad;
      $this->id = $id;
      return $this->modificarA();
    }
  }

  private function modificarA()
  {

    try {
      $this->conectarDB();
      $this->conex->beginTransaction();

      $modificar = $this->conex->prepare(" UPDATE `alimento` SET `codigo`=?,`nombre`=?,`unidadMedida`=?,`marca`=?,`idTipoA`=? WHERE  idAlimento =?");
      $modificar->bindValue(1, $this->codigo);
      $modificar->bindValue(2, $this->alimento);
      $modificar->bindValue(3, $this->unidad);
      $modificar->bindValue(4, $this->marca);
      $modificar->bindValue(5, $this->tipoA);
      $modificar->bindValue(6, $this->id);
      $modificar->execute();

      if ($modificar->rowCount() > 0) {
        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora('Consultar Alimentos', 'Se Modificó los datos del Alimento:' . $this->alimento, $this->payload->cedula);
        $this->conex->commit();
        return ['resultado' => 'modificado'];
      } else {
        $this->conex->rollBack();
        return ['resultado' => 'no hubo cambios'];
      }

    } catch (\PDOException $e) {

      $this->conex->rollBack();
      throw new \RuntimeException('Error al modificar el alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }


public function modificarImagen($imagen, $id)
{
    $errores = [];

    if (!preg_match("/^[0-9]+$/", $id)) {
        $errores[] = 'Ingresar el id del alimento correctamente';
    }

    $validacion = $this->validarImagen($imagen);
    if ($validacion !== true) {
        $errores[] = $validacion['resultado'];
    }

    if (!empty($errores)) {
        return ['resultado' => implode(", ", $errores)];
    }

    $info = $this->infoAlimento($id);
    $rand = $this->generarCodigo($info[0]['nombre'], $info[0]['marca']);
    $ruta = "assets/images/alimentos/";

    $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
    $imagenDestino = $ruta . $rand . '.' . $ext;

    if (!move_uploaded_file($imagen['tmp_name'], $imagenDestino)) {
        return ['resultado' => 'Error al mover la imagen al directorio de destino'];
    }

    $this->imagen = $imagenDestino;
    $this->id = $id;

    return $this->modificarI();
}

  private function modificarI()
  {
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
      return ['resultado' => 'imagen modificado'];

    } catch (\PDOException $e) {
      $this->conex->rollBack();
      throw new \RuntimeException('Error al modifcar la imagen del alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }

  }

  function delete($imagen)
  {
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


  public function anularAlimento($id)
  {
    if (!preg_match("/^[0-9]{1,}$/", $id)) {
      return ['resultado' => 'Seleccionar el  alimento a anular'];
    } 
    if ($this->verificarExistencia($id)['resultado'] == 'ya no existe') {
      return ['resultado' => 'el alimento ya no existe'];
    }
    if ($this->verificarBoton($id)['resultado'] == 'no se puede') {
      return ['resultado' => 'no se puede'];
    }
    else {
      $this->id = $id;
      return $this->anular();
    }

  }
  private function anular(){

    try {
      $this->conectarDB();
      $this->conex->beginTransaction();
      $query = $this->conex->prepare("SELECT * FROM vista_alimentos WHERE idAlimento= ?");
      $query->bindValue(1, $this->id);
      $query->execute();
      $data = $query->fetchAll();

      if ($data) {
        $alimento = $data[0]['nombre'];
        if (isset($data[0]["imgAlimento"])) {
          $imagen = $data[0]["imgAlimento"];
          $this->delete($imagen);
        }

        $new = $this->conex->prepare("UPDATE `alimento` SET status = 0  WHERE `idAlimento` = ? ");
        $new->bindValue(1, $this->id);
        $new->execute();

        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora('Consultar Alimentos', 'Se anuló un alimento llamado: ' . $alimento, $this->payload->cedula);

        $this->conex->commit();
        return ['resultado' => 'eliminado'];

      } else {
        $this->conex->rollBack();
        return ['resultado' => 'No se encontró alimentos'];
      }
    } catch (\PDOException $e) {

      $this->conex->rollBack();
      throw new \RuntimeException('Error al eliminar el alimento: ' . $e->getMessage());
    } finally {
      $this->desconectarDB();
    }
  }

 
    public function validarImagen($imagen)
{
    if (!isset($imagen['tmp_name']) || !file_exists($imagen['tmp_name'])) {
        return ['resultado' => 'Error al subir la imagen'];
    }

    if ($imagen['error'] !== UPLOAD_ERR_OK) {
        return ['resultado' => 'Error al subir la imagen'];
    }

    $mime = mime_content_type($imagen['tmp_name']);
    $formatosValidos = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];

    if (!in_array($mime, $formatosValidos)) {
        return ['resultado' => 'El archivo no es una imagen válida (JPEG, PNG, JPG, WEBP)!'];
    }
    if ($imagen['size'] > 2 * 1024 * 1024) {
        return ['resultado' => 'La imagen no debe superar los 2MB!'];
    }
    $dimensiones = getimagesize($imagen['tmp_name']);
    if ($dimensiones === false) {
        return ['resultado' => 'La imagen está dañada o no se puede procesar!'];
    }
    return true;
}


  private function generarCodigo($palabra1, $palabra2)
  {
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

  private function quitarAcentos($cadena)
  {
    $acentos = array(
      'á',
      'é',
      'í',
      'ó',
      'ú',
      'Á',
      'É',
      'Í',
      'Ó',
      'Ú',
      'à',
      'è',
      'ì',
      'ò',
      'ù',
      'À',
      'È',
      'Ì',
      'Ò',
      'Ù',
      'ä',
      'ë',
      'ï',
      'ö',
      'ü',
      'Ä',
      'Ë',
      'Ï',
      'Ö',
      'Ü',
      'â',
      'ê',
      'î',
      'ô',
      'û',
      'Â',
      'Ê',
      'Î',
      'Ô',
      'Û',
      'ã',
      'õ',
      'ñ',
      'Ã',
      'Õ',
      'Ñ',
      'ç',
      'Ç'
    );
    $sin_acentos = array(
      'a',
      'e',
      'i',
      'o',
      'u',
      'A',
      'E',
      'I',
      'O',
      'U',
      'a',
      'e',
      'i',
      'o',
      'u',
      'A',
      'E',
      'I',
      'O',
      'U',
      'a',
      'e',
      'i',
      'o',
      'u',
      'A',
      'E',
      'I',
      'O',
      'U',
      'a',
      'e',
      'i',
      'o',
      'u',
      'A',
      'E',
      'I',
      'O',
      'U',
      'a',
      'o',
      'n',
      'A',
      'O',
      'N',
      'c',
      'C'
    );
    return str_replace($acentos, $sin_acentos, $cadena);
  }



}




