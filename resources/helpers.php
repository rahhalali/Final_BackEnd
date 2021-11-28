<?php

use App\Models\Employee_Position;


if(!function_exists('hasRole')){
    function hasRole($roleName){
        $role=Employee_Position::where('name',$roleName)->first();
        if($role){
            if(auth('user')->user()->employee_positions_id == $role->id){
                return true;
            }
        }
        return false;
    }

}
