<?php
$connection = new AMQPConnection([
    'host' => 'localhost',
    'port' => 5672,
    'vhost' => '/',
    'login' => 'admin',
    'password' => 'password123',
    'heartbeat' => 60,
]);
$connection->connect();

if ($connection->isConnected()) {
    echo "Connected successfully\n";
} else {
    echo "Connection failed\n";
}
//var_dump(get_loaded_extensions());

