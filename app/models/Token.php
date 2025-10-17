<?php

namespace App\Models;

use App\Interfaces\CrudInterface;
use PDO;

class Token implements CrudInterface
{
    private $conn;
    private $table = "token_blacklist";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function create($data)
    {
        var_dump($data);
        $stmt = $this->conn->prepare("INSERT INTO $this->table (token, expires_at) VALUES (?, ?)");
        return  $stmt->execute([$data["token"], $data["exp_at"]]);
    }
    public function read($token)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $data) {}
    public function delete($id) {}
}
