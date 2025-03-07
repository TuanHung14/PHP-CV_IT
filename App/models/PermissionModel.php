<?php
    namespace App\Models;

    use Framework\Database;

    class PermissionModel {
        protected $db;
        public function __construct(){
            // Database connection goes here
            $config = require basePath('config/db.php');
            $this->db = new Database($config);
        }
        public function getAll(){
            $query = "SELECT * FROM permissions WHERE deleted = 0";
            return $this->db->query($query)->fetchAll();
        }
        public function getAllPermissions($params){   
            $query = "SELECT * FROM permissions WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword)";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function getPermissionsPagination($params){
            
            $offset = $params['pagination']['offset'];
            $per_page = $params['pagination']['per_page'];
            unset($params['pagination']);
            
            $query = "SELECT * FROM permissions WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword) LIMIT $offset, $per_page";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function insert($field, $values, $params){
            $query = "INSERT INTO permissions ({$field}) VALUES ({$values})";
            $this->db->query($query, $params);
            return $this->db->conn->lastInsertId();
        }
        public function getPermissionById($params){
            $query = "SELECT * FROM permissions WHERE id = :id";
            return $this->db->query($query, $params)->fetch();
        }
        public function getPermissionByName($params){
            $query = "SELECT * FROM permissions WHERE name = :name";
            return $this->db->query($query, $params)->fetch();
        }
        public function update($fields, $params){
            $query = "UPDATE permissions SET {$fields} WHERE id = :id";
            return $this->db->query($query, $params);
        }
        public function deletePermissionById($fields, $params){
            $query = "UPDATE permissions SET {$fields} WHERE id = :id";
            return $this->db->query($query, $params);
        }
    }