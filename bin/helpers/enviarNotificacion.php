<?php

namespace helpers;

use WebSocket\Client;

$id = $argv[1];
$titulo = $argv[2];
$mensaje = $argv[3];

try {
    $client = new Client('ws://localhost:8080');
    $client->send(json_encode([
        'type' => 'nueva_notificacion',
        'idNotificaciones' => $id,
        'titulo' => $titulo,
        'mensaje' => $mensaje
    ]));
} catch (Exception $e) {
    error_log("Error en enviarNotificacion.php - ID: $id - " . $e->getMessage());
}
?>