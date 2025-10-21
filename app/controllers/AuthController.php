<?php

namespace App\Controllers;

use App\Core\Database;
use App\Middleware\AuthMiddleware;
use App\Helpers\Helper;
use App\Core\Validator;
use App\Models\Token;
use App\Models\User;

class AuthController
{

    private $db;
    private $data;
    private $userModel;

    public function __construct()
    {
        
        $this->db             = new Database();
        $this->data           = Helper::getInput();
        $this->userModel      = new User($this->db->getConnection());
    }

    // Register new user
    public function register()
    {
        
        $name = htmlspecialchars(strip_tags($this->data["name"] ?? ""));
        $email = htmlspecialchars(strip_tags($this->data["email"] ?? ""));
        $password = $this->data["password"];

        $pdo = $this->db->getConnection();
        echo "done";

        $validator = new Validator($this->data, [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], $pdo);
        if (!$validator->validate()) {
            http_response_code(401);//not authorized
            echo json_encode(['errors' => $validator->errors()], JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($this->userModel->create(compact("name", "email", "password"))) {
           return Helper::jsonResponse(["message" => "User registered successfully ✅"]);
        } else {
           return Helper::jsonResponse(["error" => "Failed to register user"], 500);
        }
    }

    // Login existing user
    public function login()
    {

        //get data
        $email    = htmlspecialchars(strip_tags($this->data["email"] ?? ""));
        $password = $this->data["password"] ?? "";
        
        //validate data
        $validator = new Validator($this->data, [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ], $this->db->getConnection());
        //check validation??
        if (!$validator->validate()) {
            http_response_code(401); //not authorized
            echo json_encode(['errors' => $validator->errors()], JSON_UNESCAPED_UNICODE);
            return;
        }
        //check user in db
        $user = $this->userModel->read( $email);
        
        //verify password
        if (!$user || !password_verify($password, $user["password"])) {
            return Helper::jsonResponse(["error" => "Invalid email or password"], 401);
        }

        // manual token . .. 
        $token = AuthMiddleware::generateTokens($user);
        session_start();
        if ($user) {
            // ✅ حفظ بيانات المستخدم في السيشن
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'token' => $token
            ];
            session_write_close();
            // var_dump($_SESSION['user']);
            return json_encode([
                'status' => 'success',
                'message' => 'Login successful'
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'error' => 'Invalid email or password'
            ]);
        }
    }

    public function logout()
    {
        $headers = getallheaders();
        if (!isset($headers["Authorization"])) {
            http_response_code(401);
            echo json_encode(["error" => "Missing token"]);
            exit;
        }

        $token = trim(str_replace("Bearer", "", $headers["Authorization"]));
        // delete Bearer word "bearer token..."
        //decode token 
        // var_dump($token);

        $decoded = AuthMiddleware::verifyToken($token);
        // var_dump($decoded);
        if (!$decoded) {
            return Helper::jsonResponse(["error" => "Invalid or expired token"], 401);
        }
        $exp_at = date('Y-m-d H:i:s', $decoded->exp)??null;

        // store on blacklist
        $tokenModel = (new Token($this->db->getConnection()))->create(compact("token", "exp_at"));

        return Helper::jsonResponse(["message" => "Logged out successfully "]);
    }

    public function refreshToken()
    {

        // var_dump($this->data);
        $refreshToken = $this->data["refresh_token"] ?? null;

        if (!$refreshToken) {
            echo Helper::jsonResponse(["error" => "Missing refresh token"]);
            return;
        }

        $decoded = AuthMiddleware::verifyToken($refreshToken);

        if (!$decoded || $decoded->type !== "refresh") {
            http_response_code(401);
            echo Helper::jsonResponse(["error" => "Invalid or expired refresh token"]);
            return;
        }

        $user = [
            "id" => $decoded->id,
            "email" => $decoded->email
        ];

        $newTokens = AuthMiddleware::generateTokens($user);
        return Helper::jsonResponse($newTokens);
    }
}
