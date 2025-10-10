<?php

namespace App\Controllers;

// require_once __DIR__ . "../middleware/AuthMiddleware.php";
use App\Core\Database;
// use App\Middleware\AuthMiddleware;
use App\Middleware\AuthMiddleware;
use App\Models\Auth;

// use APP\Middleware;

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
        $name = htmlspecialchars(strip_tags($this->data["name"] ?? ""));
        $email = htmlspecialchars(strip_tags($this->data["email"] ?? ""));
        $password = $this->data["password"];

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
        // var_dump($user["password"] );
        // var_dump($user); // شوف القيم كلها
        // var_dump($password);
        // var_dump($user["password"]);
        // var_dump(password_verify($password, $user["password"]));
        if (!$user || !password_verify($password, $user["password"])) {
            return jsonResponse(["error" => "Invalid email or password"], 401);
        }

        // manual token . .. 
        $token = AuthMiddleware::generateTokens($user);

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

    public function refreshToken()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $refreshToken = $data["refresh_token"] ?? null;
        var_dump( $data);
        if (!$refreshToken) {
            echo json_encode(["error" => "Missing refresh token"]);
            return;
        }

        $decoded = AuthMiddleware::verifyToken($refreshToken);

        if (!$decoded || $decoded->type !== "refresh") {
            http_response_code(401);
            echo json_encode(["error" => "Invalid or expired refresh token"]);
            return;
        }

        $user = [
            "id" => $decoded->id,
            "email" => $decoded->email
        ];

        $newTokens = AuthMiddleware::generateTokens($user);
        return jsonResponse($newTokens);
    }
}
