<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use component\NotificacionesServer;

require __DIR__ . '/vendor/autoload.php';



$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new NotificacionesServer()
        )
    ),
    8080
);

echo "Servidor WebSocket corriendo en puerto 8080...\n";
$server->run();
?>