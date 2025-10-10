<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\Auth;
use function App\helpers\jsonResponse;

class AuthController
{

    private $db;
    private $data;
    private $authModel;
    public function __construct()
    {
        $this->db        = new Database();
        $this->data      = json_decode(file_get_contents("php://input"), true);
        $this->authModel = new Auth($this->db->getConnection());
    }

    // 🟢 Register new user
    public function register()
    {

        $data= json_decode(file_get_contents("php://input"), true);

        print_r ($data);

        $name = htmlspecialchars(strip_tags($this->data["name"] ?? ""));
        $email = htmlspecialchars(strip_tags($this->data["email"] ?? ""));
        $password = password_hash($this->data["password"] ?? "", PASSWORD_BCRYPT);

        if (!$name || !$email || !$password) {
            return jsonResponse(["error" => "Missing required fields"], 400);
        }


        if ($this->authModel->register($name, $email, $password)) {
           return jsonResponse(["message" => "User registered successfully ✅"]);
        } else {
           return jsonResponse(["error" => "Failed to register user"], 500);
        }
    }

    // 🟢 Login existing user
    public function login()
    {


        $email    = htmlspecialchars(strip_tags($this->data["email"] ?? ""));
        $password = $this->data["password"] ?? "";
        $user = $this->authModel->login($email, $password);
        if (!$user || !password_verify($password, $user["password"])) {
            return jsonResponse(["error" => "Invalid email or password"], 401);
        }

        // manual token . .. 
        $token = base64_encode(random_bytes(16));

        return jsonResponse([
            "message" => "Login successful ✅",
            "user" => [
                "id" => $user["id"],
                "name" => $user["name"],
                "email" => $user["email"],
                "token" => $token
            ]
        ]);
    }
}
