<?php


namespace App;


use App\Connection\Connection;
use PDO;

class Message
{

    protected ?PDO $db;
    protected Image $image;

    /**
     * Message constructor.
     */
    public function __construct()
    {
        $this->db = Connection::connect();
        $this->image = new Image();
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
     * @param $ip
     * @param $agent
     */
    public function store($msg, $ip, $agent, $isImage)
    {

        $stmt =  $this->db->prepare("INSERT INTO messages (message, ip, user_agent, is_image) 
                VALUES (?, ?, ?, ?)");
        $stmt->execute([trim($msg), $ip, $agent, $isImage]);

        $this->destroyOldMessages();
    }

    /**
     *
     */
    public function destroyOldMessages()
    {
        $query = $this->db->query( "SELECT id FROM messages ORDER BY id DESC LIMIT 10" );
        $newMessages = implode(', ', array_merge(...$query->fetchAll(PDO::FETCH_NUM)));

        $oldMessagesQuery = $this->db->query("SELECT message FROM messages WHERE is_image = 1 AND id NOT IN ($newMessages)");

        $stmt = $this->db->prepare("DELETE FROM messages WHERE id NOT IN ($newMessages)");
        $stmt->execute();

        $oldMessages = $oldMessagesQuery->fetchAll(PDO::FETCH_ASSOC);
        foreach ($oldMessages as $oldMessage) {
            $this->image->deleteImage($oldMessage);
        }
    }

}