<?php
//client
$router->get('/', 'HomeController@index');


$router->get('/auth/register', 'UserController@create', ['guest']);
$router->get('/auth/login', 'UserController@login', ['guest']);

$router->post('/auth/register', 'UserController@store', ['guest']);
$router->post('/auth/logout', 'UserController@logout', ['auth']);

$router->post('/auth/login', 'UserController@authenticate', ['guest']);

$router->get('/job/{id}', 'JobController@show');
$router->get('/jobs', 'JobController@index');

$router->get('/company/{id}', 'CompanyController@show');
$router->get('/companies', 'CompanyController@index');

$router->post('/resume', 'ResumeController@store', ['auth']);

$router->get('/profile', 'ProfileController@index', ['auth']);
$router->put('/profile', 'ProfileController@update', ['auth']);


$router->get('/profile/resume', 'ProfileController@resume', ['auth']);





//admin
$router->get('/admin-panel/dashboard', 'DashboardController@index', ['auth', 'view_dashboard']);

//company
$router->get('/admin-panel/company', 'CompanyController@index', ['auth', 'view_companies']);
$router->get('/admin-panel/company/create', 'CompanyController@create', ['auth', 'create_companies' ]);
$router->post('/admin-panel/company/store', 'CompanyController@store', ['auth', 'create_companies']);

$router->get('/admin-panel/company/edit/{id}', 'CompanyController@edit', ['auth', 'edit_companies']);

$router->put('/admin-panel/company/update/{id}', 'CompanyController@update', ['auth', 'edit_companies']);
$router->delete('/admin-panel/company/delete/{id}', 'CompanyController@destroy', ['auth', 'delete_companies']);

//skill
$router->get('/admin-panel/skills', 'SkillController@index', ['auth', 'view_skills']);
$router->get('/admin-panel/skill/create', 'SkillController@create', ['auth', 'create_skills']);
$router->post('/admin-panel/skill/store', 'SkillController@store', ['auth', 'create_skills']);

$router->get('/admin-panel/skill/edit/{id}', 'SkillController@edit', ['auth', 'edit_skills']);

$router->put('/admin-panel/skill/update/{id}', 'SkillController@update', ['auth', 'edit_skills']);
$router->delete('/admin-panel/skill/delete/{id}', 'SkillController@destroy', ['auth', 'delete_skills']);

//jobs
$router->get('/admin-panel/jobs', 'JobController@index', ['auth', 'view_jobs']);
$router->get('/admin-panel/job/create', 'JobController@create', ['auth', 'create_jobs']);
$router->post('/admin-panel/job/store', 'JobController@store', ['auth', 'create_jobs']);

$router->get('/admin-panel/job/edit/{id}', 'JobController@edit', ['auth', 'edit_jobs']);

$router->put('/admin-panel/job/update/{id}', 'JobController@update', ['auth', 'edit_jobs']);
$router->delete('/admin-panel/job/delete/{id}', 'JobController@destroy', ['auth', 'delete_jobs']);


//post jobs
$router->get('/admin-panel/post_jobs', 'PostJobController@index', ['auth', 'view_post_jobs']);
$router->get('/admin-panel/post_job/create', 'PostJobController@create', ['auth', 'create_post_jobs']);
$router->post('/admin-panel/post_job/store', 'PostJobController@store', ['auth', 'create_post_jobs']);

$router->get('/admin-panel/post_job/edit/{id}', 'PostJobController@edit', ['auth', 'edit_post_jobs']);

$router->put('/admin-panel/post_job/update/{id}', 'PostJobController@update', ['auth', 'edit_post_jobs']);
$router->delete('/admin-panel/post_job/delete/{id}', 'PostJobController@destroy', ['auth', 'delete_post_jobs']);

//permission
$router->get('/admin-panel/permissions', 'PermissionController@index',['auth', 'view_permissions']);
$router->get('/admin-panel/permission/create', 'PermissionController@create', ['auth', 'create_permissions']);
$router->post('/admin-panel/permission/store', 'PermissionController@store', ['auth', 'create_permissions']);

$router->get('/admin-panel/permission/edit/{id}', 'PermissionController@edit', ['auth', 'edit_permissions']);

$router->put('/admin-panel/permission/update/{id}', 'PermissionController@update', ['auth', 'edit_permissions']);
$router->delete('/admin-panel/permission/delete/{id}', 'PermissionController@destroy', ['auth', 'delete_permissions']);

//role
$router->get('/admin-panel/roles', 'RoleController@index', ['auth', 'view_roles']);
$router->get('/admin-panel/role/create', 'RoleController@create', ['auth', 'create_roles']);
$router->post('/admin-panel/role/store', 'RoleController@store', ['auth', 'create_roles']);

$router->get('/admin-panel/role/edit/{id}', 'RoleController@edit', ['auth', 'edit_roles']);

$router->put('/admin-panel/role/update/{id}', 'RoleController@update', ['auth', 'edit_roles']);
$router->delete('/admin-panel/role/delete/{id}', 'RoleController@destroy', ['auth', 'delete_roles']);

//user
$router->get('/admin-panel/users', 'UserController@index', ['auth', 'view_users']);
$router->get('/admin-panel/user/edit/{id}', 'UserController@edit', ['auth', 'edit_users']);
$router->put('/admin-panel/user/update/{id}', 'UserController@update', ['auth', 'edit_users']);

//Resume

$router->get('/admin-panel/resumes', 'ResumeController@index', ['auth', 'view_resumes']);
$router->put('/admin-panel/resume/{id}', 'ResumeController@update', ['auth', 'edit_resumes']);

