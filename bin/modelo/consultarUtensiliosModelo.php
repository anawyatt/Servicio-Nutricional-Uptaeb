<?php 

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers as JwtHelpers;
use \PDO;


class consultarUtensiliosModelo extends connectDB {

    private $tipoA;
    private $alimento;
    private $material;
    private $imagen;
    private $id;
    private $payload;

    public function __construct() {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    } 

 public function mostrarUtensilios() {
    try {
        $this->conectarDB();
        $query = $this->conex->query("
            SELECT * FROM utensilios u 
            INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU 
            WHERE u.status = 1
        ");
        $data = $query->fetchAll(\PDO::FETCH_OBJ);
        $this->desconectarDB();
        return $data;
    } catch (\PDOException $e) {
        return ['error' => '¡Error en el sistema!'];
    }
}



public function verificarExistencia($id) {
    if (!ctype_digit($id)) {
        return ['error' => 'ID inválido.'];
    }

    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("SELECT 1 FROM utensilios WHERE idUtensilios = ? AND status = 1");
        $stmt->execute([$id]);
        $existe = $stmt->fetch();
        $this->desconectarDB();

        return $existe ? null : ['resultado' => 'ya no existe'];
    } catch (\Exception $e) {
        $this->desconectarDB();
        return ['error' => '¡Error en el sistema!'];
    }
}

public function infoUtensilio($id) {
    if (!ctype_digit($id)) {
        return ['error' => 'ID inválido.'];
    }

    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("
            SELECT * FROM utensilios u 
            INNER JOIN tipoutensilios tu ON u.idTipoU = tu.idTipoU 
            WHERE u.idUtensilios = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $this->desconectarDB();

        return $data ?: ['resultado' => 'No se encontró utensilio.'];
    } catch (\PDOException $e) {
        return ['error' => '¡Error en el sistema!'];
    }
}

public function verificarExistenciaTipoU($tipoU) {
    if (!preg_match("/^\d+$/", $tipoU)) {
        return ['resultado' => 'Seleccionar un tipo de utensilio válido'];
    }

    $this->tipoU = $tipoU;
    return $this->consultarExistenciaTipoU();
}

private function consultarExistenciaTipoU() {
    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("SELECT idTipoU FROM tipoutensilios WHERE status = 1 AND idTipoU = ?");
        $stmt->bindValue(1, $this->tipoU);
        $stmt->execute();
        $existe = $stmt->fetch();
        $this->desconectarDB();

        return $existe ? ['resultado' => 'ok'] : ['resultado' => 'no esta'];
    } catch (\Exception $e) {
        $this->desconectarDB();
        return ['error' => '¡Error en el sistema!'];
    }
}




public function mostrarTipoUtensilio() {
    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("SELECT * FROM tipoutensilios WHERE status = 1");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $this->desconectarDB();

        return empty($data)
            ? ['resultado' => 'No se encontraron tipos de utensilios.']
            : $data;
    } catch (\PDOException $e) {
        $this->desconectarDB();
        return ['error' => '¡Error en el sistema!'];
    }
}




public function verificarModificacion($id) {
    if (!preg_match('/^\d+$/', $id)) {
        return ['resultado' => 'ID inválido.'];
    }

    $this->id = $id;
    return $this->consultarModificacion();
}

private function consultarModificacion() {
    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("
            SELECT idUtensilios 
            FROM utensilios 
            WHERE idUtensilios = ? 
            AND idUtensilios IN (
                SELECT idUtensilios 
                FROM detalleentradau 
                WHERE status = 1
            )
        ");
        $stmt->bindValue(1, $this->id);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $this->desconectarDB();

        return [
            'resultado' => isset($data[0]['idUtensilios']) 
                ? 'no se puede' 
                : 'se puede'
        ];
    } catch (\Exception $e) {
        $this->desconectarDB();
        return ['error' => '¡Error en el sistema!'];
    }
}

public function verificarUtensilio($id, $tipoU, $utensilio, $material) {
    $validacion = $this->validarDatosUtensilio($id, $tipoU, $utensilio, $material);
    if ($validacion) return $validacion;

    $this->id = $id;
    $this->tipoU = $tipoU;
    $this->utensilio = $utensilio;
    $this->material = $material;

    return $this->consultarUtensilio();
}

public function modificarUtensilio($id, $tipoU, $utensilio, $material) {
    $validacion = $this->validarDatosUtensilio($id, $tipoU, $utensilio, $material);
    if ($validacion) return $validacion;

    $this->id = $id;
    $this->tipoU = $tipoU;
    $this->utensilio = $utensilio;
    $this->material = $material;

    return $this->modificarU();
}

private function validarDatosUtensilio($id, $tipoU, $utensilio, $material) {
    if (!preg_match('/^\d+$/', $id) || !preg_match('/^\d+$/', $tipoU)) {
        return ['resultado' => 'ID y tipo de utensilio deben ser números enteros positivos.'];
    }

    if (empty(trim($utensilio)) || !preg_match('/^[a-zA-Z0-9\s]+$/', $utensilio)) {
        return ['resultado' => 'El nombre del utensilio es inválido.'];
    }

    if (empty(trim($material)) || !preg_match('/^[a-zA-Z0-9\s]+$/', $material)) {
        return ['resultado' => 'El material es inválido.'];
    }

    return null;
}

