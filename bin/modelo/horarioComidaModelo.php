<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\encryption as encryption;
use \PDO;
use helpers\JwtHelpers;

class horarioComidaModelo extends connectDB
{
    private $horario;
    private $sistem;
    private $idMenu;
    private $alimento;
    private $cantidad;
    public function __construct()
    {
        parent::__construct();
        $this->sistem = new encryption();
    }

    

    public function ingresar($horario)
    {
        $this->horario = $horario;

        if (!isset($_COOKIE['jwt'])) {
            http_response_code(401); 
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Token no encontrado']);
            exit;
        }

        $token = $_COOKIE['jwt'];

        // Decodificar token para obtener payload actual
        $payload = JwtHelpers::validarToken($token);

        if (!$payload) {
            http_response_code(401); // Token inválido o expirado
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Token inválido o expirado']);
            exit;
        }

        $payloadArray = (array) $payload;
        $payloadArray['horario_comida'] = $this->horario;

        $nuevoToken = JwtHelpers::generarToken($payloadArray);

        setcookie('jwt', $nuevoToken, time() + 3600*6, "/", "", false, true);  // Considera agregar "secure" si usas HTTPS

        $bitacora = new bitacoraModelo();
        $bitacora->registrarBitacora('Login', 'El Usuario '. $payload->nombre.' '.$payload->apellido.': Inició al sistema en el horario de '.$payload->horario_comida,  $payload->cedula);

        // Enviar respuesta con URL para redirigir
        $url = urlencode($this->sistem->encryptURL('home'));  // Redirige al Home

        echo json_encode([
            'resultado' => 'success',
            'url' => '?url=' . $url
        ]);

        exit;
    }


     


    public function inactividad()
    {
        $this->sistem = new encryption();
        $mensaje = ['url' => '?url=' . urlencode($this->sistem->encryptURL('inactividad'))];
        echo json_encode($mensaje);
        die();
    }

    public function descontarAlimentos()
    {
        try {
            $this->conectarDB();
            $this->conex->beginTransaction();
            $menu = $this->consultarMenuHoy();

            foreach ($menu as $menus) {
                $this->conectarDBSeguridad();
                $verificar = $this->conex2->prepare("SELECT * FROM bitacora WHERE modulo = ? AND acciones = ?");
                $verificar->bindValue(1, 'Menú');
                $verificar->bindValue(2, 'Se descontaron los alimentos del Menú ' . $menus['idMenu']);
                $verificar->execute();
                $data = $verificar->fetchAll(PDO::FETCH_ASSOC);

                if (empty($data)) {
                    // Si no hay datos, procede a descontar los reservados
                    $this->descontarReservados($menus['idMenu']);
                }

                // Mensaje de éxito por cada menú procesado
                $mensaje = ['info' => 'Se descontaron los alimentos del reservado del Menú ' . $menus['idMenu']];
                echo json_encode($mensaje);
            }

            // Si todo salió bien, se confirma la transacción
            $this->conex->commit();
            return;
        } catch (\PDOException $e) {
            // Rollback en caso de error
            $this->conex->rollBack();
            echo json_encode(['error' => $e->getMessage()]);
            return;
        } finally {
            // Desconecta de la base de datos
            $this->desconectarDB();
        }
    }



    private function consultarMenuHoy()
    {
        try {
            $mostrar = $this->conex->prepare("SELECT * FROM menu WHERE status = 1 AND feMenu = CURDATE()");
            $mostrar->execute();
            $data = $mostrar->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }



    private function descontarReservados($idMenu)
    {
        $this->idMenu = $idMenu;

        try {
            $mostrar = $this->conex->prepare("SELECT a.idAlimento, a.nombre, dsm.cantidad 
                                          FROM salidaalimentos sa 
                                          INNER JOIN detallesalidamenu dsm ON dsm.idSalidaA = sa.idSalidaA 
                                          INNER JOIN alimento a ON a.idAlimento = dsm.idAlimento 
                                          WHERE dsm.idMenu = ?");
            $mostrar->bindValue(1, $this->idMenu);
            $mostrar->execute();
            $data = $mostrar->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $alimento) {
                $this->actualizarStock($alimento['idAlimento'], $alimento['cantidad']);
            }

            $bitacora = new bitacoraModelo();
            $bitacora->registrarBitacora('Menú', 'Se descontaron los alimentos del Menú ' . $this->idMenu, $_SESSION['cedula']);
        } catch (\PDOException $e) {
            // Rollback manejado en la función principal
            throw $e;
        }
    }


    private function actualizarStock($idAlimento, $cantidad)
    {
        $this->alimento = $idAlimento;
        $this->cantidad = $cantidad;

        try {
            $info = $this->infoAlimento($this->alimento);
            $actualizarReservado = $info[0]['reservado'] - $this->cantidad;
            $registrar = $this->conex->prepare("UPDATE alimento SET reservado = ? WHERE idAlimento = ?");
            $registrar->bindValue(1, $actualizarReservado);
            $registrar->bindValue(2, $this->alimento);
            $registrar->execute();
        } catch (\PDOException $error) { // Cambiar a Exception
            return array("Sistema", "¡Error Sistema!");
        }
    }

    public function infoAlimento($alimento)
    {
        $this->alimento = $alimento;

        try {
            $mostrar = $this->conex->prepare("SELECT * FROM alimento WHERE status = 1 AND idAlimento = ?");
            $mostrar->bindValue(1, $this->alimento);
            $mostrar->execute();
            $data = $mostrar->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            return $e;
        }
    }
}
