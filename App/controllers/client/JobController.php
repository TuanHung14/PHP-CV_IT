<?php

namespace App\Controllers\client;

use App\Controllers\ErrorController;
use App\Models\CompanyModel;
use App\Models\JobModel;
use App\Models\PostJobModel;
use App\Models\SkillModel;
use Framework\Auth;

class JobController
{
    private $job;
    private $company;
    private $jobs;
    private $skill;
    public function __construct()
    {
        $this->job = new PostJobModel();
        $this->company = new CompanyModel(); 
        $this->jobs = new JobModel();
        $this->skill = new SkillModel();
    }

    public function index(){
        $keyword = $_GET['keyword'] ?? "";

        $keyword = trim($keyword);
        
        $suggestion = $_GET['suggestion'] ?? "";

        $location = $_GET['location'] ?? "";

        $nameSkill = $_GET['skill'] ?? "";
        

        $page =  $_GET['page'] ?? 1;

        $params = ['keyword' => "%$keyword%", 'location' => "%$location%", 'suggestion' => "%$suggestion%", 'skill' => "%$nameSkill%"];
        $jobs = $this->job->getAllJobsClient($params);

        $count = count($jobs);

        $pagination = handlePage($page, $count, 5);

        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];

        $jobs = $this->job->getjobsPaginationClients($params);
        foreach ($jobs as &$job){
            $job['skills_name'] = explode(',', $job['skills_name']);
        }
        $jobsFilter = $this->jobs->getJob();
        $companies = $this->company->getLocationHome();
        $locations = array_column($companies, 'location');
        $locations = array_unique($locations);
        $skills = $this->skill->getAll();
        loadView('client', 'jobs/index', [ 
            'jobs' => $jobs,
            'count' => $pagination['count'],
            'page' => $page,
            'jobsFilter' => $jobsFilter,
            'locations' => $locations,
            'keyword' => $keyword,
            'location' => $location,
           'suggestion' => $suggestion,
            'skills' => $skills,
            'nameSkill' => $nameSkill,
        ]);
    }
    

    public function show($params)
    {
        $id = $params['id'] ?? ''; 
        $params = [
            'id' => $id,
        ];
        $job = $this->job->getJobById($params);
        if (!$job) {
            ErrorController::notFound('Invalid ID. Jobs not found.');
            exit();
        }
        $company = $this->job->getCompanyByJobId($params);
        $job['skills_name'] = explode(',', $job['skills_name']);
        $user = Auth::user();

        loadView('client', 'jobs/show', [
            'job' => $job,
            'company' => $company,
            'user' => $user,
        ] );
    }

}