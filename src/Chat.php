<?php


namespace App;

use App\Connection\Connection;
use Exception;
use PDO;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class Chat implements MessageComponentInterface {

    protected SplObjectStorage $clients;
    protected PDO|null $db;
    protected Message $messageModel;

    public function __construct()
    {
        $this->clients = new SplObjectStorage();
        $this->db = Connection::connect();
        $this->messageModel = new Message();
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws Exception
     */
    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        $messages = $this->messageModel->getLastTen();

        foreach ($messages as $message) {
            $conn->send($message['message']. "\n");
        }

        echo "New connection! ($conn->resourceId)\n";
    }

    /**
     * Triggered when a client sends data through the socket
     * @param ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string             $msg  The message received
     * @throws Exception
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);
        $this->messageModel->store($data->message,  $from->remoteAddress, $data->agent);
        foreach ($this->clients as $client) {
            if($from != $client) {
                $client->send($data->message);
            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}