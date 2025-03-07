<?php 
    namespace App\Models;

    use Framework\Database;
    
    class RefreshTokenModel
    {
        protected $db;
        public function __construct()
        {
            // Database connection goes here
            $config = require basePath('config/db.php');
            $this->db = new Database($config);
        }

        public function insert($fields, $values, $params) {
            $query = "INSERT INTO refresh_tokens ({$fields}) VALUES ({$values})";
            $this->db->query($query, $params);
            return $this->db->conn->lastInsertId();
        }
        
        public function invalidateRefreshToken($params) {
            $sql = "DELETE FROM refresh_tokens WHERE token = :token";
            return $this->db->query($sql, $params);
        }
        
        public function isRefreshTokenValid($params) {
            $sql = "SELECT * FROM refresh_tokens WHERE token = :token";
            return $this->db->query($sql, $params)->fetch();
        }
    }