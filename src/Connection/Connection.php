<?php


namespace App\Connection;


use PDO;
use PDOException;

class Connection
{
    protected static $conn;

    /**
     * @return PDO|null
     */
    public static function connect()
    {
        $servername = "localhost";
        $username = "khaldoun";
        $password = "root";
        $dbname = "ovos";

        if (empty(self::$conn))
            try {
                self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$conn;

            } catch (PDOException $e) {

                echo "Connection failed: " . $e->getMessage();
            }

        return self::$conn;
    }

}