<?php

namespace App\Controllers\admin;

use App\Controllers\ErrorController;
use App\Models\SkillModel;
use Framework\Session;
use Framework\Validation;

class SkillController
{
    protected $db;
    private $skill;
    public function __construct()
    {
        $this->skill = new SkillModel();
    }

    public function index()
    {
        $keyword = $_GET['keyword'] ?? "";

        $page =  $_GET['page'] ?? 1;

        $params = ['keyword' => "%$keyword%"];

        $skills = $this->skill->getAllskills($params);

        $count = count($skills);

        $pagination = handlePage($page, $count);

        $params['pagination'] = [
            'offset' => $pagination['offset'],
            'per_page' => $pagination['per_page']
        ];

        $skills = $this->skill->getSkillsPagination($params);

        return loadView('admin', 'skills/index', [
            'skills' => $skills,
            'count' => $pagination['count'],
            'page' => $page
        ]);
    }

    public function create()
    {

        loadView('admin', 'skills/create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $errors = [];
        $params = [
            'name' => $name
        ];
        $skill = $this->skill->getSkillByName($params);

        if ($skill) {
            $errors['name'] = 'Tên kỹ năng đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'skills/create', [
                'errors' => $errors,
                'skill' => [
                    'name' => $name
                ]
            ]);
            exit;
        }


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

        $skillId = $this->skill->insert($fields, $values, $params);
        Session::setFlashMessage('success_message','Skill create successfully');
        redirect('/admin-panel/skills');
    }

    public function edit($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $skill = $this->skill->getSkillById($params);
        if (!$skill) {
            ErrorController::notFound('Invalid ID. Skill not found.');
            exit();
        }
        loadView('admin', 'skills/edit', [
            'skill' => $skill
        ]);
    }

    public function update($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id,
        ];
        $skill = $this->skill->getSkillById($params);
        if (!$skill) {
            ErrorController::notFound('Invalid ID. Skill not found.');
            exit();
        }

        $name = $_POST['name'];
        $errors = [];

        $params = [
            'name' => $name
        ];
        $skillByName = $this->skill->getSkillByName($params);

        if ($skillByName) {
            $errors['name'] = 'Tên kỹ năng đã tồn tại';
        } else if (!Validation::string($name)) {
            $errors['name'] = 'Name không được để trống';
        }

        if (!empty($errors)) {
            loadView('admin', 'skills/edit', [
                'errors' => $errors,
                'skill' => $skill
            ]);
            exit;
        }

        $updatedValues = [
            'name' => $name
        ];

        $updatedFileds = [];
        foreach (array_keys($updatedValues) as $field) {
            $updatedFileds[] = "$field = :$field";
        }
        $updatedFileds = implode(', ', $updatedFileds);
        $updatedValues['id'] = $id;
        $this->skill->update($updatedFileds, $updatedValues);

        Session::setFlashMessage('success_message','Skill updated successfully');
        redirect('/admin-panel/skill/edit/' . $id);
    }
    public function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id,
        ];
        $skill = $this->skill->getSkillById($params);
        if (!$skill) {
            ErrorController::notFound('Invalid ID. Skill not found.');
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
        session::setFlashMessage('success_message','Skill deleted successfully');
        $this->skill->deleteSkillById($updatedFileds, $updatedValues);
        redirect('/admin-panel/skills');
    }
}
