<?php

namespace App\Http\Controllers;

use App\Classes;
use App\ClassType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 查询已加入的班级
     */
    public function me(){
        $classes=Auth::user()->classes()->withPivot('created_at', 'is_join')->with('types')->get();
        dd($classes);
        return view('admin.classes',compact('classes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取全部的班级列
     */
    public function all(){
//        dd(ClassType::all());
        $classes=Classes::all();
//        获取全部列表
//        $classes=Classes::find(1)
        dd($classes);
        return view('admin.classes');
    }


    /**
     * 更具id进行查看详细信息
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id){
        $classes=Classes::find($id);
        dd($classes);
        return view('admin.classes');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 班级查询功能
     */
    public function search(Request $request){
        $input=$request->only('name');
        $classes=Classes::with('types')->where('name','%'.$input.'%');
        return view('admin.classes');
    }
    //
}
