<?php

namespace App\Http\Controllers;

use App\Classes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function home(){
        //查询个人信息
        $messages=Auth::user()->messages()->paginate(15);
        //查询班级信息
        $classmessage=Auth::user()->classes()->paginate(15);
        foreach ($classmessage as $class){
            dump($class->with('messages')->get());
        }
        return view('');
    }

    public function send(){
        //选择班级或者用户，一并获取
        //这里需要选择对象
        $datas=Auth::user()->classes()->with('users','boss');
        dd($datas);
        return view('');
    }
}
