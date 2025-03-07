<?php

namespace App\Models;

use Framework\Database;

class PostJobModel
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
        $query = "SELECT  j.*FROM jobs j WHERE j.deleted = 0 LIMIT 6";
        return $this->db->query($query)->fetchAll();
    }
    public function getJob()
    {
        $query = "SELECT  j.*, c.thumbnail AS company_thumbnail, jb.name as job_name FROM post_jobs j 
                    JOIN companies c ON  j.company_id = c.id 
                    JOIN jobs jb on j.job_id = jb.id 
                    WHERE j.deleted = 0 AND j.isActive = 1 LIMIT 6";
        return $this->db->query($query)->fetchAll();
    }
    public function getAllJobs($params)
    {
        $query = "SELECT * FROM post_jobs WHERE deleted = 0 AND LOWER(name) LIKE LOWER(:keyword)";
        return $this->db->query($query, $params)->fetchAll();
    }

    public function getAllJobsClient($params){
        $query = "SELECT 
                    j.id,
                    j.company_id,
                    j.job_id,
                    j.name as job_post_name,
                    j.deleted,
                    c.name as company_name,
                    c.address as company_address,
                    jb.name as base_job_name,
                    GROUP_CONCAT(DISTINCT s.name) as required_skills
                FROM post_jobs j 
                JOIN companies c ON j.company_id = c.id 
                JOIN jobs jb on j.job_id = jb.id 
                JOIN job_skills jk ON j.id = jk.job_id 
                JOIN skills s ON s.id = jk.skill_id 
                WHERE j.deleted = 0 
                    AND (
                        LOWER(j.name) LIKE LOWER(:keyword) 
                        OR LOWER(c.name) LIKE LOWER(:keyword)
                        OR LOWER(s.name) LIKE LOWER(:keyword)
                    )
                    AND LOWER(c.location) LIKE LOWER(:location) 
                    AND LOWER(jb.name) LIKE LOWER(:suggestion) 
                    AND LOWER(s.name) LIKE LOWER(:skill) ";
        $query .= "GROUP BY j.id, j.company_id,j.job_id,j.name,j.deleted,c.name,c.address,jb.name";
        return $this->db->query($query, $params)->fetchAll();
    }
    public function getjobsPaginationClients($params)
    {
        $offset = $params['pagination']['offset'];
        $per_page = $params['pagination']['per_page'];
        unset($params['pagination']);
        $query = "SELECT j.*, 
                c.name AS company_name, 
                c.address as company_address, 
                jb.name as job_name,
                GROUP_CONCAT(s.name SEPARATOR ', ') as skills_name
            FROM post_jobs j 
            JOIN companies c ON j.company_id = c.id 
            JOIN job_skills jk ON j.id = jk.job_id 
            JOIN skills s ON s.id = jk.skill_id 
            JOIN jobs jb ON j.job_id = jb.id
            WHERE j.deleted = 0 
            AND (
                LOWER(j.name) LIKE LOWER(:keyword) 
                OR LOWER(c.name) LIKE LOWER(:keyword)
                OR LOWER(s.name) LIKE LOWER(:keyword)
            )
            AND LOWER(c.location) LIKE LOWER(:location)
            AND LOWER(jb.name) LIKE LOWER(:suggestion) 
             AND LOWER(s.name) LIKE LOWER(:skill) 
             AND isActive = 1";
        $query .= " GROUP BY j.id, j.name, c.name, c.address, jb.name, j.company_id, j.job_id LIMIT $offset, $per_page";

        return $this->db->query($query, $params)->fetchAll();
    }
    public function getjobsPagination($params)
    {

        $offset = $params['pagination']['offset'];
        $per_page = $params['pagination']['per_page'];
        unset($params['pagination']);

        $query = "SELECT j.*, c.name AS company_name, c.address as company_address FROM post_jobs j JOIN companies c ON  j.company_id = c.id  WHERE j.deleted = 0 AND LOWER(j.name) LIKE LOWER(:keyword) LIMIT $offset, $per_page";
        return $this->db->query($query, $params)->fetchAll();
    }
    public function getjobsByCompany($params)
    {
        $query = "SELECT j.*, c.name AS company_name, c.address as company_address 
        FROM post_jobs j JOIN companies c ON  j.company_id = c.id  
        WHERE j.deleted = 0 AND c.id = :company_id";
        return $this->db->query($query, $params)->fetchAll();
    }
    public function insert($field, $values, $params)
    {
        $query = "INSERT INTO post_jobs ({$field}) VALUES ({$values})";
        $this->db->query($query, $params);
        return $this->db->conn->lastInsertId();
    }
    public function getJobById($params)
    {
        $query = "SELECT j.*, jb.name as job_name,GROUP_CONCAT(s.id SEPARATOR ', ') as skills,GROUP_CONCAT(s.name SEPARATOR ', ') as skills_name FROM post_jobs j 
                    JOIN job_skills jk ON j.id = jk.job_id 
                    JOIN skills s ON s.id = jk.skill_id 
                    JOIN jobs jb on j.job_id = jb.id
                    WHERE j.id = :id
                    group by j.id";
        return $this->db->query($query, $params)->fetch();
    }
    public function getCompanyByJobId($params)
    {
        $query = "SELECT c.* FROM post_jobs j JOIN companies c ON j.company_id = c.id WHERE j.id = :id";
        return $this->db->query($query, $params)->fetch();
    }
    public function update($fields, $params)
    {
        $query = "UPDATE post_jobs SET {$fields} WHERE id = :id";
        return $this->db->query($query, $params);
    }
    public function deletejobById($fields, $params)
    {
        $query = "UPDATE post_jobs SET {$fields} WHERE id = :id";
        return $this->db->query($query, $params);
    }
}
