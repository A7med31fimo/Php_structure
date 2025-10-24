<?php

namespace App\Controllers;

use App\Core\Database;
use App\Middleware\AuthMiddleware;
use App\Helpers\Helper;
use App\Core\Validator;
use App\Models\Token;
use App\Models\User;
use App\Core\Mail;

// use function App\Core\sendMail;

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
        // echo "done";

        $validator = new Validator($this->data, [
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], $pdo);
        if (!$validator->validate()) {
            http_response_code(401); //not authorized
            echo json_encode(['errors' => $validator->errors()], JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($this->userModel->create(compact("name", "email", "password"))) {
            $verification_code = rand(100000, 999999); // 6-digit random code
            $expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));

            $this->userModel->updateVerificationCode($email, $verification_code, $expires_at);

            // Send verification email
            $subject = "Verify your account";
            $message = "
            <h3>Hello $name!</h3>
            <p>Thanks for registering. Please use this code to verify your account:</p>
            <h2 style='color:#3366ff;'>$verification_code</h2>
            <p>This code will expire in 10 minutes.</p>";
            if (Mail::sendMail($email, $subject, $message)) {
                // Respond to frontend
                return Helper::jsonResponse([
                    "message" => "Registration successful! Please check your email for the verification code."
                ]);
            } else {
                return Helper::jsonResponse(["error" => "Failed to send mail"], 500);
            }

            // return Helper::jsonResponse(["status" => "success"]);
        } else {
            return Helper::jsonResponse(["error" => "Failed to register user"], 500);
        }
    }

    // Login existing user
    public function login()
    {

        header("Content-Type: application/json; charset=UTF-8");
        Helper::noCacheHeaders();
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
        $user = $this->userModel->read($email);

        //verify password
        if (!$user || !password_verify($password, $user["password"])) {
            return Helper::jsonResponse(["error" => "Invalid email or password"], 401);
        }

        // manual token . .. 
        $token = AuthMiddleware::generateTokens($user);
        if (isset($_SESSION)) {
            session_unset();
            session_destroy();
        }

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
            return Helper::jsonResponse([
                'status' => 'success',
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ]);
        } else {
            http_response_code(401);
            return Helper::jsonResponse([
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
        $exp_at = date('Y-m-d H:i:s', $decoded->exp) ?? null;

        // store on blacklist
        $tokenModel = (new Token($this->db->getConnection()))->create(compact("token", "exp_at"));
        session_unset();              //
        session_destroy();

        $newToken = bin2hex(random_bytes(32)); // 64-character random token
        setcookie("PHPSESSID", $newToken, time(), "/", "", false, true);

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
    public function verify()
    {
        $data = Helper::getInput();
        $email = $data['email'] ?? null;
        $code = $data['code'] ?? null;

        if (!$email || !$code) {
            return Helper::jsonResponse(["error" => "Email and code required"], 400);
        }

        $user = $this->userModel->read($email);

        if (!$user) {
            return Helper::jsonResponse(["error" => "User not found"], 404);
        }

        if ($user['verified']) {
            return Helper::jsonResponse(["message" => "Already verified"]);
        }

        if ($user['verification_code'] == $code && strtotime($user['code_expires_at']) > time()) {
            $this->userModel->markVerified($email);
            return Helper::jsonResponse(["message" => "Verification successful"]);
        }

        return Helper::jsonResponse(["error" => "Invalid or expired code"], 400);
    }
}
