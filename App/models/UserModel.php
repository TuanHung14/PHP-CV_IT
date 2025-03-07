<?php

namespace App\Models;

use Framework\Database;

class UserModel
{
    protected $db;
    public function __construct()
    {
        // Database connection goes here
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
    public function getEmailUser($params)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->db->query($query, $params)->fetch();
    }
    public function getUserAllPermissions($params){
        $query = "SELECT  u.id, u.email, u.name, u.role_id, u.company_id,r.name as role_name ,group_concat(p.name) as permissions_name FROM users u
        LEFT JOIN roles r on  u.role_id = r.id
        LEFT JOIN role_permissions rp on r.id = rp.role_id
        LEFT JOIN permissions p on p.id = rp.permission_id 
        WHERE u.id = :id
        group by u.id, r.name";
        return $this->db->query($query, $params)->fetch();
    }
    public function insert($field, $values, $params)
    {
        $query = "INSERT INTO users ({$field}) VALUES ({$values})";
        $this->db->query($query, $params);
        return $this->db->conn->lastInsertId();
    }

    public function getAllUser($params)
    {
        $query = "SELECT * FROM users WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword)";
        return $this->db->query($query, $params)->fetchAll();
    }

    public function getUserPagination($params)
    {

        $offset = $params['pagination']['offset'];
        $per_page = $params['pagination']['per_page'];
        unset($params['pagination']);

        $query = "SELECT u.* ,r.name as role_name FROM users u JOIN roles r on u.role_id = r.id WHERE u.deleted = 0 AND LOWER(u.name) LIKE LOWER(:keyword) LIMIT $offset, $per_page";
        return $this->db->query($query, $params)->fetchAll();
    }

    public function getUserById($params){
        $query = "SELECT u.*, r.name as role_name FROM users u JOIN roles r on u.role_id = r.id WHERE u.deleted = 0 AND u.id = :id";
        return $this->db->query($query, $params)->fetch();
    }

    public function update($params,$fields){
        $query = "UPDATE users SET {$fields} WHERE id = :id";
        return $this->db->query($query, $params);
    }
}
