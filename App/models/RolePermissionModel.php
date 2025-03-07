<?php

namespace App\Models;

use Framework\Database;

class RolePermissionModel
{
    protected $db;
    public function __construct()
    {
        // Database connection goes here
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
    public function insert($field, $values, $params)
    {
        $query = "INSERT INTO role_permissions ({$field}) VALUES ({$values})";
        $this->db->query($query, $params);
        return $this->db->conn->lastInsertId();
    }
    public function update($fields, $params)
    {
        $query = "UPDATE role_permissions SET {$fields} WHERE role_id = :role_id";
        return $this->db->query($query, $params);
    }

    public function  deleteMany($params)
    {
        $query = "DELETE FROM role_permissions WHERE role_id = :role_id";
        return $this->db->query($query, $params);
    }
}
