<?php
namespace Framework;

use App\Models\UserModel;

class JWTHandler {
    private $secret_key;
    private $expire_time;
    private $refresh_key;
    private $refresh_expire_time;
    private $user;
    
    
    public function __construct() {
        $config = require basePath('config/jwt.php');
        $this->secret_key = $config['JWT_SECRET_KEY'];
        $this->expire_time = $config['JWT_EXPIRE_TIME'];
        $this->refresh_key = $config['JWT_REFRESH_SECRET_KEY'];
        $this->refresh_expire_time = $config['JWT_REFRESH_EXPIRE_TIME'];
        $this->user = new UserModel();
    }
    
    public function generateAccessToken($user_data) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'user_id' => $user_data['id'],
            'email' => $user_data['email'],
            'type' => 'access',
            'iat' => time(),
            'exp' => time() + $this->expire_time
        ]);
        
        return $this->createToken($header, $payload, $this->secret_key);
    }
    
    public function generateRefreshToken($user_data) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'user_id' => $user_data['id'],
            'email' => $user_data['email'],
            'type' => 'refresh',
            'iat' => time(),
            'exp' => time() + $this->refresh_expire_time
        ]);
        
        return $this->createToken($header, $payload, $this->refresh_key);
    }

    private function createToken($header, $payload, $key) {
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    
    public function verifyToken($token, $is_refresh = false) {
        $token_parts = explode('.', $token);
        
        if (count($token_parts) != 3) {
            return false;
        }
        
        $key = $is_refresh ? $this->refresh_key : $this->secret_key;
        
        $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $token_parts[0]));
        $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $token_parts[1]));
        $signature_provided = $token_parts[2];
        
        $payload_data = json_decode($payload, true);
        
        if ($is_refresh && (!isset($payload_data['type']) || $payload_data['type'] !== 'refresh')) {
            return false;
        }
        
        if (!$is_refresh && (!isset($payload_data['type']) || $payload_data['type'] !== 'access')) {
            return false;
        }
        
        if (isset($payload_data['exp']) && $payload_data['exp'] < time()) {
            return false;
        }
        
        $base64UrlHeader = $token_parts[0];
        $base64UrlPayload = $token_parts[1];
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return ($base64UrlSignature === $signature_provided);
    }
    
    public function getPayload($token) {
        $token_parts = explode('.', $token);
        $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $token_parts[1]));
        $payload = json_decode($payload, true);
        $params = [
            'id' => $payload['user_id'],
        ];
        $user = $this->user->getUserAllPermissions($params);
        $user['permissions_name'] = explode(',', $user['permissions_name']);
        return $user;
    }
}