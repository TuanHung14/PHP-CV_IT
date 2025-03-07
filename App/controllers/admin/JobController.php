<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\JobModel;
use Framework\Session;
use Framework\Validation;

class JobController
{
    protected $db;
    private $jobs;
    public function __construct()
    {
        $this->jobs = new JobModel();
    }

    public function index()
    {
        $keyword = $_GET['keyword'] ?? "";

        $page =  $_GET['page'] ?? 1;

        $params = ['keyword' => "%$keyword%"];

        $jobs = $this->jobs->getAllJobs($params);

        $count = count($jobs);

        $pagination = handlePage($page, $count);

        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];

        $jobs = $this->jobs->getjobsPagination($params);

        return loadView('admin', 'jobs/index', [
            'jobs' => $jobs,
            'count' => $pagination['count'],
            'page' => $page
        ]);
    }

    public function create()
    {

        loadView('admin', 'jobs/create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $errors = [];
        $params = [
            'name' => $name
        ];
        $job = $this->jobs->getJobByName($params);

        if ($job) {
            $errors['name'] = 'Tên kỹ năng đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }
        if(!Validation::string($description)){
            $errors['description'] = 'Description không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'jobs/create', [
                'errors' => $errors,
                'job' => [
                    'name' => $name,
                    'description' => $description
                ]
            ]);
            exit;
        }

        $params['description'] = $description;
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
        inspect($fields);
        inspect($values);

        $jobId = $this->jobs->insert($fields, $values, $params);
        Session::setFlashMessage('success_message','Job create successfully');
        redirect('/admin-panel/jobs');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $job = $this->jobs->getJobById($params);
        if (!$job) {
            ErrorController::notFound('Invalid ID. Job not found.');
            exit();
        }
        loadView('admin', 'jobs/edit', [
            'job' => $job
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $job = $this->jobs->getJobById($params);
        if (!$job) {
            ErrorController::notFound('Invalid ID. Job not found.');
            exit();
        }

        $name = $_POST['name'];
        $description = $_POST['description'];
        $errors = [];

        $params = [
            'name' => $name
        ];
        $jobByName = $this->jobs->getJobByName($params);

        if ($jobByName) {
            $errors['name'] = 'Tên job đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'jobs/edit', [
                'errors' => $errors,
                'job' => $job
            ]);
            exit;
        }

        $updatedValues = [
            'name' => $name,
            'description' => $description,
        ];

        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $id;
        $this->jobs->update($updatedFileds, $updatedValues);

        Session::setFlashMessage('success_message','Job updated successfully');
        redirect('/admin-panel/job/edit/' . $id);
    }
    public function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id,
        ];
        $job = $this->jobs->getJobById($params);
        if (!$job) {
            ErrorController::notFound('Invalid ID. Job not found.');
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
        session::setFlashMessage('success_message','Job deleted successfully');
        $this->jobs->deletejobById($updatedFileds, $updatedValues);
        redirect('/admin-panel/jobs');
    }
}
