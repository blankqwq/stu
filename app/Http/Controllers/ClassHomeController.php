<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Enclosure;
use App\Http\Requests\GonggaoRequest;
use App\Jobs\SendMailJobs;
use App\Message;
use App\MessageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClassHomeController extends Controller
{
    public function check(Classes $classes){
        if (!Auth::user()->classes()->wherePivot('class_id',$classes->id)->count()>0)
            abort('403');
    }

    public function index($id){
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $homecount=Classes::find($id)->homeworks()->count();
        $gongaocount=Classes::find($id)->messages()->where('type_id','1')->count();
        $xuqiucount=Classes::find($id)->messages()->where('type_id','2')->count();
        $messages=Classes::find($id)->messages()->with('sender')->where('type_id','1')->orderby('created_at','desc')->paginate(15);
        return view('admin.class.home.index',compact('classe','messages','gongaocount','xuqiucount','homecount'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取写消息界面，加入可选类型
     */
    public function write($id){
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $messages=Classes::find($id)->messages()->where('type_id','1')->paginate(15);
        $types=MessageType::all();
        $homecount=Classes::find($id)->homeworks()->count();
        $gongaocount=Classes::find($id)->messages()->where('type_id','1')->count();
        $xuqiucount=Classes::find($id)->messages()->where('type_id','2')->count();
        return view('admin.class.home.write',compact('classe','messages','types','gongaocount','xuqiucount','homecount'));
    }


    public function send($id,Request $request){
        $classe=Classes::find($id);
        $this->check($classe);
        $input=$request->only('title','content','type_id');
        $input['content']=clean($input['content']);
        $input['can_reply']=1;
        if (!$classe)
            abort('404');
        try{
            $input['user_id']=Auth::id();
            DB::transaction(function () use ($classe,$id, $input,$request) {
                $res=$this->upattachment($request);
                $input['enclosure_id']=$res;
                $message = $classe->messages()->create($input);
                $users = $classe->users()->get();
                $type=MessageType::find($input['type_id']);
                $this->dispatch(new SendMailJobs($classe, $message,$type));

            });
        }catch (\Exception $exception){
            abort('500');
        }

        return redirect("/classhome/".$classe->id."/index.html");
    }

    public function xuqiu($id){
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $messages=Classes::find($id)->messages()->where('type_id','2')->orderby('created_at','desc')->paginate(15);
        $types=MessageType::all();
        $gongaocount=Classes::find($id)->messages()->where('type_id','1')->count();
        $xuqiucount=Classes::find($id)->messages()->where('type_id','2')->count();
        $homecount=Classes::find($id)->homeworks()->count();
        return view('admin.class.home.xuqiu',compact('classe','messages','types','gongaocount','xuqiucount','homecount'));
    }


    public function read($id){
        $onemessage=Message::with('types','sender','enclosures')->find($id);
        return view('admin.class.home.read',compact('onemessage'));
    }

    public function upattachment(Request $request){
        if ($request->hasFile('attachment')){
            $ret = Storage::disk('public')->putfile('upload/attachment', $request->attachment);
            $res=Enclosure::create([
                'url'=>$ret,
                'name'=>$request->attachment->getClientOriginalName(),
                'size'=>$request->attachment->getsize()
            ]);
            return $res->id;
        }
        return null;
    }
}
