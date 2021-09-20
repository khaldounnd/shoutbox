<?php

use Ratchet\ConnectionInterface;

require_once 'vendor/autoload.php';
$chat = new \App\Image();

if(isset($_FILES['image']['name'])){
    $data = $chat->upload($_FILES['image']);

    header('HTTP/1.1 201 Created');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    die();
}