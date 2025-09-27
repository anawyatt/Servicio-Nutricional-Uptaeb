<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use helpers\encryption;

class bitacoraModelo extends connectDB
{
    private $usuario;
    private $modulo;
    private $acciones;
    private $fechaInicio;
    private $fechaFin;
    private $payload;
    private $encryption;


    public function __construct()
    {
        parent::__construct();
        if (isset($_COOKIE['jwt']) && !empty($_COOKIE['jwt'])) {
            $token = $_COOKIE['jwt'];
            $this->payload = JwtHelpers::validarToken($token);
        } else {
            
            $this->payload = null; // o un array vacío, según convenga
        }

        $this->encryption = new encryption();
    }

 public function registrarBitacora($modulo, $acciones, $usuario)
{
    // Validaciones con expresiones regulares
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $modulo) ||
        !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $acciones) ||
        !preg_match("/^\d+$/", $usuario)
    ) {
        return ['resultado' => 'Datos inválidos'];
    }

    $this->modulo = $modulo;
    $this->acciones = $acciones;
    $this->usuario = $usuario;

    $this->conectarDBSeguridad();
    try {
        $registrar = $this->conex2->prepare("CALL sp_registrar_bitacora(?, ?, ?)");
        $registrar->bindValue(1, $this->modulo);
        $registrar->bindValue(2, $this->acciones);
        $registrar->bindValue(3, $this->usuario);
        $registrar->execute();
    } catch (\Exception $error) {
        return ["Sistema", "¡Error Sistema!"];
    } finally {
        $this->desconectarDB();
    }
}



    public function mostrarBitacora($fechaInicio, $fechaFin, $start = 0, $length = 10, $searchValue = '', $orderBy = 'fecha', $orderDir = 'desc')
    {
        if (empty($fechaInicio) && empty($fechaFin)) {
            return $this->mostrarBitacora1($start, $length, $searchValue, $orderBy, $orderDir);
        }

        if (
            !preg_match("/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/", $fechaInicio) ||
            !preg_match("/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/", $fechaFin)
        ) {
            return [
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'resultado' => '¡Fecha inválida!'
            ];
        }

        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;

        return $this->mostrarBitacora1($start, $length, $searchValue, $orderBy, $orderDir);
    }

    private function mostrarBitacora1($start = 0, $length = 10, $searchValue = '', $orderBy = 'fecha', $orderDir = 'desc')
    {
        if (!is_object($this->payload) || !isset($this->payload->cedula)) {
            throw new \Exception("Usuario no autenticado o token inválido");
        }

        $cedula = $this->payload->cedula;
        $this->conectarDBSeguridad();

        try {
            // Obtener idRol
            $mostrarRol = $this->conex2->prepare("SELECT idRol FROM usuario WHERE cedula = ?");
            $mostrarRol->bindValue(1, $cedula);
            $mostrarRol->execute();
            $rolUsuario = $mostrarRol->fetch(\PDO::FETCH_OBJ);

            if (!$rolUsuario) {
                return [
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'resultado' => 'No se pudo obtener el rol del usuario'
                ];
            }

            // Llamar al procedure con paginación
            $stmt = $this->conex2->prepare("CALL proc_mostrar_bitacora1(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $cedula);
            $stmt->bindValue(2, $rolUsuario->idRol);
            $stmt->bindValue(3, $this->fechaInicio ?: null);
            $stmt->bindValue(4, $this->fechaFin ?: null);
            $stmt->bindValue(5, $start);
            $stmt->bindValue(6, $length);
            $stmt->bindValue(7, $searchValue);
            $stmt->bindValue(8, $orderBy);
            $stmt->bindValue(9, $orderDir);
            $stmt->execute();

            // Obtener los datos
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
            foreach ($data as $item) {
                if (isset($item->cedula)) {
                    $item->cedula = $this->encryption->encryptData($item->cedula);
                }
                if (isset($item->idBitacora)) {
                    $item->idBitacora = $this->encryption->encryptData($item->idBitacora);
                }
            }

            // Obtener el total de registros (sin paginación)
            $stmt->nextRowset();
            $totalResult = $stmt->fetch(\PDO::FETCH_OBJ);
            $recordsTotal = $totalResult ? $totalResult->total : 0;

            // Obtener el total filtrado
            $stmt->nextRowset();
            $filteredResult = $stmt->fetch(\PDO::FETCH_OBJ);
            $recordsFiltered = $filteredResult ? $filteredResult->filtered : $recordsTotal;

            return [
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'resultado' => '¡Error del sistema!'
            ];
        } finally {
            $this->desconectarDB();
        }
    }


    public function verAccionesDeBitacora($idEncriptado, $idBitacoraEncriptado)
    {
        try {
            // Desencriptar los parámetros recibidos
            $id = $this->encryption->decryptData($idEncriptado);
            $idBitacora = $this->encryption->decryptData($idBitacoraEncriptado);

            $this->conectarDBSeguridad();

            $query = $this->conex2->prepare("CALL proc_ver_acciones_bitacora(?, ?)");
            $query->bindValue(1, $id);
            $query->bindValue(2, $idBitacora);
            $query->execute();

            $data = $query->fetchAll(\PDO::FETCH_OBJ);

            $this->desconectarDB();

            return $data;
        } catch (\PDOException $e) {
            return ['resultado' => 'Error al obtener acciones de bitácora.'];
        }
    }
}
