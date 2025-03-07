<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\CompanyModel;
use App\Models\PostJobModel;
use App\Models\JobSkillsModel;
use App\Models\SkillModel;
use App\Models\JobModel;
use Framework\Auth;
use Framework\Session;
use Framework\Validation;

class PostJobController extends BaseController
{
    protected $db;
    private $job;
    private $jobs;
    private $skill;
    private $company;
    private $jobSkills;
    public function __construct()
    {
        $this->job = new PostJobModel();
        $this->jobs = new JobModel();
        $this->skill = new SkillModel();
        $this->company = new CompanyModel();
        $this->jobSkills = new JobSkillsModel();
    }

    public function levelsAction()
    {
        $levels = [
            [
                'name' => "Trình độ...",
                'active' => true,
                'value' => ""
            ],
            [
                'name' => "INTERN",
                'active' => false,
                'value' => "INTERN"
            ],
            [
                'name' => "FRESHER",
                'active' => false,
                'value' => "FRESHER"
            ],
            [
                'name' => "JUNIOR",
                'active' => false,
                'value' => "JUNIOR"
            ],
            [
                'name' => "SENIOR",
                'active' => false,
                'value' => "SENIOR"
            ]
        ];
        return $levels;
    }

    public function index()
    {

        $user = Auth::user();
        $jobs = [];
        if($this->checkRole($user, ['HR'])){
            $company_id = $user['company_id'];
            $params = [
                'company_id' => $company_id,
            ];
            $jobs = $this->job->getjobsByCompany($params);
        }else{
            $keyword = $_GET['keyword'] ?? "";

            $page =  $_GET['page'] ?? 1;

            $params = ['keyword' => "%$keyword%"];

            $jobs = $this->job->getAllJobs($params);

            $count = count($jobs);

            $pagination = handlePage($page, $count);

            $params['pagination'] = [
                'offset' => $pagination['offset'],
                'per_page' => $pagination['per_page']
            ];

            $jobs = $this->job->getjobsPagination($params);
        }
        return loadView('admin', 'post_jobs/index', [
            'jobs' => $jobs,
            'count' => $pagination['count'] ?? null,
            'page' => $page ?? null
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $company = [];
        if($this->checkRole($user, ['HR'])){
            $company_id = $user['company_id'];
            $params = [
                'id' => $company_id,
            ];
            $company = $this->company->getCompanyByIdAndUserId($params);
        }else{
            $company = $this->company->getAll();
        }
        $skills = $this->skill->getAll();
        $levels = $this->levelsAction();
        $jobs = $this->job->getAll();

        loadView('admin', 'post_jobs/create', ['skills' => $skills, 'company' => $company, 'levels' => $levels, 'jobs' => $jobs]);
    }

    public function store()
    {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $salary = $_POST['salary'];
        $level = $_POST['level'];
        $company_id = $_POST['company_id'];
        $job_id = $_POST['job_id'];
        $skills = $_POST['skills'] ?? [];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $description = $_POST['description'];
        $active = $_POST['active'] ?? 'off';
        $errors = [];

        if (!Validation::string($name, 2, 999)) {
            $errors['name'] = 'Name không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }
        if (!Validation::string($startDate)) {
            $errors['startDate'] = 'StartDate không được để trống';
        }
        if (!Validation::string($endDate)) {
            $errors['endDate'] = 'endDate không được để trống';
        }
        if (Validation::string($startDate)  && Validation::string($endDate) && !Validation::startEndDate($startDate, $endDate)) {
            $errors['date'] = 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc';
        }
        if (!Validation::string($quantity)) {
            $errors['quantity'] = 'quantity không được để trống';
        }
        if (!Validation::string($salary)) {
            $errors['salary'] = 'salary không được để trống';
        }
        if (!Validation::string($level)) {
            $errors['level'] = 'level không được để trống';
        }
        if (!Validation::string($company_id)) {
            $errors['company_id'] = 'Company không được để trống';
        }
        if (!Validation::string($job_id)) {
            $errors['job_id'] = 'Job không được để trống';
        }
        if (!Validation::array($skills)) {
            $errors['skills'] = 'Skills không được để trống';
        }

        if (!empty($errors)) {
            $skillAll = $this->skill->getAll();
            $company = $this->company->getAll();
            $levels = $this->levelsAction();
            $levels = array_map(function ($item) use ($level) {
                if (!$level) {
                    return $item;
                }
                if ($item['name'] ===  $level) {
                    $item['active'] = true;
                } else {
                    $item['active'] = false;
                }
                return $item;
            }, $levels);
            loadView('admin', 'post_jobs/create', [
                'errors' => $errors,
                'skills' => $skillAll,
                'company' => $company,
                'levels' => $levels,
                'job' => [
                    'name' => $name,
                    'quantity' => $quantity,
                    'salary' => $salary,
                    'skills' => $skills,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'company_id' => $company_id,
                    'job_id' => $job_id,
                    'description' => $description,
                ]
            ]);
            exit;
        }
        $description = handleImgBySummernote($description);

        $params = [
            'name' => $name,
            'quantity' => $quantity,
            'salary' => $salary,
            'level' => $level,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'description' => $description,
            'company_id' => $company_id,
            'job_id' => $job_id,
            'isActive' => $active === "on" ? 1 : 0,
        ];

        $fields = [];
        $values = [];
        foreach ($params as $field => $value) {
            $fields[] = $field;
            if ($value === '') {
                $params[$field] = null;
            }
            $values[] = ":$field";
        }
        $fields = implode(', ', $fields);
        $values = implode(', ', $values);

        $jobId = $this->job->insert($fields, $values, $params);

        foreach ($skills as $skill) {
            $params = [
                'job_Id' => $jobId,
                'skill_id' => $skill
            ];

            $fields = [];
            $values = [];
            foreach ($params as $field => $value) {
                $fields[] = $field;
                if ($value === '') {
                    $params[$field] = null;
                }
                $values[] = ":$field";
            }
            $fields = implode(', ', $fields);
            $values = implode(', ', $values);
            $this->jobSkills->insert($fields, $values, $params);
        }

        Session::setFlashMessage('success_message','Post job create successfully');
        redirect('/admin-panel/post_jobs');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $job = $this->job->getJobById($params);
        // custom trường dữ liệu
        $job['skills'] = explode(',', $job['skills']);
        $job['startDate'] = explode(" ",  $job['startDate'])[0];
        $job['endDate'] = explode(" ",  $job['endDate'])[0];


        
        $user = Auth::user();
        $company = [];
        if($this->checkRole($user, ['HR'])){
            $company_id = $user['company_id'];
            $params = [
                'id' => $company_id,
            ];
            $company = $this->company->getCompanyByIdAndUserId($params);
        }else{
            $company = $this->company->getAll();
        }
        $skills = $this->skill->getAll();
        $jobs = $this->job->getAll();

        $levels = $this->levelsAction();
        $level = $job['level'];
        $levels = array_map(function ($item) use ($level) {
            if (!$level) {
                return $item;
            }
            if ($item['name'] ===  $level) {
                $item['active'] = true;
            } else {
                $item['active'] = false;
            }
            return $item;
        }, $levels);

        if (!$job) {
            ErrorController::notFound('Invalid ID. Post job not found.');
            exit();
        }
        loadView('admin', 'post_jobs/edit', [
            'job' => $job,
            'company' => $company,
            'skills' => $skills,
            'levels' => $levels,
            'jobs' => $jobs,
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $job = $this->job->getJobById($params);
        if (!$job) {
            ErrorController::notFound('Invalid ID. Post job not found.');
            exit();
        }

        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $salary = $_POST['salary'];
        $level = $_POST['level'];
        $company_id = $_POST['company_id'];
        $job_id = $_POST['job_id'];
        $skills = $_POST['skills'] ?? [];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $description = $_POST['description'];
        $active = $_POST['active'] ?? 'off';
        $errors = [];

        if (!Validation::string($name, 2, 99)) {
            $errors['name'] = 'Name không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }
        if (!Validation::string($startDate)) {
            $errors['startDate'] = 'StartDate không được để trống';
        }
        if (!Validation::string($endDate)) {
            $errors['endDate'] = 'endDate không được để trống';
        }
        if (Validation::string($startDate)  && Validation::string($endDate) && !Validation::startEndDate($startDate, $endDate)) {
            $errors['date'] = 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc';
        }
        if (!Validation::string($quantity)) {
            $errors['quantity'] = 'quantity không được để trống';
        }
        if (!Validation::string($salary)) {
            $errors['salary'] = 'salary không được để trống';
        }
        if (!Validation::string($level)) {
            $errors['level'] = 'level không được để trống';
        }
        if (!Validation::string($company_id)) {
            $errors['company_id'] = 'Company không được để trống';
        }
        if (!Validation::string($job_id)) {
            $errors['job_id'] = 'Job không được để trống';
        }
        if (!Validation::array($skills)) {
            $errors['skills'] = 'Skills không được để trống';
        }

        if (!empty($errors)) {
            $skillAll = $this->skill->getAll();
            $company = $this->company->getAll();
            $jobs = $this->job->getAll();
            $levels = $this->levelsAction();
            $levels = array_map(function ($item) use ($level) {
                if (!$level) {
                    return $item;
                }
                if ($item['name'] ===  $level) {
                    $item['active'] = true;
                } else {
                    $item['active'] = false;
                }
                return $item;
            }, $levels);
            loadView('admin', 'post_jobs/edit', [
                'errors' => $errors,
                'skills' => $skillAll,
                'company' => $company,
                'levels' => $levels,
                'jobs' => $jobs,
                'job' => [
                    'id' => $id,
                    'name' => $name,
                    'quantity' => $quantity,
                    'salary' => $salary,
                    'skills' => $skills,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'company_id' => $company_id,
                    'job_id' => $job_id,
                    'description' => $description,
                ]
            ]);
            exit;
        }

        $description = handleImgBySummernote($description);

        $updatedValues = [
            'name' => $name,
            'quantity' => $quantity,
            'salary' => $salary,
            'level' => $level,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'description' => $description,
            'company_id' => $company_id,
            'job_id' => $job_id,
            'isActive' => $active === "on" ? 1 : 0,
        ];

        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $id;
        $this->job->update($updatedFileds, $updatedValues);

        $params = [
            'job_id' => $id,
        ];

        $this->jobSkills->deleteMany($params);

        foreach ($skills as $skill) {
            $params = [
                'job_Id' => $id,
                'skill_id' => $skill
            ];

            $fields = [];
            $values = [];
            foreach ($params as $field => $value) {
                $fields[] = $field;
                if ($value === '') {
                    $params[$field] = null;
                }
                $values[] = ":$field";
            }
            $fields = implode(', ', $fields);
            $values = implode(', ', $values);
            $this->jobSkills->insert($fields, $values, $params);
        }

        //chưa update skills role

        Session::setFlashMessage('success_message','Post job updated successfully');
        redirect('/admin-panel/post_job/edit/' . $id);
    }
    public function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id,
        ];
        $job = $this->job->getJobById($params);
        if (!$job) {
            ErrorController::notFound('Invalid ID. Post job not found.');
            exit();
        }

        $updatedValues = [
            'deleted' =>  true
        ];

        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $id;
        //Set Flash Session
        session::setFlashMessage('success_message','Post job deleted successfully');
        $this->job->deletejobById($updatedFileds, $updatedValues);
        redirect('/admin-panel/post_jobs');
    }
}
