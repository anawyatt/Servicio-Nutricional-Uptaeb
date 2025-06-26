<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use \PDO;


class tipoSalidaModelo extends connectDB
{
    private $tipoSalida;
    private $id;
    private $tipoS;
    private $payload;

    public function __construct()
    {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    public function verificarTipoSalida($tipoS, $returnData = true)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $tipoS)) {
            $mensaje = ['resultado' => 'Tipo de salida inválido.'];
            if ($returnData) {
                echo json_encode($mensaje);
            }
            return $mensaje;
        }

        $this->tipoS = $tipoS;
        return $this->verificarTipoSalida2($tipoS, $returnData);
    }

    private function verificarTipoSalida2($tipoS, $returnData = true)
    {
        try {
            $this->conectarDB();
            $new = $this->conex->prepare("SELECT tipoSalida FROM `tiposalidas` WHERE tipoSalida = ? AND status = 1");
            $new->bindValue(1, $this->tipoS);
            $new->execute();
            $data = $new->fetchAll();
            $this->desconectarDB();

            if (isset($data[0]["tipoSalida"])) {
                $mensaje = ['resultado' => 'error tipo'];
                if ($returnData) {
                    echo json_encode($mensaje);
                    die();
                }
                return $mensaje;
            }
        } catch (\PDOException $e) {
            $mensaje = ['resultado' => '¡Error en el sistema!'];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }
    }

    public function registrarTipoSalida($tipoS)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $tipoS)) {
            $mensaje = ['resultado' => 'Tipo de salida inválido.'];
            return $mensaje;
        }

        $this->tipoS = $tipoS;
        return $this->registrar();
    }

    private function registrar()
    {
        try {
            $this->conectarDB();
            $this->conex->beginTransaction();

            // Insertar el nuevo tipo de salida
            $new = $this->conex->prepare("INSERT INTO `tiposalidas`(`idTipoSalidas`, `tipoSalida`, `status`) VALUES (DEFAULT, ?, 1)");
            $new->bindValue(1, $this->tipoS);
            $new->execute();

            // Registrar en la bitácora
            $bitacora = new bitacoraModelo;
            $bitacora->registrarBitacora('Tipos Salidas', 'Registró un Tipo Salida llamado: ' . $this->tipoS,  $this->payload->cedula);

            $this->conex->commit();

            // Respuesta en caso de éxito
            $mensaje = ['resultado' => 'registrado'];
            return $mensaje;
        } catch (\Exception  $e) {
            $this->conex->rollBack();
            $mensaje = ['error' => $e->getMessage()];
            return $mensaje;
        } finally {
            $this->desconectarDB();
        }
    }





    public function tabla()
    {

        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare(" SELECT * FROM tiposalidas WHERE status=1  ");
            $mostrar->execute();
            $data = $mostrar->fetchAll(\PDO::FETCH_OBJ);
            $this->desconectarDB();
            echo json_encode($data);
            die();
        } catch (\Exception $error) {

            return array("Sistema", "¡Error Sistema!");
        }
    }


    public function mostrarTipoS($id, $returnData = true)
    {
        if (!preg_match("/^\d+$/", $id)) {
            $mensaje = ['resultado' => 'ID inválido.'];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }

        $this->id = $id;
        return $this->mostrarTipoS2($id, $returnData);
    }

    private function mostrarTipoS2($id, $returnData = true)
    {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM tiposalidas WHERE idTipoSalidas = ?");
            $mostrar->bindValue(1, $this->id);
            $mostrar->execute();
            $data = $mostrar->fetchAll();
            $this->desconectarDB();

            if ($returnData) {
                echo json_encode($data);
                die();
            }
            return $data;
        } catch (\Exception $error) {
            $mensaje = ["resultado" => "¡Error en el sistema!"];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }
    }




    public function verificarModificacion($id, $returnData = true)
    {
        if (!preg_match("/^\d+$/", $id)) {
            $mensaje = ['resultado' => 'ID inválido.'];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }

        $this->id = $id;
        return $this->verificarModificacion2($id, $returnData);
    }

    private function verificarModificacion2($id, $returnData = true)
    {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT ts.tipoSalida FROM tipoSalidas ts LEFT JOIN salidaAlimentos sa ON ts.idTipoSalidas = sa.idTipoSalidaA AND sa.status = 1 LEFT JOIN salidaUtensilios su ON ts.idTipoSalidas = su.idTipoSalidas AND su.status = 1 WHERE ts.idTipoSalidas = ? AND (sa.idSalidaA IS NOT NULL OR su.idSalidaU IS NOT NULL);");
            $mostrar->bindValue(1, $this->id);
            $mostrar->execute();
            $data = $mostrar->fetchAll();
            $this->desconectarDB();

            $mensaje = (isset($data[0]["tipoSalida"]))
                ? ['resultado' => 'no se puede']
                : ['resultado' => 'se puede'];

            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        } catch (\Exception $error) {
            $mensaje = ["resultado" => "¡Error en el sistema!"];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }
    }

    public function verificarExistencia($id, $returnData = true)
    {
        if (!preg_match("/^\d+$/", $id)) {
            $mensaje = ['resultado' => 'ID inválido.'];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }

        $this->id = $id;
        return $this->verificarExistencia2($id, $returnData);
    }

    private function verificarExistencia2($id, $returnData = true)
    {
        try {
            $this->conectarDB();
            $mostrar = $this->conex->prepare("SELECT * FROM tiposalidas WHERE idTipoSalidas = ? AND status = 1");
            $mostrar->bindValue(1, $this->id);
            $mostrar->execute();
            $data = $mostrar->fetchAll();
            $this->desconectarDB();

            if (!isset($data[0]["idTipoSalidas"])) {
                $mensaje = ['resultado' => 'ya no existe'];
                if ($returnData) {
                    echo json_encode($mensaje);
                    die();
                }
                return $mensaje;
            }


            return null;
        } catch (\Exception $error) {
            $mensaje = ["resultado" => "¡Error en el sistema!"];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }
    }


    public function verificarTipoS2($tipoS, $id, $returnData = true)
    {
        $this->tipoS = $tipoS;
        $this->id = $id;
        return $this->verificar2($returnData);
    }

    private function verificar2($returnData = true)
    {
        try {
            $this->conectarDB();
            $verificar = $this->conex->prepare("SELECT tipoSalida FROM `tiposalidas` WHERE tipoSalida = ? AND idTipoSalidas != ? AND status = 1");
            $verificar->bindValue(1, $this->tipoS);
            $verificar->bindValue(2, $this->id);
            $verificar->execute();
            $data = $verificar->fetchAll();
            $this->desconectarDB();

            if (isset($data[0]["tipoSalida"])) {
                $mensaje = ['resultado' => 'error tipo'];
                if ($returnData) {
                    echo json_encode($mensaje);
                    die();
                }
                return $mensaje;
            }
        } catch (\Exception $error) {
            $mensaje = ["resultado" => "¡Error en el sistema!"];
            if ($returnData) {
                echo json_encode($mensaje);
                die();
            }
            return $mensaje;
        }
    }

    public function modificarTipoSalida($tipoS, $id)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $tipoS) || !preg_match("/^\d+$/", $id)) {
            $mensaje = ['resultado' => 'Datos inválidos.'];
            return $mensaje;
        }

        $this->tipoS = $tipoS;
        $this->id = $id;
        return $this->modificar();
    }

    private function modificar()
    {
        try {
            $this->conectarDB();
            $this->conex->beginTransaction();

            // Modificación del tipo de salida
            $modificar = $this->conex->prepare("UPDATE `tiposalidas` SET tipoSalida = ? WHERE idTipoSalidas = ?");
            $modificar->bindValue(1, $this->tipoS);
            $modificar->bindValue(2, $this->id);
            $modificar->execute();

            if ($modificar->rowCount() > 0) {

                try {
                    $bitacora = new bitacoraModelo;
                    $bitacora->registrarBitacora('Tipos Salidas', 'Se Modificó un Tipo Salida llamado: ' . $this->tipoS, $this->payload->cedula);
                } catch (\Exception $e) {
                    // Registrar el error de bitácora (opcional)
                    error_log("Error al registrar en la bitácora: " . $e->getMessage());
                }

                // Confirmar transacción
                $this->conex->commit();
                $mensaje = ['resultado' => 'Editado correctamente'];
            } else {
                // No se realizaron cambios
                $this->conex->rollBack();
                $mensaje = ['resultado' => 'No se encontró el tipo de salida o no hubo cambios'];
            }
            return $mensaje;
        } catch (\PDOException $e) {
            $this->conex->rollBack();
            $mensaje = ['error' => $e->getMessage()];
            return $mensaje;
        } finally {
            $this->desconectarDB();
        }
    }





    public function anularTipoSalida($id)
    {
        if (!preg_match("/^\d+$/", $id)) {
            $mensaje = ['resultado' => 'ID inválido.'];

            return $mensaje;
        }

        $this->id = $id;
        return $this->anular();
    }

    private function anular()
    {
        try {
            $this->conectarDB();
            $this->conex->beginTransaction();

            // Verificar la existencia del tipo de salida
            $querySelect = $this->conex->prepare("SELECT `tipoSalida` FROM `tiposalidas` WHERE idTipoSalidas = ? AND status = 1");
            $querySelect->bindValue(1, $this->id);
            $querySelect->execute();
            $resultado = $querySelect->fetch(\PDO::FETCH_ASSOC);

            if ($resultado) {
                $nombreTipo = $resultado['tipoSalida'];

                // Anular el tipo de salida
                $anular = $this->conex->prepare("UPDATE `tiposalidas` SET `status` = '0' WHERE idTipoSalidas = ?");
                $anular->bindValue(1, $this->id);
                $anular->execute();

                if ($anular->rowCount() > 0) {
                    // Registrar en la bitácora
                    try {
                        $bitacora = new bitacoraModelo;
                        $bitacora->registrarBitacora('Tipos Salidas', 'Se anuló un Tipo Salida llamado: ' . $nombreTipo, $this->payload->cedula);
                    } catch (\Exception $e) {
                        error_log("Error al registrar en la bitácora: " . $e->getMessage());
                    }

                    // Confirmar transacción
                    $this->conex->commit();
                    $mensaje = ['resultado' => 'anulado correctamente.'];
                } else {
                    // Si no se realizó la anulación
                    $this->conex->rollBack();
                    $mensaje = ['mensaje' => 'No se encontró el tipo de Salida o no se pudo anular'];
                }
            } else {
                // Si el tipo de salida no existe
                $this->conex->rollBack();
                $mensaje = ['mensaje' => 'No se encontró el tipo de Salida'];
            }


            return $mensaje;
        } catch (\PDOException $e) {
            // Manejo de errores y rollback
            $this->conex->rollBack();
            $mensaje = ['error' => $e->getMessage()];

            return $mensaje;
        } finally {
            $this->desconectarDB();
        }
    }
}
