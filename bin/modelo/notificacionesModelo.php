<?php
namespace modelo;
use config\connect\connectDB as connectDB;
use helpers\JwtHelpers;
use PDO;

class notificacionesModelo extends connectDB {

    private $payload;
    private $idNotificacion;


    public function __construct() {
        parent::__construct();
        $token = $_COOKIE['jwt'];
        $this->payload = JwtHelpers::validarToken($token);
    }

    public function obtenerNotificaciones() {
    $this->conectarDBSeguridad();
    $consultar = $this->conex2->prepare("
        SELECT n.idNotificaciones, n.titulo, n.mensaje, n.fechaNoti 
        FROM notificaciones n 
        INNER JOIN notificaciones_usuarios nu 
        ON n.idNotificaciones = nu.idNotificaciones  
        WHERE nu.cedula = ? AND nu.leida = 0 
        ORDER BY n.fechaNoti DESC
    ");
    $consultar->bindValue(1, $this->payload->cedula);
    $consultar->execute();
    $resultado = $consultar->fetchAll(\PDO::FETCH_ASSOC);
    $this->desconectarDB();
    return $resultado; 
}


    public function marcarNotificacionLeida($notificacionId) {
        if(!preg_match("/^[0-9]{1,}$/", $notificacionId)){
            return ['error' => 'ID de notificación inválido.'];

        }
        $this->idNotificacion = $notificacionId;
         return  $this->marcarLeida();
    }

    
    private function marcarLeida() {
        $this->conectarDBSeguridad();
        $actualizar = $this->conex2->prepare("UPDATE notificaciones_usuarios SET leida = 1 WHERE idNotificaciones = ? AND cedula = ?");
        $actualizar->bindValue(1, $this->idNotificacion);
        $actualizar->bindValue(2, $this->payload->cedula);
        $actualizar->execute();
        $this->desconectarDB();
    }

    public function marcarTodasLeidas() {
        $this->conectarDBSeguridad();
        $actualizar = $this->conex2->prepare("UPDATE notificaciones_usuarios SET leida = 1 WHERE cedula = ?");
        $actualizar->bindValue(1, $this->payload->cedula);
        $actualizar->execute();
        $this->desconectarDB();

     }

     public function eliminarNotificacion($notificacionId) {
        if(!preg_match("/^[0-9]{1,}$/", $notificacionId)){
            return ['error' => 'ID de notificación inválido.'];

        }
        $this->idNotificacion = $notificacionId;
         return  $this->eliminar();
     }

     private function eliminar() {
        $this->conectarDBSeguridad();
        $eliminar = $this->conex2->prepare("DELETE FROM notificaciones_usuarios WHERE idNotificaciones = ? AND cedula = ?");
        $eliminar->bindValue(1, $this->idNotificacion);
        $eliminar->bindValue(2, $this->payload->cedula);
        $eliminar->execute();
        $this->desconectarDB();

       }

       //-------------------- NOTIFICACIONES ------


          /**
 *
 * @param string $titulo Título de la notificación.
 * @param string $mensaje Mensaje de la notificación.
 * @param string $tipomsj Tipo de mensaje (ej: 'informacion', 'Almuerzo').
 * @param string|null $fechaNoti Campo opcional para fechaNoti en la tabla notificaciones.
 */
private function _enviarNotificacionGeneral(string $titulo, string $mensaje, string $tipomsj, )
{
    try {
        $this->conectarDBSeguridad();

        $sql = "INSERT INTO `notificaciones` (`titulo`, `mensaje`, `tipo`) VALUES (?, ?, ?)";
        $query = $this->conex2->prepare($sql);
        $query->bindValue(1, $titulo);
        $query->bindValue(2, $mensaje);
        $query->bindValue(3, $tipomsj);
        $query->execute();
        $notificacionId = $this->conex2->lastInsertId();

        $query = $this->conex2->prepare("SELECT u.cedula FROM usuario u 
            INNER JOIN rol r ON u.idRol = r.idRol 
            INNER JOIN permiso p ON p.idRol = r.idRol 
            INNER JOIN modulo m ON m.idModulo = p.idModulo 
            WHERE m.nombreModulo = 'Menú' 
            AND p.nombrePermiso = 'consultar' 
            AND p.status = 1 
            AND u.status = 1;");
        $query->execute();
        $usuarios = $query->fetchAll(\PDO::FETCH_OBJ);

        $cedulasDestino = [];
        if (!empty($usuarios)) {
            $query = $this->conex2->prepare("INSERT INTO `notificaciones_usuarios` (`cedula`, `idNotificaciones`, `leida`) VALUES (?, ?, 0)");
            foreach ($usuarios as $usuario) {
                $query->bindValue(1, $usuario->cedula);
                $query->bindValue(2, $notificacionId);
                $query->execute();
                $cedulasDestino[] = $usuario->cedula;
            }
        }

        if (!empty($cedulasDestino)) {
            $this->enviarNotificacionWebSocket($cedulasDestino, [
                'type' => 'nueva_notificacion', 
                'idNotificaciones' => $notificacionId,
                'titulo' => $titulo,
                'mensaje' => $mensaje
            ]);
        }
        
    } catch (\Exception $e) {
        error_log("Error al procesar y enviar notificación del menú: " . $e->getMessage());
        throw $e; 
    }
}


public function notificaciones()
{
    try {
        $this->conectarDB();
        $this->conectarDBSeguridad();

        $mostrar = $this->conex->prepare("
            SELECT DISTINCT 
                m.feMenu, 
                m.idMenu, 
                m.horarioComida, 
                m.cantPlatos, 
                sa.descripcion 
            FROM menu m 
            INNER JOIN detallesalidamenu dsm ON m.idMenu = dsm.idMenu 
            INNER JOIN salidaalimentos sa ON dsm.idSalidaA = sa.idSalidaA 
            WHERE m.feMenu = CURDATE() 
              AND m.status = 1 
              AND m.idMenu NOT IN (SELECT idMenu FROM evento) 
              AND m.idMenu NOT IN (SELECT idMenu FROM asistencia)
        ");
        $mostrar->execute();
        $menu = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$menu) return;

        $horarioComida = $menu['horarioComida'];
        $cantPlatos = $menu['cantPlatos'];
        $feMenu = $menu['feMenu'];
        $descripcion = $menu['descripcion'] ?? 'Menú disponible';
        $titulo = "Menú Del Día - " . $horarioComida;

        // Comparar solo la parte de la fecha
        $sqlNoti = "SELECT * FROM notificaciones WHERE titulo = :titulo AND DATE(fechaNoti) = :fechaNoti LIMIT 1";
        $stmtNoti = $this->conex2->prepare($sqlNoti);
        $stmtNoti->bindParam(':titulo', $titulo);
        $stmtNoti->bindParam(':fechaNoti', $feMenu);
        $stmtNoti->execute();
        $notificacionExistente = $stmtNoti->fetch(PDO::FETCH_ASSOC);

        if ($notificacionExistente) return;

        $mensaje = "Menú disponible: " . $descripcion . " hecho para " . $cantPlatos . " Estudiantes. Su asistencia está disponible para el registro.";
        $tipomsj = $horarioComida;

        $this->_enviarNotificacionGeneral($titulo, $mensaje, $tipomsj);

    } catch (\Exception $e) {
        error_log("Error en notificaciones (Menú del Día): " . $e->getMessage());
    } finally {
        $this->desconectarDB(); 
    }
}

public function notificacionEventos()
{
    try {
        $this->conectarDB();
        $this->conectarDBSeguridad();

        $mostrar = $this->conex->prepare("
            SELECT DISTINCT 
                m.feMenu, 
                m.idMenu, 
                m.horarioComida, 
                m.cantPlatos, 
                e.nomEvent, 
                sa.descripcion 
            FROM evento e 
            INNER JOIN menu m ON e.idMenu = m.idMenu 
            INNER JOIN detallesalidamenu dsm ON m.idMenu = dsm.idMenu 
            INNER JOIN salidaalimentos sa ON dsm.idSalidaA = sa.idSalidaA 
            WHERE m.feMenu = CURDATE() 
              AND m.status = 1 
              AND m.idMenu IN (SELECT idMenu FROM evento)
        ");
        $mostrar->execute();
        $menu = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$menu) return;

        $horarioComida = $menu['horarioComida'];
        $cantPlatos = $menu['cantPlatos'];
        $feMenu = $menu['feMenu'];
        $evento = $menu['nomEvent'];
        $descripcion = $menu['descripcion'];
        $titulo = "Evento Del Día - " . $horarioComida;

        // Comparar solo la parte de la fecha
        $sqlNoti = "SELECT * FROM notificaciones WHERE titulo = :titulo AND DATE(fechaNoti) = :fechaNoti LIMIT 1";
        $stmtNoti = $this->conex2->prepare($sqlNoti);
        $stmtNoti->bindParam(':titulo', $titulo);
        $stmtNoti->bindParam(':fechaNoti', $feMenu);
        $stmtNoti->execute();
        $notificacionExistente = $stmtNoti->fetch(PDO::FETCH_ASSOC);

        if ($notificacionExistente) return;

        $mensaje = "Evento Disponible: " . $evento . " con un Menú: " . $descripcion . " hecho para " . $cantPlatos . " Comensales.";
        $tipomsj = $horarioComida;

        $this->_enviarNotificacionGeneral($titulo, $mensaje, $tipomsj);

    } catch (\Exception $e) {
        error_log("Error en notificaciones (Evento del Día): " . $e->getMessage());
    } finally {
        $this->desconectarDB(); 
    }
}


private function enviarNotificacionWebSocket(array $cedulasDestino, array $data) {
    $url = 'http://localhost:3000/send-notif'; 
    $payload = [
        'cedulas' => $cedulasDestino,
        'data' => $data
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($payload)))
    );

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        error_log('Error cURL al enviar a Node.js: ' . curl_error($ch));
    }
    curl_close($ch);
}
    
  


    }

?>