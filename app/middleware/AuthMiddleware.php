<?php
namespace App\Middleware;

use App\Core\Database;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Token;

class AuthMiddleware
{
    private static $secret = "ALL_IS_WELL";

    public static function generateTokens($user)
    {
        $accessPayload = [
            "id" => $user["id"],
            "email" => $user["email"],
            "type" => "access",
            "iat" => time(),
            "exp" => time() + (60 * 15) // Access token: 15 دقيقة
        ];

        $refreshPayload = [
            "id" => $user["id"],
            "email" => $user["email"],
            "type" => "refresh",
            "iat" => time(),
            "exp" => time() + (60 * 60 * 24 * 7) // Refresh token: 7 أيام
        ];

        $accessToken = JWT::encode($accessPayload, self::$secret, "HS256");
        $refreshToken = JWT::encode($refreshPayload, self::$secret, "HS256");

        return [
            "access_token" => $accessToken,
            "refresh_token" => $refreshToken
        ];
    }

    public static function verifyToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$secret, "HS256"));
        } catch (Exception $e) {
            return null;
        }
    }

    public static function protect()
    {
        $headers = getallheaders();
        if (!isset($headers["Authorization"])) {
            http_response_code(401);
            echo json_encode(["error" => "Missing token"]);
            exit;
        }

        $token = trim(str_replace("Bearer", "", $headers["Authorization"]));
        $tokenModel = (new Token((new Database())->getConnection()))->read($token);
        if ($tokenModel > 0) {
            http_response_code(401);
            echo json_encode(["error" => "Token has been expired"]);
            exit;
        }
        $decoded = self::verifyToken($token);

        if (!$decoded || $decoded->type !== "access") {
            http_response_code(401);
            echo json_encode(["error" => "Invalid or expired token"]);
            exit;
        }

        return $decoded;
    }
}
