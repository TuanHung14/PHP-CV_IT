<?php
    namespace App\Models;

    use Framework\Database;

    class ResumeModel {
        protected $db;
        public function __construct(){
            // Database connection goes here
            $config = require basePath('config/db.php');
            $this->db = new Database($config);
        }
        public function getAllByCompany($params){
            $query = "SELECT c.name as company_name, pj.name as post_job_name, r.id ,r.createdAt, r.status, r.url, u.name as user_name, u.email FROM resumes r
                        inner join users u on u.id = r.user_id
                        inner join post_jobs pj on pj.id = r.job_id
                        inner join companies c on c.id = pj.company_id
                        WHERE r.deleted = 0 AND LOWER(pj.name) LIKE LOWER(:keyword) AND c.id  = :id";
            return $this->db->query($query, $params)->fetchAll();
        }
        public function getAll($params){   
            $query = "SELECT * FROM resumes r inner join post_jobs pj on pj.id = r.job_id WHERE r.deleted  = 0 AND LOWER(pj.name) LIKE LOWER(:keyword)";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function getResumeById($params){
            $query = "SELECT * FROM resumes WHERE id = :id AND deleted = 0";
            return $this->db->query($query, $params)->fetch();
        }
        public function getAllByCompanyPagination($params){
            
            $offset = $params['pagination']['offset'];
            $per_page = $params['pagination']['per_page'];
            unset($params['pagination']);
            
            $query = "SELECT c.name as company_name, pj.name as post_job_name, r.id ,r.createdAt, r.status, r.url, u.name as user_name, u.email FROM resumes r
                        inner join users u on u.id = r.user_id
                        inner join post_jobs pj on pj.id = r.job_id
                        inner join companies c on c.id = pj.company_id
                        WHERE c.id  = :id AND r.deleted  = 0 AND LOWER(pj.name) LIKE LOWER(:keyword)
                        ORDER BY r.createdAt DESC 
                        LIMIT $offset, $per_page";
            return $this->db->query($query,$params)->fetchAll();
        }

        public function getAllPagination($params){
            
            $offset = $params['pagination']['offset'];
            $per_page = $params['pagination']['per_page'];
            unset($params['pagination']);
            
            $query = "SELECT c.name as company_name, pj.name as post_job_name, r.id ,r.createdAt, r.status, r.url, u.name as user_name, u.email FROM resumes r
                        inner join users u on u.id = r.user_id
                        inner join post_jobs pj on pj.id = r.job_id
                        inner join companies c on c.id = pj.company_id
                        WHERE r.deleted  = 0 AND LOWER(pj.name) LIKE LOWER(:keyword)
                        ORDER BY r.createdAt DESC 
                        LIMIT $offset, $per_page";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function getResumeByUserIdAndJobId($params){
            $query = "SELECT * FROM resumes WHERE user_id = :user_id AND job_id = :job_id";
            return $this->db->query($query, $params)->fetch();
        }
        public function store($fields, $values, $params){
            $query = "INSERT INTO resumes ({$fields}) VALUES ({$values})";
            $this->db->query($query, $params);
            return $this->db->conn->lastInsertId();
        }

        public function getResumeByUserId($params){
            $query = "SELECT c.name as company_name, pj.name as post_job_name, r.createdAt, r.status, r.url FROM resumes r
                        inner join post_jobs pj on pj.id = r.job_id
                        inner join companies c on c.id = pj.company_id
                        WHERE user_id = :user_id";
            return $this->db->query($query, $params)->fetchAll();
        }
        public function getResumePagination($params){
            
            $offset = $params['pagination']['offset'];
            $per_page = $params['pagination']['per_page'];
            unset($params['pagination']);
            
            $query = "SELECT c.name as company_name, pj.name as post_job_name, r.createdAt, r.status, r.url FROM resumes r
                        inner join post_jobs pj on pj.id = r.job_id
                        inner join companies c on c.id = pj.company_id
                        WHERE user_id = :user_id
                        ORDER BY r.createdAt DESC
                        LIMIT $offset, $per_page";
            return $this->db->query($query,$params)->fetchAll();
        }
        public function update($fields, $params){
            $query = "UPDATE resumes SET {$fields} WHERE id = :id";
            $this->db->query($query, $params);
        }

        public function getAllByDay(){
            $query = "SELECT COUNT(*) as totalDay FROM resumes WHERE DATE(createdAt) = CURDATE() AND deleted = 0";
            return $this->db->query($query)->fetch();
        }

        public function getAllByMonth(){
            $query = "SELECT COUNT(*) as totalMonth  FROM resumes 
                    WHERE MONTH(createdAt) = MONTH(CURDATE()) 
                    AND YEAR(createdAt) = YEAR(CURDATE()) AND deleted = 0";
            return $this->db->query($query)->fetch();
        }

        public function getAllByYear(){
            $query = "SELECT COUNT(*) as totalYear FROM resumes 
                    WHERE YEAR(createdAt) = YEAR(CURDATE()) AND deleted = 0";
            return $this->db->query($query)->fetch();
        }

        public function getAllPending(){
            $query = "SELECT COUNT(*) as totalPending FROM resumes WHERE status = 'Đang chờ' AND deleted = 0";
            return $this->db->query($query)->fetch();
        }

        public function getAllNew(){
            $query = "SELECT u.name as user_name, c.name as company_name, pj.name as post_name, r.url, r.createdAt, r.status 
                    FROM resumes r
                    inner join users u on u.id = r.user_id
                    inner join post_jobs pj on pj.id = r.job_id
                    inner join companies c on c.id = pj.company_id
                    order by r.createdAt DESC LIMIT 6";
            return $this->db->query($query)->fetchAll();
        }
    }