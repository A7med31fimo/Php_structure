<?php
namespace App\Core;

use PDO, PDOException;
use App\Helpers\Helper;
class Database
{
    private $connection;

    public function __construct()
    {
        $config  = require __DIR__ . "/../../config/database.php";     
        try {
            $this->connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
                $config['user'],
                $config['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}