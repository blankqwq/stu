<?php

namespace App\Http\Controllers;

use App\Classes;
use App\ClassType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClassController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 查询已加入的班级
     */
    public function me(){
        $classes=User::find(Auth::id())->classes()->withPivot('created_at', 'is_join')->with('types','boss')->paginate(15);;
//        dd($classes);
        return view('admin.class.me',compact('classes'));
    }


    public function my(){
        $classes=Classes::where('user_id',Auth::id())->with('types','boss')->paginate(15);
//        dd($classes);
        return view('admin.class.my',compact('classes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取全部的班级列
     */
    public function all(){
//        dd(ClassType::all());
        $classes=Classes::where('user_allow','>','0')->with('types','boss')->paginate(15);
//        获取全部列表
//        $classes=Classes::find(1)
//        dd($classes);
        return view('admin.class.all',compact('classes'));
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
//        $input=$request->only('name');
        $classes=Classes::with('types','boss')->where('user_allow','>','0')->where('name','like','%'.$request->input('name').'%')->paginate(15);
//        dd($classes);
        return view('admin.class.all',compact('classes'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取改班级中的所有成员
     */
    public function oneclass($id){
//        dd(123);
        $users=Classes::find($id)->users()->with('getinfo','roles')->paginate(15);
        return view('admin.usersall',compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 创建班级的界面
     */
    public function createindex(){
        $types=ClassType::all();
        return view('admin.class.create',compact('types'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 用户创建小团体地址
     */
    public function create(Request $request){
        $input=$request->only('name','password','verification');
        if ($request->hasFile('avatar')){
            $avatar=Storage::disk('public')->putfile('upload/class',$request->file('avatar'));
            $input['avatar']='/storage/'.$avatar;
        }
        DB::transaction(function () use ( $input,$request) {
            Classes::create([
                'name'=>$input['name'],
                'avatar'=>$input['avatar'],
                'password'=>$input['password'],
                'verification'=>$input['verification'],
                'number'=>1,
                'user_id'=>Auth::id(),
            ])->types()->attach($request->input('type'));
        });

        return redirect('/classes/my');
    }


    //申请加入班级
    public function join($id,Request $request){


    }

    public function verifyindex(){
        $classes=Classes::with('types','boss')->where('user_allow','=',null)->orWhere('user_allow', '=', "0")->paginate(15);
//        dd($classes);
        return view('admin.class.verify',compact('classes'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     * 班级审核赞同
     */
    public function agree($id,Request $request){
        try{
            $classe=Classes::find($id);
            $classe->update(['user_allow'=>Auth::id()]);
            User::find($classe->user_id)->classes()->attach($id);
        }catch (\Exception $exception){
            return "0";
        }
        return "1";
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     * 拒绝班级审核
     */
    public function disagree($id,Request $request){
        try{
            $classe=Classes::find($id);
            $classe->update(['user_allow'=>0]);
        }catch (\Exception $exception){
            return "0";
        }
        return "1";
    }
}
