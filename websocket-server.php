#!/usr/bin/env php
<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\ChatWebSocket;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatWebSocket()
                )
    ),
8080
);

echo "WebSocket server running on port 8080\n";
$server->run();
