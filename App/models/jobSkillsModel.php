<?php
    namespace App\Models;

    use Framework\Database;

    class JobSkillsModel {
        protected $db;
        public function __construct(){
            // Database connection goes here
            $config = require basePath('config/db.php');
            $this->db = new Database($config);
        }
        public function insert($field, $values, $params){
            $query = "INSERT INTO job_skills ({$field}) VALUES ({$values})";
            $this->db->query($query, $params);
            return $this->db->conn->lastInsertId();
        }

        public function  deleteMany($params)
        {
            $query = "DELETE FROM job_skills WHERE job_id = :job_id";
            return $this->db->query($query, $params);
        }
    }