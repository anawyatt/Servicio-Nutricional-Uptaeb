<?php

namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;


class alimentosModelo extends connectDB
{
    private $tipoA;
    private $alimento;
    private $marca;
    private $unidad;
    private $imagen;
    private $payload;
    private $usuario;
    private $codigo;


    public function __construct()
    {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
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
            throw new \RuntimeException('Error al verificar tipo de alimento: ' . $e->getMessage());
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
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al mostrar los tipos de alimentos: ' . $e->getMessage());
        }
    }


    public function verificarAlimento( $alimento, $marca, $unidad)
    {
        $errores = [];

        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]{3,}$/", $alimento)) {
            $errores[] = 'Ingresar un alimento correctamente';
        }

        if (!preg_match("/^(Sin Marca|[a-zA-ZÀ-ÿ\s]{3,})$/", trim($marca))) {
            $errores[] = 'Ingresar una marca correctamente';
        }
        if (!preg_match("/^\d*\s*[a-zA-Z]+$/", trim($unidad))) {
            $errores[] = 'Ingresar la unidad correctamente';
        }

        if (!empty($errores)) {
            $mensaje = ['resultado' => implode(", ", $errores)];
            return $mensaje;
        } else {
            $this->alimento = $alimento;
            $this->marca = $marca;
            $this->unidad = $unidad;
            $resultado = $this->verificarA();
            return $resultado === true ? ['resultado' => 'existe'] : ['resultado' => 'no esta duplicado'];

        }

    }

    private function verificarA()
    {

        try {
            $this->conectarDB();
            $verificar = $this->conex->prepare("SELECT nombre FROM alimento WHERE status =1  and nombre =? and marca =? and unidadMedida =?");
            $verificar->bindValue(1, $this->alimento);
            $verificar->bindValue(2, $this->marca);
            $verificar->bindValue(3, $this->unidad);
            $verificar->execute();
            $data = $verificar->fetchAll();
            $this->desconectarDB();
            return !empty($data);

        } catch (\Exception $e) {
            throw new \RuntimeException('Error al verifcar duplicacion de alimentos: ' . $e->getMessage());
        }

    }

    public function registrarAlimento($imagen, $men, $tipoA, $alimento, $marca, $unidad)
    {
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
        if (!preg_match("/^\d*\s*[a-zA-Z]+$/", $unidad)) {
            $errores[] = 'Ingresar la unidad correctamente';
      }

        if (!empty($errores)) {
            $mensaje = ['resultado' => implode(", ", $errores)];
            return $mensaje;
        } 
        if ($this->verificarAlimento($alimento, $marca, $unidad)['resultado'] == 'existe') {
            return ['resultado' => 'existe'];
        }
        
        
        else {
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

            return $this->registrar();
        }
    }

    private function registrar()
    {
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

            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Alimentos', 'Registró un Alimento llamado: ' . $this->alimento, $this->payload->cedula);

            $this->conex->commit();
            return ['resultado' => 'registrado'];

        } catch (\Exception $e) {
            $this->conex->rollBack();
            throw new \RuntimeException('Error al verifcar duplicacion de alimentos: ' . $e->getMessage());
        } finally {
            $this->desconectarDB();
        }
    }

    function validarImagen($imagen)
    {
        if ($imagen['error'] !== UPLOAD_ERR_OK) {
            return ['resultado' => 'Error al subir la imagen'];
        }
        $mime = mime_content_type($imagen['tmp_name']);
        $formatosValidos = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];

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


}


