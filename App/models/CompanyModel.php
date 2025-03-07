<?php
    namespace App\Models;

    use Framework\Database;

    class CompanyModel {
        protected $db;
        public function __construct(){
            // Database connection goes here
            $config = require basePath('config/db.php');
            $this->db = new Database($config);
        }
        public function getAll(){
            $query = "SELECT * FROM companies WHERE deleted = 0";
            return $this->db->query($query)->fetchAll();
        }

        public function getAllHome(){
            $query = "SELECT * FROM companies WHERE deleted = 0 LIMIT 6";
            return $this->db->query($query)->fetchAll();
        }
        public function getLocationHome(){
            $query = "SELECT * FROM companies WHERE deleted = 0";
            return $this->db->query($query)->fetchAll();
        }
        public function getAllCompanies($params){   
            $query = "SELECT * FROM companies WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword)";
            return $this->db->query($query,$params)->fetchAll();
        }

        public function getCompaniesPagination($params){
            
            $offset = $params['pagination']['offset'];
            $per_page = $params['pagination']['per_page'];
            unset($params['pagination']);
            
            $query = "SELECT * FROM companies WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword) LIMIT $offset, $per_page";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function insert($field, $values, $params){
            $query = "INSERT INTO companies ({$field}) VALUES ({$values})";
            $this->db->query($query, $params);
            return $this->db->conn->lastInsertId();
        }
        public function getCompanyById($params){
            $query = "SELECT * FROM companies WHERE id = :id";
            return $this->db->query($query, $params)->fetch();
        }
        public function getCompanyByIdAndUserId($params){
            $query = "SELECT * FROM companies WHERE id = :id AND deleted = 0";
            return $this->db->query($query, $params)->fetchAll();
        }
        public function getJobByCompany($params){
            $query = "SELECT j.*, GROUP_CONCAT(s.name SEPARATOR ', ') as skills_name  FROM companies c 
                        JOIN post_jobs j on c.id = j.company_id
                        JOIN job_skills jk ON j.id = jk.job_id 
                        JOIN skills s ON s.id = jk.skill_id
                        WHERE c.id = :id AND j.deleted = 0
                        group by j.id";
            return $this->db->query($query, $params)->fetchAll();
        }
        public function update($fields, $params){
            $query = "UPDATE companies SET {$fields} WHERE id = :id";
            return $this->db->query($query, $params);
        }
        public function deleteCompanyById($fields, $params){
            $query = "UPDATE companies SET {$fields} WHERE id = :id";
            return $this->db->query($query, $params);
        }
    }