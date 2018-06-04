<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function checkrole($classrole){
        if (!DB::table('role_user')->where('role_id',$classrole->id)->first()->user_id===Auth::id())
            abort('403');
    }
//    权限管理控制器，普通用户当然只能管理本班级的权限，并且为自己的班级成员提升权限
    public function giveclass($class,$id){
//        给予班级管理员权限
        $classrole=Role::where('name','class'.$class)->first();
//        dd(User::find($id)->hasRole('class'.$class));
        if (User::find($id)->hasRole('class'.$class)){
            return "<script>alert('该用户已经为管理员了');window.location.href='/class/$class'</script>";
        }else{
            $this->checkrole($classrole);
            $user=User::find($id)->roles()->attach($classrole);
        }

    }

    public function delclass($class,$id){
        //删除班级权限

    }
}
