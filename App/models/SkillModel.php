<?php
    namespace App\Models;

    use Framework\Database;

    class SkillModel {
        protected $db;
        public function __construct(){
            $config = require basePath('config/db.php');
            $this->db = new Database($config);
        }
        public function getSkill(){
            $query = "SELECT s.name, count(js.skill_id) as count_skill
                        FROM skills s 
                        JOIN job_skills js on s.id = js.skill_id 
                        WHERE deleted = 0 
                        GROUP BY s.name
                        ORDER BY count_skill DESC
                        LIMIT 8;";
            return $this->db->query($query)->fetchAll();
        }
        public function getAll(){
            $query = "SELECT * FROM skills WHERE deleted = 0";
            return $this->db->query($query)->fetchAll();
        }
        public function getAllSkills($params){   
            $query = "SELECT * FROM skills WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword)";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function getSkillsPagination($params){
            
            $offset = $params['pagination']['offset'];
            $per_page = $params['pagination']['per_page'];
            unset($params['pagination']);
            
            $query = "SELECT * FROM skills WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword) LIMIT $offset, $per_page";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function insert($field, $values, $params){
            $query = "INSERT INTO skills ({$field}) VALUES ({$values})";
            $this->db->query($query, $params);
            return $this->db->conn->lastInsertId();
        }
        public function getSkillById($params){
            $query = "SELECT * FROM skills WHERE id = :id";
            return $this->db->query($query, $params)->fetch();
        }
        public function getSkillByName($params){
            $query = "SELECT * FROM skills WHERE deleted = 0 AND name = :name";
            return $this->db->query($query, $params)->fetch();
        }
        public function update($fields, $params){
            $query = "UPDATE skills SET {$fields} WHERE id = :id";
            return $this->db->query($query, $params);
        }
        public function deleteSkillById($fields, $params){
            $query = "UPDATE skills SET {$fields} WHERE id = :id";
            return $this->db->query($query, $params);
        }
    }
