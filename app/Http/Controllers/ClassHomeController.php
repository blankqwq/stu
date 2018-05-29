<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Http\Requests\GonggaoRequest;
use App\MessageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassHomeController extends Controller
{
    public function index($id){
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        if (!$classe)
            abort('404');
        $messages=Classes::find($id)->messages()->where('type_id','1')->paginate(15);
        return view('admin.class.home.index',compact('classe','messages'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取写消息界面，加入可选类型
     */
    public function write($id){
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        if (!$classe)
            abort('404');
        $messages=Classes::find($id)->messages()->where('type_id','1')->paginate(15);
        $types=MessageType::all();
        return view('admin.class.home.write',compact('classe','messages','types'));
    }


    public function send($id,Request $request){
        $input=$request->only('title','content','type_id');
//        dd($input);
        if ($request->hasFile('attachment')){
            $ret = Storage::disk('public')->putfile('upload/attachment', $request->attachment);
        }
        $input['content']=clean($input['content']);
        $classe=Classes::find($id);
        if (!$classe)
            abort('404');
        try{
            $input['user_id']=Auth::id();
            DB::transaction(function () use ($classe, $input) {
                $classe->messages()->create($input);
            });
        }catch (\Exception $exception){
            abort('500');
        }
        return redirect("/classhome/".$classe->id."/index.html");
    }

    public function xuqiu($id){
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        if (!$classe)
            abort('404');
        $messages=Classes::find($id)->messages()->where('type_id','1')->paginate(15);
        $types=MessageType::all();
        return view('admin.class.home.write',compact('classe','messages','types'));
    }

}
