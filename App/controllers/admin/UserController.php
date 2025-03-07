<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\CompanyModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use Framework\Session;
use Framework\Validation;

class UserController
{
    protected $db;
    private $user;
    private $role;
    private $company;
    public function __construct()
    {
        $this->user = new UserModel();
        $this->role = new RoleModel();
        $this->company = new CompanyModel();
    }

    public function index()
    {
        $keyword = $_GET['keyword'] ?? "";

        $page =  $_GET['page'] ?? 1;

        $params = ['keyword' => "%$keyword%"];

        $users = $this->user->getAllUser($params);

        $count = count($users);

        $pagination = handlePage($page, $count);

        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];

        $users = $this->user->getUserPagination($params);

        return loadView('admin', 'users/index', [
            'users' => $users,
            'count' => $pagination['count'],
            'page' => $page
        ]);
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $user = $this->user->getUserById($params);
        $roles = $this->role->getAll();
        $companies = $this->company->getAll();
        if (!$user) {
            ErrorController::notFound('Invalid ID. Users not found.');
            exit();
        }
        loadView('admin', 'users/edit', [
            'user' => $user,
            'roles' => $roles,
            'companies' => $companies
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $user = $this->user->getUserById($params);
        if (!$user) {
            ErrorController::notFound('Invalid ID. Users not found.');
            exit();
        }

        $role_id = $_POST['role_id'];
        $company_id = empty($_POST['company_id']) ? null : $_POST['company_id'];
       


        $updatedValues = [
            'role_id' => $role_id,
            'company_id' => $company_id
        ];

        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $id;
        $this->user->update($updatedValues, $updatedFileds);

        Session::setFlashMessage('success_message','User updated successfully');
        redirect('/admin-panel/user/edit/' . $id);
    }
}
