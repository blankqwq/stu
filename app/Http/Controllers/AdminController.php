<?php

namespace App\Http\Controllers;

use App\Classes;
use App\ClassType;
use App\FileSystem;
use App\Homework;
use App\Permission;
use App\Role;
use App\Tiku;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home(){
        $user_count=User::count();
        $class_count=Classes::count();
        $homework_count=Homework::count();
        $tiku_count=Tiku::count();
        return view('houtai.home',compact('tiku_count','user_count','class_count','homework_count'));
    }

    //用户管理首页
    public function userindex(){
        $users=User::with('getinfo')->paginate(15);
        $roles=Role::all();
        $permissions=Permission::all();
        return view('houtai.user.index',compact('users','roles','permissions'));
    }

    //班级管理首页
    public function classindex(){
        $classes=Classes::with('boss','homeworks')->withCount('users')->paginate(15);
//        dd($classes);
        $types=ClassType::all();
        return view('houtai.classes.index',compact('classes','types'));
    }

    //文件管理首页
    public function fileindex(){
        $files=FileSystem::paginate(15);
        dd($files);
    }

//    题库管理首页
    public function tikuindex(){
        $tikus=Tiku::paginate(15);
        dd($tikus);
    }


}
