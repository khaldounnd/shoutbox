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
     * Get Latest 10 Messages from database
     * @return array<string>
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
     * Method to save new message into database that calls function to delete old messages
     * @param string $msg
     * @param string $ip
     * @param string $agent
     * @param int $isImage
     */
    public function store(string $msg, string $ip, string $agent, int $isImage) : void
    {

        $stmt =  $this->db->prepare("INSERT INTO messages (message, ip, user_agent, is_image) 
                VALUES (?, ?, ?, ?)");

        $this->db->beginTransaction();

        try {
            $stmt->execute([trim($msg), $ip, $agent, $isImage]);
        } catch (\PDOException $exception) {
            header('HTTP/1.1 500 Internal Error');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode('Internal Error');
            die();
        }

        $this->destroyOldMessages();

        $this->db->commit();
    }

    /**
     * Method to delete any message not in the latest 10 along with its images if found
     */
    public function destroyOldMessages() : void
    {
        $query = $this->db->query( "SELECT id FROM messages ORDER BY id DESC LIMIT 10" );
        $newMessages = implode(', ', array_merge(...$query->fetchAll(PDO::FETCH_NUM)));

        $oldMessagesQuery = $this->db->query("SELECT message FROM messages WHERE is_image = 1 AND id NOT IN ($newMessages)");

        $stmt = $this->db->prepare("DELETE FROM messages WHERE id NOT IN ($newMessages)");

        try {
            $stmt->execute();
        } catch (\PDOException $exception) {
            header('HTTP/1.1 500 Internal Error');
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode('Internal Error');
            die();
        }

        $oldMessages = $oldMessagesQuery->fetchAll(PDO::FETCH_ASSOC);
        foreach ($oldMessages as $oldMessage) {
            $this->image->delete($oldMessage);
        }
    }

}