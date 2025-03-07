<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use Framework\Session;
use Framework\Validation;

class RoleController
{
    protected $db;
    private $role;
    private $permission;
    private $rolePermission;
    public function __construct()
    {
        $this->role = new RoleModel();
        $this->permission = new PermissionModel();
        $this->rolePermission = new RolePermissionModel();
    }

    public function customPermissions()
    {
        $permissions = $this->permission->getAll();
        $customPermission = [];
        foreach ($permissions as $permission) {
            $module = explode('_', $permission['name']);
            if (in_array($module[1], $customPermission)) {
                $customPermission[$module[1]] = $permission;
            } else {
                $customPermission[$module[1]][] = $permission;
            }
        }
        return $customPermission;
    }

    public function index()
    {
        $keyword = $_GET['keyword'] ?? "";

        $page =  $_GET['page'] ?? 1;

        $params = ['keyword' => "%$keyword%"];

        $roles = $this->role->getAllRoles($params);

        $count = count($roles);

        $pagination = handlePage($page, $count);

        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];

        $permissions = $this->role->getRolesPagination($params);

        return loadView('admin', 'roles/index', [
            'roles' => $roles,
            'count' => $pagination['count'],
            'page' => $page
        ]);
    }

    public function create()
    {
        $customPermission = $this->customPermissions();
        loadView('admin', 'roles/create', ['permissions' => $customPermission]);
    }

    public function store()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $permission = json_decode($_POST['permissions']);

        // làm đến đây 
        $errors = [];
        $params = [
            'name' => $name,
        ];

        $role = $this->role->getRoleByName($params);

        if ($role) {
            $errors['name'] = 'Tên role đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }

        if (!empty($errors)) {
            $customPermission = $this->customPermissions();
            loadView('admin', 'roles/create', [
                'errors' => $errors,
                'permissions' => $customPermission,
                'role' => [
                    'name' => $name,
                    'description' => $description,
                    'permission' => $permission
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

        $roleId = $this->role->insert($fields, $values, $params);

        foreach ($permission as $row) {
            $params = [
                'role_id' => $roleId,
                'permission_id' => $row
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

            $this->rolePermission->insert($fields, $values, $params);
        }
        Session::setFlashMessage('success_message','Role create successfully');
        redirect('/admin-panel/roles');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $role = $this->role->getRoleById($params);
        $role['permission'] = explode(', ', $role['permission']);
        if (!$role) {
            ErrorController::notFound('Invalid ID. Role not found.');
            exit();
        }
        $customPermission = $this->customPermissions();
        loadView('admin', 'roles/edit', [
            'role' => $role,
            'permissions' => $customPermission,
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $role = $this->role->getRoleById($params);
        if (!$role) {
            ErrorController::notFound('Invalid ID. Role not found.');
            exit();
        }

        $name = $_POST['name'];
        $description = $_POST['description'];
        $permission = json_decode($_POST['permissions']);


        $errors = [];
        $params = [
            'name' => $name,
            'id' => $id,
        ];

        $roleName = $this->role->getRoleByNameAndId($params);

        if ($roleName) {
            $errors['name'] = 'Tên role đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }
        if (!Validation::string($description)) {
            $errors['description'] = 'description không được để trống';
        }

        if (!empty($errors)) {
            $customPermission = $this->customPermissions();
            loadView('admin', 'roles/edit', [
                'errors' => $errors,
                'permissions' => $customPermission,
                'role' => [
                    'name' => $name,
                    'description' => $description,
                    'permission' => $permission
                ]
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
        $this->role->update($updatedFileds, $updatedValues);
        $params = [
            'role_id' => $id,
        ];
        //Xóa tất cả permission
        $this->rolePermission->deleteMany($params);
        //Thêm những permission update
        foreach ($permission as $row) {
            $params = [
                'role_id' => $id,
                'permission_id' => $row
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

            $this->rolePermission->insert($fields, $values, $params);
        }

        Session::setFlashMessage('success_message','Role updated successfully');
        redirect('/admin-panel/role/edit/' . $id);
    }
    public function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id,
        ];
        $role = $this->role->getRoleById($params);
        if (!$role) {
            ErrorController::notFound('Invalid ID. Role not found.');
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
        session::setFlashMessage('success_message','Role deleted successfully');
        $this->role->deleteRoleById($updatedFileds, $updatedValues);
        redirect('/admin-panel/permissions');
    }
}
