<?php
namespace App\Models;
use PDO;
class Auth
{

    private $conn;
    private $table;
    public function __construct($db)
    {
        $this->conn  = $db;
        $this->table = "users";
    }


    public function register($name, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO $this->table (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $hash]);
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
