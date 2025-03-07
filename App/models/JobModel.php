<?php

namespace App\Models;

use Framework\Database;

class JobModel
{
    protected $db;
    public function __construct()
    {
        // Database connection goes here
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
    public function getJob(){
        $query = "SELECT  j.* FROM jobs j WHERE j.deleted = 0 LIMIT 12";
        return $this->db->query($query)->fetchAll();
    }
    public function getAllJobs($params)
    {
        $query = "SELECT * FROM jobs WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword)";
        return $this->db->query($query, $params)->fetchAll();
    }
    public function getjobsPagination($params)
    {

        $offset = $params['pagination']['offset'];
        $per_page = $params['pagination']['per_page'];
        unset($params['pagination']);

        $query = "SELECT j.* FROM jobs j WHERE j.deleted = 0 AND LOWER(j.name) LIKE LOWER(:keyword) LIMIT $offset, $per_page";
        return $this->db->query($query, $params)->fetchAll();
    }

    public function getJobByName($params){
        $query = "SELECT * FROM jobs WHERE deleted = 0 AND name = :name";
        return $this->db->query($query, $params)->fetch();
    }
    public function insert($field, $values, $params)
    {
        $query = "INSERT INTO jobs ({$field}) VALUES ({$values})";
        $this->db->query($query, $params);
        return $this->db->conn->lastInsertId();
    }
    public function getJobById($params)
    {
        $query = "SELECT j.* FROM jobs j WHERE j.id = :id group by j.id";
        return $this->db->query($query, $params)->fetch();
    }
    public function update($fields, $params)
    {
        $query = "UPDATE jobs SET {$fields} WHERE id = :id";
        return $this->db->query($query, $params);
    }
    public function deletejobById($fields, $params)
    {
        $query = "UPDATE jobs SET {$fields} WHERE id = :id";
        return $this->db->query($query, $params);
    }
}
