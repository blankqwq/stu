<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Enclosure;
use App\Http\Requests\SendshixingRequest;
use App\Jobs\JoinClassMessage;
use App\Jobs\SendMailJobs;
use App\Message;
use App\MessageType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 班级内部短信
     */
    public function homereceive()
    {
        $messages = Auth::user()->messages()->onlyTrashed()->with('senderinfo')->where('type_id','3')->paginate(15);
        return view('admin.message.receive',compact('messages'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 查询个人私人短信
     */
    public function homeuser()
    {
        $messages = Auth::user()->messages()->with('senderinfo')->where('type_id','3')->paginate(15);
        return view('admin.message.index',compact('messages'));
    }


    public function outhome(){
        $messages = Message::withTrashed()->where('user_id',Auth::id())->paginate(15);
        return view('admin.message.outbox',compact('messages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 发送私信
     */
    public function sendhome()
    {
        //选择班级或者用户，一并获取
        //这里需要选择对象
        $datas = Auth::user()->classes()->with('users','getallusers', 'boss')->get();
//        dd($datas);
        return view('admin.message.send',compact('datas'));
    }

    //已读操作
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'ids.*' => 'required|exists:messages,id',
        ]);
        $ids=$request->input('ids');
        foreach ($ids as $id){
            $message = Message::find($id);
            if ($message){
                $message->delete();
            }
        }
        return redirect('/message/index.html');
    }


    public function restore(Request $request)
    {
        $this->validate($request, [
            'ids.*' => 'required|exists:messages,id',
        ]);
        $ids=$request->input('ids');
        foreach ($ids as $id){
            $message = Message::withTrashed()->find($id);
            if ($message){
                $message->restore();
            }
        }
        return redirect('/message/index.html');
    }


    public function send(SendshixingRequest $request){
        $input=$request->only('title','content');
        $input['content']=clean($input['content']);
        $input['can_reply']=1;
        $input['type_id']=3;
        $user=User::find($request->userid);
        try{
            $input['user_id']=Auth::id();
            DB::transaction(function () use ($user, $input,$request) {
                $res=$this->upattachment($request);
                $input['enclosure_id']=$res;
                $message = $user->messages()->create($input);
                $type=MessageType::find($input['type_id']);
                $this->dispatch(new JoinClassMessage($user, $message,$type));
            });
        }catch (\Exception $exception){
            abort('500');
        }
        redirect('/message/outbox.html');


    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function getshixing(){
        $message=Auth::user()->messages()->with('senderinfo')->where('type_id','3');
        $messages=$message->get();
        $message_number=$message->count();
//        dd($messages);
        return view('admin.message.shixing',compact('messages','message_number'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getshengqing(){
        $message=Auth::user()->messages()->with('senderinfo')->where('type_id','4');
        $messages=$message->get();
        $message_number=$message->count();
//        dd($messages);
        return view('admin.message.shengqing',compact('messages','message_number'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getbanji(){
        $message=Auth::user()->classes()->with('messages');
        $messages=$message->get();
        $message_number=$message->count();
//        dd($messages);
//        return "1";
        return view('admin.message.banji',compact('messages','message_number'));
    }

    /**
     * @param Request $request
     * @return null
     */
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


    public function xiangqing($id){
        $onemessage=Message::withTrashed()->with('sender')->find($id);
        return view('admin.message.xiangqing',compact('onemessage'));
    }
}
