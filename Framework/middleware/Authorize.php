<?php
    namespace Framework\Middleware;

use App\Controllers\ErrorController;
use Framework\Middleware\JwtMiddleware;
    use Framework\Auth;
use Framework\Session;

    class Authorize {
        private $jwt;
        public function __construct(){
            $this->jwt = new JwtMiddleware();
        }
        public function handle($role) {
            if (isset($_COOKIE['access_token'])) {
                $current_user = $this->jwt->handle();
                if ($current_user) {
                    if ($role === 'guest' && Auth::check()) {
                        redirect('/');
                    }
                    Auth::setUser($current_user);
                }
            }

            if (isset($_COOKIE['refresh_token'])) {
                $current_user = $this->jwt->handle();
                if ($current_user) {
                    if ($role === 'guest') {
                        redirect('/');
                    }
                    Auth::setUser($current_user);
                }
            }

            if ($role === 'auth' && !Auth::check()) {
                Session::setflashMessage('error_message', 'Vui lòng đăng nhập');
                redirect('/auth/login');
            }  

            if($role !== 'auth'&& $role !== 'guest' && $role !== 'global') {
                $user = Auth::user();
                if(!in_array($role, $user['permissions_name'])) {
                    ErrorController::unauthorized();    
                    exit();
                }
            }
        }
    }
