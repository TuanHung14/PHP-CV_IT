<?php

namespace App\Controllers\admin;

class BaseController{
    public function checkRole($user = null, $role = []){
        if($user && in_array($user['role_name'],  $role)){
            return true;
        }
        return false;

    }
}