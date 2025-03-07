<?php

namespace App\Controllers\client;

use App\Controllers\ErrorController;
use App\Models\CompanyModel;

class CompanyController
{
    private $company;
    public function __construct()
    {
        $this->company = new CompanyModel();
    }
    
    public function index(){
        $keyword = $_GET['keyword'] ?? "";
        $page =  $_GET['page'] ?? 1;
        $params = ['keyword' => "%$keyword%"];
        $companies = $this->company->getAllCompanies($params);
        $count = count($companies);

        $pagination = handlePage($page, $count, 9);

        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];

        $companies = $this->company->getCompaniesPagination($params);
        loadView('client', 'companies/index', [
            'companies' => $companies,
            'count' => $pagination['count'],
            'page' => $page,
            'keyword' => $keyword,
        ] );
    }

    public function show($params)
    {
        $id = $params['id'] ?? ''; 
        $params = [
            'id' => $id,
        ];
        $company = $this->company->getCompanyById($params);
        if(!$company){
            ErrorController::notFound('Invalid ID. Company not found.');
            exit();
        }
        $jobs = $this->company->getJobByCompany($params);
        foreach($jobs as &$job){
            $job['skills_name'] = explode(',', $job['skills_name']);
        }

        loadView('client', 'companies/show', [
            'company' => $company,
            'jobs' => $jobs,
        ] );
    }

}