<?php

namespace App\Controllers\client;

use App\Models\RefreshTokenModel;
use Framework\Validation;
use Framework\Session;
use App\Models\UserModel;
use Framework\JWTHandler;
class UserController
{
    protected $config;
    private $user;
    private $jwt;
    private $refresh_token;
    public function __construct()
    {
        $this->config = require basePath('config/jwt.php');
        $this->user = new UserModel();
        $this->refresh_token = new RefreshTokenModel();
        $this->jwt = new JWTHandler();
    }
    /**
     * Show the login page
     * 
     * @return void

     */
    public function login()
    {
        loadView('client', 'users/login');
    }

    /**
     * Show the register page
     * 
     * @return void
     */
    public function create()
    {
        loadView('client', 'users/create');
    }

    public function checkAndSetJwt($user){
        $access_token = $this->jwt->generateAccessToken($user);
        $refresh_token = $this->jwt->generateRefreshToken($user);
        $params = [
            'user_id' => $user['id'],
            'token' => $refresh_token
        ];

        $fields = [];
        $values = [];
        foreach ($params as $field => $value) {
            $fields[] = $field;
            if ($value === '') {
                $params[$field] = null;
            }
            $values[] = ":$field";
        }
        $fields = implode(', ', $fields);
        $values = implode(', ', $values);

        $refresh_token_id = $this->refresh_token->insert($fields, $values, $params);

        setcookie('access_token', $access_token, time() + $this->config['JWT_EXPIRE_TIME'], '/', '', true, true);
        setcookie('refresh_token', $refresh_token, time() + $this->config['JWT_REFRESH_EXPIRE_TIME'], '/', '', true, true);
    }

    /**
     * Store user in database
     * 
     * @return void
     */
    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];
        $errors = [];

        //vallidation
        if (!Validation::email($email)) {
            $errors['email'] = 'Email đã tồn tại';
        }
        if (!Validation::string($name, 6, 50)) {
            $errors['name'] = 'Name phải ít nhất 6 ký tự';
        }
        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password phải ít nhất 6 ký tự';
        }
        if (!Validation::match($password, $passwordConfirmation)) {
            $errors['passwordConfirmation'] = 'Passwords không trùng hợp';
        }

        if (!empty($errors)) {
            loadView('client', 'users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                ]
            ]);
            exit;
        }
        // Chek email có trong dữ liệu hay không
        $params = [
            'email' => $email,
        ];
        $user = $this->user->getEmailUser($params);
        if ($user) {
            $errors['email'] = 'Email đã tồn tại';
            loadView('client', 'users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email
                ]
            ]);
            exit;
        }
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $params = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ];
        $fields = [];
        $values = [];
        foreach ($params as $field => $value) {
            $fields[] = $field;
            if ($value === '') {
                $params[$field] = null;
            }
            $values[] = ":$field";
        }
        $fields = implode(', ', $fields);
        $values = implode(', ', $values);

        $userId = $this->user->insert($fields, $values, $params);

        $user = [
            'id' => $userId,
            'name' => $name,
            'email' => $email
        ];
        $this->checkAndSetJwt($user);
        redirect('/');
    }
    /**
     * Logout a user and kill session
     * 
     * @return void
     */
    public function logout()
    {
        if (isset($_COOKIE['refresh_token'])) {
            $params = [
                'token' => $_COOKIE['refresh_token'],
            ];
            $this->refresh_token->invalidateRefreshToken($params);
        }
        
        setcookie('access_token', '', time() - 3600, '/');
        setcookie('refresh_token', '', time() - 3600, '/');
        redirect('/');
    }
    /**
     * Authenticate a user with email and password
     * @return void
     */
    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = [];
        if (!Validation::email($email)) {
            $errors['email'] = 'Vui lòng nhập đúng email';
        }
        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password phải ít nhất 6 ký tự';
        }
        if (!empty($errors)) {
            loadView('client', 'users/login', ['errors' => $errors]);
            exit;
        }
        $params = [
            'email' => $email,
        ];
        $user = $this->user->getEmailUser($params);
        if (!$user) {
            $errors['email'] = 'Email không đúng';
            loadView('client', 'users/login', ['errors' => $errors]);
            exit;
        }
        if (!password_verify($password, $user['password'])) {
            $errors['password'] = 'Password không đúng';
            loadView('client', 'users/login', ['errors' => $errors]);
            exit;
        }
        $params = [
            'id' => $user['id'],
        ];
        $user = $this->user->getUserAllPermissions($params);
        $user['permissions_name'] = explode(',', $user['permissions_name']);
        $this->checkAndSetJwt($user);
        

        redirect('/');
    }
}
