<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\CompanyModel;
use Framework\Auth;
use Framework\Session;
use Framework\Validation;

class CompanyController extends BaseController
{
    protected $db;
    private $company;
    public function __construct()
    {
        $this->company = new CompanyModel();
    }

    public function index()
    {
        $user = Auth::user();
        $companies = [];
        if($this->checkRole($user, ['HR'])){
            $company_id = $user['company_id'];
            $params = [
                'id' => $company_id,
            ];
            $companies = $this->company->getCompanyByIdAndUserId($params);

        }else{
            $keyword = $_GET['keyword'] ?? "";

            $page =  $_GET['page'] ?? 1;

            $params = ['keyword' => "%$keyword%"];

            $companies = $this->company->getAllCompanies($params);

            $count = count($companies);

            $pagination = handlePage($page, $count);

            $params['pagination'] = [
                'offset' => $pagination['offset'],
                'per_page' => $pagination['per_page']
            ];

            $companies = $this->company->getCompaniesPagination($params);
        }
        return loadView('admin', 'companies/index', [
            'companies' => $companies,
            'count' => $pagination['count'] ?? null,
            'page' => $page ?? null
        ]);
    }

    public function create()
    {

        loadView('admin', 'companies/create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $location  = $_POST['location'];
        $description = $_POST['description'];
        $thumbnail = $_FILES['thumbnail']["name"] ?? [];
        $thumbnail_temp = $_FILES['thumbnail']["tmp_name"] ?? [];
        $errors = [];
        if (empty($thumbnail)) {
            $errors['thumbnail'] = "Vui lòng chọn file ảnh thumbnail";
        } else {
            $thumbnail = upFileInFolder('company', $thumbnail, $thumbnail_temp);
            if (!$thumbnail) {
                $errors['thumbnail'] = "File không đúng định dạng hoặc bị lỗi";
            }
        }
        if (!Validation::string($name, 6, 50)) {
            $errors['name'] = 'Name phải ít nhất 6 ký tự';
        }
        if (!Validation::string($address, 11)) {
            $errors['address'] = 'address phải ít nhất 11 ký tự';
        }
        if (!Validation::string($location)) {
            $errors['location'] = 'Location không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'companies/create', [
                'errors' => $errors,
                'company' => [
                    'name' => $name,
                    'address' => $address,
                    'location' => $location,
                    'description' => $description,
                    'thumbnail' => $thumbnail,
                ]
            ]);
            exit;
        }
        $description = handleImgBySummernote($description);

        $params = [
            'name' => $name,
            'address' => $address,
            'description' => $description,
            'location' => $location,
            'thumbnail' => $thumbnail,
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

        $companyId = $this->company->insert($fields, $values, $params);

        Session::setFlashMessage('success_message','Company create successfully');

        redirect('/admin-panel/company');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $company = $this->company->getCompanyById($params);
        if (!$company) {
            ErrorController::notFound('Invalid ID. Company not found.');
            exit();
        }
        loadView('admin', 'companies/edit', [
            'company' => $company
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $company = $this->company->getCompanyById($params);
        if (!$company) {
            ErrorController::notFound('Invalid ID. Company not found.');
            exit();
        }

        $name = $_POST['name'];
        $address = $_POST['address'];
        $location  = $_POST['location'];
        $description = $_POST['description'];
        $thumbnail = $_FILES['thumbnail']["name"] ?? "";
        $thumbnail_temp = $_FILES['thumbnail']["tmp_name"] ?? "";
        $errors = [];
        if (empty($thumbnail)) {
            $thumbnail = $company['thumbnail'];
        } else {
            $thumbnail = upFileInFolder('company', $thumbnail, $thumbnail_temp);
            if (!$thumbnail) {
                $errors['thumnail'] = "File không đúng định dạng hoặc bị lỗi";
            }
        }

        if (!Validation::string($name, 6, 50)) {
            $errors['name'] = 'Name phải ít nhất 6 ký tự';
        }
        if (!Validation::string($address, 11)) {
            $errors['address'] = 'address phải ít nhất 11 ký tự';
        }
        if (!Validation::string($location)) {
            $errors['location'] = 'Location không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'companies/edit', [
                'errors' => $errors,
                'company' => $company
            ]);
            exit;
        }
        $description = handleImgBySummernote($description);

        $updatedValues = [
            'name' => $name,
            'address' => $address,
            'location' => $location,
            'description' => $description,
            'thumbnail' => $thumbnail,
        ];

        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $id;
        $this->company->update($updatedFileds, $updatedValues);

        Session::setFlashMessage('success_message','Company updated successfully');

        redirect('/admin-panel/company/edit/' . $id);
    }
    public function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id,
        ];
        $company = $this->company->getCompanyById($params);
        if (!$company) {
            ErrorController::notFound('Invalid ID. Company not found.');
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
        Session::setFlashMessage('success_message','Company deleted successfully');
        $this->company->deleteCompanyById($updatedFileds, $updatedValues);
        redirect('/admin-panel/company');
    }
}
