<?php 
namespace Framework\Middleware;

use App\Models\RefreshTokenModel;
use Framework\JWTHandler;

class JwtMiddleware
{
    private $jwt;
    private $refresh_token;
    private $config;
    

    public function __construct(){
        $this->config = require basePath('config/jwt.php');
        $this->jwt = new JWTHandler();
        $this->refresh_token = new RefreshTokenModel();
    }
    public function handle()
    {
        try {
            if(isset($_COOKIE['access_token'])){
                if($this->jwt->verifyToken($_COOKIE['access_token'])){
                    return $this->jwt->getPayload($_COOKIE['access_token']);
                }
            }
            return $this->attemptRefresh();
        }
        catch (\Exception $e) {
            return $this->attemptRefresh();
        }
    }
    private function attemptRefresh() {
        $params = [
            'token' => $_COOKIE['refresh_token']
        ];
        

        if (!$this->jwt->verifyToken($_COOKIE['refresh_token'], true) || 
            !$this->refresh_token->isRefreshTokenValid($params)) {
            $this->clearTokens();
            return null;
        }
        
        // Generate new access token
        $payload = $this->jwt->getPayload($_COOKIE['refresh_token']);
        $user = [
            'id' => $payload['id'],
            'email' => $payload['email'],
        ];
        
        $access_token = $this->jwt->generateAccessToken($user);
        
        setcookie('access_token', $access_token, time() + $this->config['JWT_EXPIRE_TIME'], '/', '', true, true);
            
        return $this->jwt->getPayload($access_token);
    }
    private function clearTokens() {
        setcookie('access_token', '', time() - 3600, '/');
        setcookie('refresh_token', '', time() - 3600, '/');
    }
}