private function consultarUtensilio() {
    try {
        $this->conectarDB();
        $stmt = $this->conex->prepare("
        SELECT nombre 
        FROM vista_utensilios_activos
        WHERE idTipoU = ? AND nombre = ? AND material = ? 
        AND idUtensilios != ?
    ");
        $stmt->bindValue(1, $this->tipoU);
        $stmt->bindValue(2, $this->utensilio);
        $stmt->bindValue(3, $this->material);
        $stmt->bindValue(4, $this->id);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $this->desconectarDB();

        return isset($data[0]['nombre']) 
            ? ['resultado' => 'existe'] 
            : null;

    } catch (\PDOException $e) {
    $this->desconectarDB();
    error_log("Error en consultarUtensilio: " . $e->getMessage());

    return ['error' => 'Error al consultar utensilio: ' . $e->getMessage()];

}
}

private function modificarU() {
    try {
        $this->conectarDB();
        $this->conex->beginTransaction();

        $stmt = $this->conex->prepare("CALL sp_modificar_utensilio(?, ?, ?, ?)");
        $stmt->bindValue(1, $this->id);
        $stmt->bindValue(2, $this->utensilio);
        $stmt->bindValue(3, $this->material);
        $stmt->bindValue(4, $this->tipoU);
        $stmt->execute();

        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora('Utensilios', 'Modificó el Utensilio llamado: ' . $this->utensilio, $this->payload->cedula);

        $this->conex->commit();
        $this->desconectarDB();

        return ['resultado' => 'modificado'];
    } catch (\PDOException $e) {
        if ($this->conex->inTransaction()) {
            $this->conex->rollBack();
        }
        $this->desconectarDB();

        return ['error' => $e->getMessage()];
    }
}




public function modificarImagen($imagen, $id) {
    $info = $this->infoUtensilio($id, true);

    if (empty($info)) {
        return ['error' => 'Utensilio no encontrado'];
    }

    // Validación robusta de imagen dañada, tipo y tamaño (igual que en registro)
    if (!isset($imagen['tmp_name']) || !file_exists($imagen['tmp_name'])) {
        return ['resultado' => 'No se recibió imagen'];
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

    $rand = $this->generarCodigo($info[0]->nombre, $info[0]->material);
    $ruta = "assets/images/utensilios/";
    $nombreArchivo = $ruta . $rand . '.png';

    if (!move_uploaded_file($imagen['tmp_name'], $nombreArchivo)) {
        return ['error' => 'Error al mover la imagen subida'];
    }

    $this->imagen = $nombreArchivo;
    $this->id = $id;

    return $this->actualizarImagenDB();
}

private function actualizarImagenDB() {
    try {
        $this->conectarDB();
        $this->conex->beginTransaction();


        $stmt = $this->conex->prepare("SELECT imgUtensilios FROM utensilios WHERE idUtensilios = ? FOR UPDATE");
        $stmt->bindValue(1, $this->id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!empty($data['imgUtensilios'])) {
            $nombreImagen = basename($data['imgUtensilios']);
            if ($nombreImagen !== 'utensiliospredeterminados.png') {
                $rutaImagen = __DIR__ . '/../../' . $data['imgUtensilios'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
        }

        $update = $this->conex->prepare("UPDATE utensilios SET imgUtensilios = ? WHERE idUtensilios = ? AND status = 1");
        $update->bindValue(1, $this->imagen);
        $update->bindValue(2, $this->id);
        $update->execute();

        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora('Utensilios', 'Actualizó la imagen del utensilio con ID: ' . $this->id, $this->payload->cedula);

        $this->conex->commit();
        $this->desconectarDB();

        return ['resultado' => 'imagen modificada'];
    } catch (\PDOException $e) {
        if ($this->conex->inTransaction()) {
            $this->conex->rollBack();
        }
        $this->desconectarDB();
        return ['error' => 'Error en el sistema: ' . $e->getMessage()];
    }
}


private function generarCodigo($palabra1, $palabra2) {
    $palabra1 = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $this->quitarAcentos($palabra1)));
    $palabra2 = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $this->quitarAcentos($palabra2)));

    $parte1 = substr($palabra1, 0, 3);
    $parte2 = substr($palabra2, 0, 3);
    $numerosAleatorios = rand(10, 99);

    return $parte1 . $parte2 . $numerosAleatorios;
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
  
  
  public function anularUtensilio($id) {
    if (!preg_match("/^[0-9]+$/", $id)) {
        return ['error' => 'ID de utensilio no válido'];
    }

    $this->id = $id;
    return $this->anular();
}

private function anular() {
    try {
        $this->conectarDB();
        $this->conex->beginTransaction();

        $query = $this->conex->prepare("SELECT imgUtensilios FROM utensilios WHERE idUtensilios = ? FOR UPDATE");
        $query->bindValue(1, $this->id);
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!empty($data['imgUtensilios'])) {
            $nombreImagen = basename($data['imgUtensilios']);
            if ($nombreImagen !== 'utensiliospredeterminados.png') {
                $ruta = __DIR__ . '/../../' . $data['imgUtensilios'];
                if (file_exists($ruta)) {
                    unlink($ruta);
                }
            }
        }

        $stmt = $this->conex->prepare("UPDATE utensilios SET status = 0 WHERE idUtensilios = ?");
        $stmt->bindValue(1, $this->id);
        $stmt->execute();

        $bitacora = new bitacoraModelo;
        $bitacora->registrarBitacora('Utensilios', 'Se anuló un Utensilio con ID: ' . $this->id, $this->payload->cedula);

        $this->conex->commit();
        $this->desconectarDB();

        return ['resultado' => 'eliminado'];
    } catch (\PDOException $e) {
        if ($this->conex->inTransaction()) {
            $this->conex->rollBack();
        }
        $this->desconectarDB();
        return ['error' => '¡Error en el sistema!'];
    }
}


private function delete($rutaImagen) {
    if (file_exists($rutaImagen)) {
        unlink($rutaImagen);
    }
}




}


