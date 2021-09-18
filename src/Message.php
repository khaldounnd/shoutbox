<?php


namespace App;


use App\Connection\Connection;
use PDO;

class Message
{

    protected ?PDO $db;

    /**
     * Message constructor.
     */
    public function __construct()
    {
        $this->db = Connection::connect();
    }

    /**
     * @return array
     */
    public function getLastTen(): array
    {
        $query = 'SELECT * FROM (
              SELECT * FROM messages ORDER BY id DESC LIMIT 10 
        ) AS `table` ORDER BY id';


        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $msg
     */
    public function store($msg)
    {

        $stmt =  $this->db->prepare("INSERT INTO messages (message, ip, user_agent) 
                VALUES (?, ?, ?)");
        $stmt->execute([trim($msg), 123, 'anvd']);

        $this->destroyOldMessages();
    }

    /**
     *
     */
    public function destroyOldMessages()
    {
        $query = $this->db->query( "SELECT id FROM messages ORDER BY id DESC LIMIT 10" );
        $newMessages = implode(', ', array_merge(...$query->fetchAll(PDO::FETCH_NUM)));

        $stmt = $this->db->prepare("DELETE FROM messages WHERE id NOT IN ($newMessages)");
        $stmt->execute();
    }
}