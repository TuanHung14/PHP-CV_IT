<?php

namespace App\Models;

use Framework\Database;

class RoleModel
{
    protected $db;
    public function __construct()
    {
        // Database connection goes here
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
    public function getAll()
    {
        $query = "SELECT * FROM roles WHERE deleted = 0";
        return $this->db->query($query)->fetchAll();
    }
    public function getAllRoles($params)
    {
        $query = "SELECT * FROM roles WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword)";
        return $this->db->query($query, $params)->fetchAll();
    }
    public function getRolesPagination($params)
    {

        $offset = $params['pagination']['offset'];
        $per_page = $params['pagination']['per_page'];
        unset($params['pagination']);

        $query = "SELECT * FROM roles WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword) LIMIT $offset, $per_page";
        return $this->db->query($query, $params)->fetchAll();
    }
    public function insert($field, $values, $params)
    {
        $query = "INSERT INTO roles ({$field}) VALUES ({$values})";
        $this->db->query($query, $params);
        return $this->db->conn->lastInsertId();
    }
    public function getRoleById($params)
    {
        $query = "SELECT r.*, GROUP_CONCAT(rp.permission_id SEPARATOR ', ') as permission FROM roles r JOIN role_permissions rp on r.id = rp.role_id WHERE r.id = :id  group by r.id; ";
        return $this->db->query($query, $params)->fetch();
    }
    public function getRoleByName($params)
    {
        $query = "SELECT * FROM roles WHERE name = :name";
        return $this->db->query($query, $params)->fetch();
    }
    public function getRoleByNameAndId($params)
    {
        $query = "SELECT * FROM roles WHERE name = :name AND id != :id";
        return $this->db->query($query, $params)->fetch();
    }
    public function update($fields, $params)
    {
        $query = "UPDATE roles SET {$fields} WHERE id = :id";
        return $this->db->query($query, $params);
    }
    public function deleteRoleById($fields, $params)
    {
        $query = "UPDATE roles SET {$fields} WHERE id = :id";
        return $this->db->query($query, $params);
    }
}
