<?php

namespace App\Models;

use PDO;
use App\Interfaces\CrudInterface;

class Cv implements CrudInterface
{
    private $conn;
    private $table = "cvs";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function read($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table c JOIN users u ON (c.user_id = u.id) WHERE u.id = ?");
        $stmt->execute([$id]);
        return $stmt->FETCH(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->table 
        (
        user_id,
        full_name,
        job_title,
        email,
        phone, 
        location,
        linkedin, 
        github, 
        summary,
        skills, 
        experience, 
        education,
        projects)   
        VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        return $stmt->execute([
            $data["user_id"],
            $data["full_name"],
            $data["job_title"],
            $data["email"],
            $data["phone"],
            $data["linkedin"],
            $data["github"],
            $data["summary"],
            $data["skills"],
            $data["experience"],
            $data["education"],
            $data["projects"]
        ]);
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table where id = ?;");
        return $stmt->execute([$id]);
    }
    public function update($id, $data)
    {
        $stmt = $this->conn->prepare(
            "UPDATE $this->table set
        (full_name,
        job_title,
        email,
        phone, 
        location,
        linkedin, 
        github, 
        summary,
        skills, 
        experience, 
        education,
        projects)   
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) WHERE user_id = ?; "
        );
        return $stmt->execute([
            $data["full_name"],
            $data["job_title"],
            $data["email"],
            $data["phone"],
            $data["linkedin"],
            $data["github"],
            $data["summary"],
            $data["skills"],
            $data["experience"],
            $data["education"],
            $data["projects"],
            $id
        ]);
    }
}
