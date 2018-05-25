<?php

namespace App\Http\Controllers;

use App\Classes;
use App\ClassType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 查询已加入的班级
     */
    public function me(){
        $classes=User::find(Auth::id())->classes()->withPivot('created_at', 'is_join')->with('types','boss')->get();
//        dd($classes);
        return view('admin.class.me',compact('classes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取全部的班级列
     */
    public function all(){
//        dd(ClassType::all());
        $classes=Classes::with('types')->withPivot('created_at', 'is_join')->paginate(15);
//        获取全部列表
//        $classes=Classes::find(1)
        dd($classes);
        return view('admin.class.me',compact('classes'));
    }


    /**
     * 更具id进行查看详细信息
     * 获取详细信息
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id){
        $classes=Classes::with('types','boss')->find($id);
        if(!$classes)
            return "<h3>null</h3>";
        return view('admin.class.xiaochaung',compact('classes'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 班级查询功能
     */
    public function search(Request $request){
        $input=$request->only('name');
        $classes=Classes::with('types')->where('name','%'.$input.'%')->paginate(15);
        return view('admin.classes');
    }
    //
}
