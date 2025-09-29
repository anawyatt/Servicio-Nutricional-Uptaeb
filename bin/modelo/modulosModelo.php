<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDOException;

class ModulosModelo extends connectDB
{
    private $id;
    private $estado;
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


    public function mostrarModulosAjax()
    {
        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT * FROM `modulo`");
            $query->execute();
            $data = $query->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function getModulo($id)
    {
        $this->id = $id;


        try {
            $this->conectarDBSeguridad();
            $query = $this->conex2->prepare("SELECT * FROM `modulos`");
            $query->bindValue(1, $this->id);
            $query->execute();
            $data = $query->fetchAll();
            $this->desconectarDB();
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }


    public function editarModulo($estado, $id)
    {
        try {
            $this->estado = $estado;
            $this->id = $id;
            return $this->actualizarModulo(); // 👈 Faltaba el return
        } catch (\Exception $e) {
            return ['mensaje' => $e->getMessage()]; 
        }
    }

    private function actualizarModulo()
    {
        try {
            $this->conectarDBSeguridad();
            $this->conex2->beginTransaction();
            $query = $this->conex2->prepare("UPDATE modulo SET `status` = ? WHERE idModulo = ?");
            $query->bindValue(1, $this->estado);
            $query->bindValue(2, $this->id);
            $query->execute();
            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Módulo', 'Modificó el estado de un módulo ', $this->payload->cedula);

            $this->conex2->commit();
            $this->desconectarDB();
            return ['mensaje' => 'Módulo actualizado exitosamente']; 
        } catch (\PDOException $e) {
            $this->conex2->rollBack();
            return $e;
        }
    }

    

    
}
