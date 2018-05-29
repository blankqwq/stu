<?php

namespace App\Http\Controllers;

use App\Classes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 班级内部短信
     */
    public function homeclass()
    {
        $classmessage = Auth::user()->classes()->paginate(15);
        foreach ($classmessage as $class) {
            dump($class->with('messages')->get());
        }
        return view('');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 查询个人私人短信
     */
    public function homeuser()
    {
        $messages = Auth::user()->messages()->paginate(15);
        return view('');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 发送界面
     */
    public function send()
    {
        //选择班级或者用户，一并获取
        //这里需要选择对象
        $datas = Auth::user()->classes()->with('users', 'boss');
        dd($datas);
        return view('');
    }
}
