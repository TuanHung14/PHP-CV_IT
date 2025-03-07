<?php

namespace App\Controllers\client;

use App\Models\CompanyModel;
use App\Models\JobModel;
use App\Models\PostJobModel;
class HomeController
{
   private $job;
   private $company;
   private $jobs;
    public function __construct()
    {
        $this->job = new PostJobModel();
        $this->company = new CompanyModel(); 
        $this->jobs = new JobModel(); 
    }
    public function index()
    {   
        $post_jobs = $this->job->getJob();
        $companies = $this->company->getAllHome();
        $location = $this->company->getLocationHome();
        $jobs = $this->jobs->getJob();
        $data = [];
        
        //lọc location trong companies ra biến mới
        $locations = array_column($location, 'location');
        $locations = array_unique($locations);
        $data['locations'] = $locations;
        $data['jobs'] = $jobs;


        loadView('client', 'home/index', [
            'jobs' => $post_jobs,
            'companies' => $companies,
            'data' => $data
        ]);
    }
}
