<?php

namespace App\Controllers\client;

use App\Models\ResumeModel;
use App\Models\UserModel;
use Framework\Auth;
use Framework\Session;
use Framework\Validation;

class ProfileController{
    private $user;
    private $resume;
    public function __construct()
    {
        $this->user = new UserModel();
        $this->resume = new ResumeModel();
    }
    public function index(){
        $user = Auth::user();
        return loadView('client','profile/index', [
            'user' => $user
        ]);
    }
    public function update(){
        $current_user = Auth::user();
        $name = $_POST['name'];
        if (!Validation::string($name, 6, 50)) {
            $errors['name'] = 'Name phải ít nhất 6 ký tự';
        }
        if (!empty($errors)) {
            loadView('client','profile/index', [
                'user' => $current_user,
                'errors' => $errors
            ]);
            exit();
        }
        $updatedValues = [
            'name' => $name
        ];
        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $current_user['id'];
        $this->user->update($updatedValues, $updatedFileds);
        Session::setFlashMessage('success_message','Cập nhập thông tin cá nhân thành công');

        redirect('/profile');
    }
    public function resume(){
        $page =  $_GET['page'] ?? 1;
        $current_user = Auth::user();
        $params = [
            'user_id' => $current_user['id']
        ];
        $resumes = $this->resume->getResumeByUserId($params);
        $count = count($resumes);
        $pagination = handlePage($page, $count, 3);
        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];
        $resumes = $this->resume->getResumePagination($params);
        return loadView('client','profile/resume', [
            'user' => $current_user,
            'resumes' => $resumes,
            'count' => $pagination['count'],
            'page' => $page
        ]);
    }
}