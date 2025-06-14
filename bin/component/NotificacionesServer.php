<?php

namespace component;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use config\connect\connectDB;

class NotificacionesServer extends connectDB implements MessageComponentInterface
{
    protected $clients;
    protected $connections;
    private $cedula;  // Ahora se setea desde afuera
    private $id;
    private $data;

    public function __construct() {
        parent::__construct(); // Llama al constructor de connectDB
        $this->clients = new \SplObjectStorage;
        $this->connections = []; // Inicializa el array para almacenar las cédulas
    }

    public function setCedula(string $cedula) {
        $this->cedula = $cedula;
    }

    public function consultarNotificaciones(){
        $this->conectarDBSeguridad();

        if (empty($this->cedula)) {
            echo json_encode(['error' => 'Cédula no definida']);
            die();
        }

        try {
            // Primera consulta: Notificaciones no leídas
            $query = $this->conex2->prepare("SELECT * FROM notificaciones n INNER JOIN notificaciones_usuarios nu ON n.idNotificaciones = nu.idNotificaciones WHERE nu.leida = 0 AND nu.cedula = ? AND tipo = 'informacion'");
            $query->bindValue(1, $this->cedula);
            $query->execute();
            $notificacionesGenerales = $query->fetchAll(\PDO::FETCH_OBJ);

            date_default_timezone_set('America/Caracas'); // Zona horaria Venezuela
            $horaExacta = date("H:i:s");

            $queryTipo = $this->conex2->prepare("SELECT * FROM notificaciones n
                INNER JOIN notificaciones_usuarios nu
                ON n.idNotificaciones = nu.idNotificaciones
                WHERE nu.leida = 0
                AND nu.cedula = ?
                AND DATE(n.fechaNoti) = CURDATE()
                AND n.tipo IN ('Desayuno', 'Almuerzo', 'Merienda', 'Cena')
                ORDER BY 
                    CASE
                        WHEN n.tipo = 'Desayuno' THEN 1
                        WHEN n.tipo = 'Almuerzo' THEN 2
                        WHEN n.tipo = 'Merienda' THEN 3
                        WHEN n.tipo = 'Cena' THEN 4
                    END
                LIMIT 1
            ");
            $queryTipo->bindValue(1, $this->cedula);
            $queryTipo->execute();
            $notificacionesFiltradas = $queryTipo->fetchAll(\PDO::FETCH_OBJ);

            if (!empty($notificacionesFiltradas)) {
                foreach ($notificacionesFiltradas as $notificacion) {
                    $tipoNotificacion = $notificacion->tipo;

                    if ($tipoNotificacion == 'Desayuno' && ($horaExacta >= '06:00:00' && $horaExacta <= '09:00:00')) {
                        $data = [
                            'generales' => $notificacionesGenerales,
                            'filtradas' => $notificacionesFiltradas
                        ];
                        echo json_encode($data);
                        die();
                    } elseif ($tipoNotificacion == 'Almuerzo' && ($horaExacta >= '10:00:00' && $horaExacta <= '13:00:00')) {
                        $data = [
                            'generales' => $notificacionesGenerales,
                            'filtradas' => $notificacionesFiltradas
                        ];
                        echo json_encode($data);
                        die();
                    } elseif ($tipoNotificacion == 'Merienda' && ($horaExacta >= '14:00:00' && $horaExacta <= '16:00:00')) {
                        $data = [
                            'generales' => $notificacionesGenerales,
                            'filtradas' => $notificacionesFiltradas
                        ];
                        echo json_encode($data);
                        die();
                    } elseif ($tipoNotificacion == 'Cena' && ($horaExacta >= '17:00:00' && $horaExacta <= '19:00:00')) {
                        $data = [
                            'generales' => $notificacionesGenerales,
                            'filtradas' => $notificacionesFiltradas
                        ];
                        echo json_encode($data);
                        die();
                    } else {
                        $data = [
                            'generales' => $notificacionesGenerales,
                        ];
                        echo json_encode($data);
                        die();
                    }
                }
            } else {
                $data = [
                    'generales' => $notificacionesGenerales
                ];
                echo json_encode($data);
                die();
            }

        } catch (\PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
        finally {
            $this->desconectarDB();
        }
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nueva conexión: ({$conn->resourceId})";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if ($data['type'] === 'nueva_notificacion') {
            foreach ($this->clients as $client) {
                $client->send(json_encode([
                    'type' => 'nueva_notificacion',
                    'idNotificaciones' => $data['idNotificaciones'],
                    'titulo' => $data['titulo'],
                    'mensaje' => $data['mensaje']
                ]));
            }
        }
    }

    public function marcarNotificacionLeida($notificacionId){
        $this->id = $notificacionId;

        return $this->leida();
    }

    private function leida() {
        $this->conectarDBSeguridad();

        if (empty($this->cedula)) {
            echo json_encode(['error' => 'Cédula no definida']);
            die();
        }

        try {
            $stmt = $this->conex2->prepare("UPDATE notificaciones_usuarios SET leida = 1 WHERE idNotificaciones = ? AND cedula = ?");
            $stmt->bindValue(1 ,$this->id);
            $stmt->bindValue(2, $this->cedula);
            $stmt->execute();
            return ['success' => true];
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        } finally {
            $this->desconectarDB();
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Conexión cerrada: ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}
