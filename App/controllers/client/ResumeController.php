<?php

namespace App\Controllers\client;

use App\Controllers\ErrorController;
use App\Models\PostJobModel;
use App\Models\ResumeModel;
use App\Models\UserModel;
use Framework\Session;

class ResumeController
{
    private $post_job;
    private $resume;
    private $user;
    public function __construct(){
        $this->resume = new ResumeModel(); 
        $this->user = new UserModel();  
        $this->post_job = new PostJobModel();
    }
    public function store(){
        $user_id = $_POST['user_id'];
        $job_id = $_POST['job_id'];
        $resume = $_FILES['resume']["name"];
        $resume_temp  = $_FILES['resume']["tmp_name"];
        $params = [
            'id' => $user_id
        ];
        $user = $this->user->getUserById($params);
        if(!$user){
            ErrorController::notFound('User not found');
            exit();
        }
        $params = [
            'id' => $job_id
        ];
        $job = $this->post_job->getJobById($params);
        if(!$job){
            ErrorController::notFound('Job not found');
            exit();
        }
        $params = [
            'user_id' => $user_id,
            'job_id' => $job_id
        ];
        $resume_check = $this->resume->getResumeByUserIdAndJobId($params);
        if($resume_check){
            Session::setFlashMessage('error_message','Bạn đã ứng tuyển với công ty này rồi');
            redirect('/job/'. $job_id);
        }
        if ($resume == ""){
            Session::setFlashMessage('error_message','Bạn chưa chọn file resume');
            redirect('/job/'. $job_id);
        }
        $allowed_extensions = array("pdf", "docx");
        $extension = strtolower(pathinfo($resume, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowed_extensions)) {
            Session::setFlashMessage('error_message','File resume phải có định dạng PDF hoặc DOCX');
            redirect('/job/'. $job_id);
        }

        $targetDir = "file/resume". "/";
        createFolderIfNotExists($targetDir);
        $randomDigits = rand(1000, 9999);
        $fileName = pathinfo($resume, PATHINFO_FILENAME);
        $fileType = pathinfo($resume, PATHINFO_EXTENSION);
        $newFileName = $fileName . "_" . $randomDigits . "." . $fileType;
        $targetFilePath = $targetDir . $newFileName;
        move_uploaded_file($resume_temp, $targetFilePath);

        $params = [
            'user_id' => $user_id,
            'job_id' => $job_id,
            'url' => $newFileName
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

        $this->resume->store($fields, $values, $params);
        Session::setFlashMessage('success_message','Đã đăng ký ứng tuyển thành công');
        redirect('/job/'. $job_id);
    }
}