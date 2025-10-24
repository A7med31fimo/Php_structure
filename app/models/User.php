<?php

namespace App\Models;

use PDO;
use App\Interfaces\CrudInterface;
class User implements CrudInterface
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT id, name, email FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function read($email)  {
        // var_dump($email);
        $stmt = $this->conn->prepare("SELECT * FROM $this->table where email = ?;");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function readById($id)  {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table where id = ?;");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        // var_dump($data);
        $hash = password_hash($data["password"], PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO $this->table (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$data["name"], $data["email"], $hash]);
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function update($id,$data)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET name = ?, password = ? WHERE id = ?");
        return $stmt->execute([$data["name"], $data["password"], $id]);
    }
    public function updateVerificationCode($email, $code, $expires_at)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET verification_code=?, code_expires_at=? WHERE email=?");
        return $stmt->execute([$code, $expires_at, $email]);
    }
    public function markVerified($email)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET verified=1, verification_code=NULL, code_expires_at=NULL WHERE email=?");
        return $stmt->execute([$email]);
    }
    
}
