<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers as JwtHelpers;

use \PDO;


class utensiliosModelo extends connectDB {

private $tipoU;
private $utensilio;

private $material;
private $imagen;
private $payload;

    // Validar imagen igual que en alimentosModelo
    public function validarImagen($imagen)
    {
        if (!isset($imagen['error']) || $imagen['error'] !== UPLOAD_ERR_OK) {
            return ['resultado' => 'Error al subir la imagen'];
        }
        $mime = mime_content_type($imagen['tmp_name']);
        $formatosValidos = ['image/jpeg', 'image/png'];

        if (!in_array($mime, $formatosValidos)) {
            return ['resultado' => 'El archivo no es una imagen válida (JPEG, PNG)!'];
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

    public function __construct() {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    } 

    public function verificarExistenciaTipoU($tipoU) {
        if (!preg_match("/^[0-9]+$/", $tipoU)) {
            return ['resultado' => 'Seleccionar un tipo de utensilio válido'];
        }
    
        $this->tipoU = $tipoU;
        return $this->consultarExistenciaTipoU();
    }
    
    private function consultarExistenciaTipoU() {
        try {
            $this->conectarDB();
            $verificar = $this->conex->prepare("SELECT idTipoU FROM tipoutensilios WHERE status = 1 AND idTipoU = ?");
            $verificar->bindValue(1, $this->tipoU);
            $verificar->execute();
            $data = $verificar->fetchAll();
            $this->desconectarDB();
    
            if (!empty($data) && isset($data[0]["idTipoU"])) {
                return ['resultado' => 'está'];
            } else {
                return ['resultado' => 'no está'];
            }
        } catch (\Exception $error) {
            return ['error' => 'Error en la base de datos', 'detalle' => $error->getMessage()];
        }
    }
    
public function mostrarTipoUtensilios() {
    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("SELECT * FROM `tipoutensilios` WHERE status = 1");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $this->desconectarDB();
        return $data;
    } catch (\PDOException $e) {
        $this->desconectarDB();
        
        return ['error' => '¡Error al obtener los tipos de utensilios!'];
    }
}


public function verificarUtensilios($utensilio, $material) {
    
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,50}$/", $utensilio)) {
        return ['resultado' => 'Nombre de utensilio inválido'];
    }

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,30}$/", $material)) {
        return ['resultado' => 'Material inválido'];
    }

    $this->utensilio = $utensilio;
    $this->material = $material;

    return $this->verificarU();

}

private function verificarU() {

    try {
        $this->conectarDB();
        $verificar = $this->conex->prepare("
            SELECT nombre 
            FROM utensilios 
            WHERE status = 1 
              AND nombre = ? 
              AND material = ?
        ");
        $verificar->bindValue(1, $this->utensilio);
        $verificar->bindValue(2, $this->material);
        $verificar->execute();
        $data = $verificar->fetchAll();
        $this->desconectarDB();

        return !empty($data)
            ? ['resultado' => 'existe']
            : ['resultado' => 'no existe'];

    } catch (Exception $error) {
        return ['error' => 'Error en la base de datos', 'detalle' => $error->getMessage()];
    }
}



public function registrarUtensilio($imagen, $imgState, $tipoU, $utensilios, $material, $returnJson = false) {
     if (!in_array($imgState, ['SI', 'NO'])) {
        return ['resultado'=> 'Valor inválido para men' ];
    }
   
    if (!preg_match("/^[0-9]+$/", $tipoU)) {
        return ['resultado' => 'Seleccionar un tipo de utensilio válido'];
    }

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,50}$/", $utensilios)) {
        return ['resultado' => 'Nombre de utensilio inválido'];
    }

    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,30}$/", $material)) {
        return ['resultado' => 'Material inválido'];
    }

    if($this->verificarUtensilios($utensilios, $material)['resultado'] === 'existe') {
        return ['resultado' => 'existe'];
    }

    $codigo = $this->generarCodigo($utensilios, $material);
    $ruta = "assets/images/utensilios/";
    $this->tipoU = $tipoU;
    $this->utensilio = $utensilios;
    $this->material = $material;

    if ($imgState=== 'NO') {
        $this->imagen = $ruta . 'utensilioPredeterminado.png';
    } else if ($imgState === 'SI' && $imagen !== null) {
        $validacion = $this->validarImagen($imagen);
        if ($validacion !== true) {
            return $validacion; 
        }
        $mime = mime_content_type($imagen['tmp_name']);
        $extension = match($mime) {
            'image/jpeg', 'image/jpg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
            default      => 'png'
        };

        $destino = $ruta . $codigo . "." . $extension;
        $this->imagen = $destino;

        if (!move_uploaded_file($imagen['tmp_name'], $destino)) {
            return ['resultado' => 'Error al guardar la imagen en el servidor'];
        }
    }

    return $this->registrar();
}

private function registrar() {
    try {
        $this->conectarDB();
        $this->conex->beginTransaction();

        $stmt = $this->conex->prepare("CALL sp_registrar_utensilio(?, ?, ?, ?)");
        $stmt->bindValue(1, $this->imagen);
        $stmt->bindValue(2, $this->utensilio);
        $stmt->bindValue(3, $this->material);
        $stmt->bindValue(4, $this->tipoU);
        $stmt->execute();

        $this->conex->commit();
        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora('Utensilio', 'Registró un Utensilio llamado: ' . $this->utensilio, $this->payload->cedula); 
        $this->desconectarDB();

        return ['resultado' => 'registrado'];
    } catch (Exception $error) {
        $this->conex->rollBack(); 
        $this->desconectarDB();
        return ['resultado' => '¡Error Sistema!'];
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

      $parte1 = substr($palabra1, 0, 2);
      $parte2 = substr($palabra2, 0, 2);
    
      $numerosAleatorios = rand(10, 99); 
      $codigo = $parte1 . $parte2 . $numerosAleatorios;
      
      return $codigo;
  }

}