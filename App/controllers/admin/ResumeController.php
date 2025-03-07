<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\ResumeModel;
use Framework\Auth;
use Framework\Session;

class ResumeController extends BaseController
{
    private $resume;
    public function __construct(){
        $this->resume = new ResumeModel();

    }
    public function statusAction()
    {
        $status = [
            [
                'name' => "Đang chờ",
                'active' => false,
            ],
            [
                'name' => "Đã xem",
                'active' => false,
            ],
            [
                'name' => "Được mời phỏng vấn",
                'active' => false,
            ],
            [
                'name' => "Từ chối",
                'active' => false,
            ]
        ];
        return $status;
    }
    public function index(){
        $user = Auth::user();
        
        $keyword = $_GET['keyword'] ?? "";

        $page =  $_GET['page'] ?? 1;

        $params = [
            'keyword' => "%$keyword%"
        ];
        if($this->checkRole($user, ['HR'])){
            $params['id'] = $user['company_id'];
            $resumes = $this->resume->getAllByCompany($params);
        }else{
            $resumes = $this->resume->getAll($params);
        }
        $count = count($resumes);
        
        $pagination = handlePage($page, $count);
        
        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];
        if($this->checkRole($user, ['HR'])){
            $resumes = $this->resume->getAllByCompanyPagination($params);
        }else{
            $resumes = $this->resume->getAllPagination($params);
        }
        $status = $this->statusAction();
        loadView('admin', 'resumes/index',[
            'user' => $user,
           'resumes' => $resumes,
            'count' => $pagination['count'],
            'page' => $page,
            'keyword' => $keyword,
           'status' => $status
        ]);
    }
    public function update($params){
        $id = $params['id']?? "";
        $status = $_POST['status']?? "";
        $resume = $this->resume->getResumeById($params);
        if (!$resume) {
            ErrorController::notFound('Invalid ID. Resume not found.');
            exit();
        }
        
        $updatedValues = [
           'status' => $status
        ];
        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $id;
        try{
            $this->resume->update($updatedFileds, $updatedValues);
            Session::setflashMessage('success_message','Chage status successfully');
            redirect('/admin-panel/resumes');
        }catch(\Throwable $th){
            Session::setflashMessage('error_message','Change status failed');
            redirect('/admin-panel/resumes');
        }
    }
}