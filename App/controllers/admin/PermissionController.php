<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\PermissionModel;
use Framework\Session;
use Framework\Validation;

class PermissionController
{
    protected $db;
    private $permission;
    public function __construct()
    {
        $this->permission = new PermissionModel();
    }

    public function index()
    {
        $keyword = $_GET['keyword'] ?? "";

        $page =  $_GET['page'] ?? 1;

        $params = ['keyword' => "%$keyword%"];

        $permissions = $this->permission->getAllPermissions($params);

        $count = count($permissions);

        $pagination = handlePage($page, $count);

        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];

        $permissions = $this->permission->getPermissionsPagination($params);

        return loadView('admin', 'permissions/index', [
            'permissions' => $permissions,
            'count' => $pagination['count'],
            'page' => $page
        ]);
    }

    public function create()
    {

        loadView('admin', 'permissions/create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $errors = [];
        $params = [
            'name' => $name,
        ];

        $permission = $this->permission->getPermissionByName($params);

        if ($permission) {
            $errors['name'] = 'Tên quyền đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'permissions/create', [
                'errors' => $errors,
                'permission' => [
                    'name' => $name,
                    'description' => $description,
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

        $permissionId = $this->permission->insert($fields, $values, $params);
        Session::setFlashMessage('success_message','Permission create successfully');
        redirect('/admin-panel/permissions');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $permission = $this->permission->getPermissionById($params);
        if (!$permission) {
            ErrorController::notFound('Invalid ID. Permission not found.');
            exit();
        }
        loadView('admin', 'permissions/edit', [
            'permission' => $permission
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $permission = $this->permission->getPermissionById($params);
        if (!$permission) {
            ErrorController::notFound('Invalid ID. Permission not found.');
            exit();
        }

        $name = $_POST['name'];
        $description = $_POST['description'];
        $errors = [];

        $params = [
            'name' => $name
        ];
        $permissionByName = $this->permission->getPermissionByName($params);

        if ($permissionByName) {
            $errors['name'] = 'Tên quyền đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'permissions/edit', [
                'errors' => $errors,
                'permission' => $permission
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
        $this->permission->update($updatedFileds, $updatedValues);

        Session::setFlashMessage('success_message','Permission updated successfully');
        redirect('/admin-panel/permission/edit/' . $id);
    }
    public function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id,
        ];
        $permission = $this->permission->getPermissionById($params);
        if (!$permission) {
            ErrorController::notFound('Invalid ID. Permission not found.');
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
        session::setFlashMessage('success_message','Permission deleted successfully');
        $this->permission->deletePermissionById($updatedFileds, $updatedValues);
        redirect('/admin-panel/permissions');
    }
}
