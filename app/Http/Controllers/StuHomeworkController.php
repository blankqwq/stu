<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Homework;
use App\Http\Requests\StoreStuhomeworkRequest;
use App\StuHomework;
use App\User;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StuHomeworkController extends Controller
{
    //这里写提交分数的模式

    public function check(Classes $classes)
    {
        if (!Auth::user()->classes()->wherePivot('class_id', $classes->id)->count() > 0)
            abort('403');
    }

    public function index()
    {

    }

    public function post($id, $homework, StoreStuhomeworkRequest $request)
    {
        $classe = Classes::find($id);
        $this->check($classe);
        try {
            $homework = $classe->homeworks()->find($homework);
            if (!$homework){
                abort('404');
            }
            $input = $request->only('content');
            $input['attachment'] = $this->upload($request);
            $input['user_id'] = Auth::id();
            $input['homework_id']=$homework->id;
            User::find($homework->user_id)->messages()->create([
               'content'=>'您收到一份作业，请批改',
               'title'=>Auth::user()->getinfo()->name.'提交了一份作业<'.$homework->title.'>',
            ]);
            $stuhomework=StuHomework::create($input);
        }catch (\Exception $exception){
            abort('500');
        }
        return "提交成功";
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('attachment')) {
            $file = $request->attachment;
            $filename=Auth::user()->getinfo()->first()->name.date("Y/m/d").$file->getClientOriginalName();
            $res = Storage::disk('qiniu')->put($filename, file_get_contents($file->getRealPath()));
            if ($res){
                $ret=Storage::disk('qiniu')->downloadUrl($filename)->setDownload($filename);
                return $ret->geturl();
            }else{
                abort('500');
            }
        }
        return "";
    }
}
