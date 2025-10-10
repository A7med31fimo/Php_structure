<?php
namespace App\Core;

use PDO, PDOException;

class Database
{
    private $connection;

    public function __construct()
    {
        $config = [
            "host" => "localhost",
            "dbname" => "cv_builder",
            "user" => "root",
            "password" => ""
        ];
        
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