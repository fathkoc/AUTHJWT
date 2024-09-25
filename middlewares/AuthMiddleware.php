<?php
include_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;

class AuthMiddleware {
    private $secret_key = "YOUR_SECRET_KEY";

    public function generateJWT($user_id) {
        $issued_at = time();
        $expiration_time = $issued_at + (60 * 60); // 1 saat geçerli
        $payload = array(
            "user_id" => $user_id,
            "iat" => $issued_at,
            "exp" => $expiration_time
        );
        return JWT::encode($payload, $this->secret_key);
    }

    public function authenticateJWT($jwt) {
        try {
            $decoded = JWT::decode($jwt, $this->secret_key, array('HS256'));
            return $decoded;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(array("message" => "Access denied."));
            exit();
        }
    }
}
?>
