<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;

class PermisoModelo extends connectDB
{

    private $id;
    private $modulos;
    private $datos;
    private $payload;


    public function __construct()
    {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    public function obtenerRoles()
    {
        try {
            $this->conectarDBSeguridad();
            $new = $this->conex2->prepare("SELECT * FROM `rol` WHERE status=1;");
            $new->execute();
            $data = $new->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al obtener los roles: ' . $e->getMessage());
        }
    }


    public function obtenerModulos()
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT * FROM `modulo` WHERE status=1;");
            $query->execute();
            $data = $query->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al obtener los modulos: ' . $e->getMessage());
        }
    }


    public function getPermisos($id)
    {
        if (!preg_match("/^[0-9]{1,}$/", $id)) {
            $resultado = ['resultado' => 'Ingresar el id del modulo'];
            return $resultado;
        } else {
            $this->id = $id;
            return $this->obtenerPermisos();
        }
    }

    private function obtenerPermisos()
    {
        try {
            $this->conectarDBSeguridad();
            $sql = 'SELECT rol.nombreRol, permiso.idRol, rol.status, modulo.nombreModulo, permiso.idModulo,
                     modulo.status, permiso.nombrePermiso, permiso.idPermiso, permiso.status
                     FROM permiso INNER JOIN modulo ON modulo.idModulo = permiso.idModulo 
                     INNER JOIN rol ON rol.idRol = permiso.idRol WHERE permiso.idModulo = ? AND rol.status = 1;';
            $stmt = $this->conex2->prepare($sql);
            $stmt->bindValue(1, $this->id);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException('Error al obtener los permisos: ' . $e->getMessage());
        }
    }

    public function actualizarPermisos($datos)
    {
        $errores = [];

        if (!is_array($datos)) {
            $errores[] = 'Los datos proporcionados no son un arreglo';
        } else {
            foreach ($datos as $permisoData) {
                if (!isset($permisoData['idPermiso']) || !preg_match("/^[0-9]+$/", $permisoData['idPermiso'])) {
                    $errores[] = 'Ingresar un idPermiso válido (solo números enteros)';
                }
                if (!isset($permisoData['status']) || !preg_match("/^[0-1]{1}$/", $permisoData['status'])) {
                    $errores[] = 'El valor de status no es válido. Valores permitidos: 1, 0';
                }
            }
        }

        if (!empty($errores)) {
            return ['resultado' => implode(", ", $errores)];
        }

        $this->datos = $datos;
        $resultado = $this->guardarPermisos();
        return $resultado ?? null;
    }


    public function guardarPermisos()
    {
        try {
            $this->conectarDBSeguridad();
            $this->conex2->beginTransaction();

            foreach ($this->datos as $permisoData) {
                $idPermiso = $permisoData['idPermiso'];
                $status = ($permisoData['status'] === '1') ? 1 : 0;

                try {
                    $stmt = $this->conex2->prepare("UPDATE permiso SET status = ? WHERE idPermiso = ?;");
                    $stmt->bindValue(1, $status, PDO::PARAM_INT);
                    $stmt->bindValue(2, $idPermiso, PDO::PARAM_INT);
                    $stmt->execute();
                } catch (\PDOException $e) {
                    return ['error' => $e->getMessage()];
                }
            }

            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Permisos', 'Modificó los Permisos de los roles y módulos ', $this->payload->cedula);
            $this->conex2->commit();

            return ['resultado' => 'modificado'];
        } catch (\Exception $e) {
            $this->conex2->rollBack();
            throw new \RuntimeException('Error al modificar los permisos: ' . $e->getMessage());
        } finally {
            $this->desconectarDB();
        }
    }



}

?>