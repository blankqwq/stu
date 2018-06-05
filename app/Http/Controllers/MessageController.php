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
        $messages = Auth::user()->messages()->with('senderinfo')->where('is_read',1)->where('type_id','>','2')->paginate(15);
        return view('admin.message.receive',compact('messages'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 查询个人私人短信
     */
    public function homeuser()
    {
        $messages = Auth::user()->messages()->with('senderinfo')->where('is_read',null)->where('type_id','>','2')->paginate(15);
        return view('admin.message.index',compact('messages'));
    }


    //已发送的查询
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
        $datas = Auth::user()->classes()->with('users','getallusers', 'boss')->get();
        return view('admin.message.send',compact('datas'));
    }

    //加入回收站操作
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


    //回复回收站内容
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
        return redirect('/message/outbox.html');


    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function getshixing(){
        $message=Auth::user()->messages()->with('senderinfo')->where('is_read',null)->where('type_id','3');
        $messages=$message->get();
        $message_number=$message->count();
//        dd($messages);
        return view('admin.message.shixing',compact('messages','message_number'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getshengqing(){
        $message=Auth::user()->messages()->with('senderinfo')->where('is_read',null)->where('type_id','4');
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

    public function agreerequest(Request $request){
        $input=$request->only('token');
        $data=DB::table('user_classes')->where('token',$input['token']);
        if (!$data->first())
            return "<script>alert('未找到加入信息');window.location.href='/message/index.html'</script>";
        if (Auth::user()->hasRole('class'.$data->first()->class_id)){
            $bbc=$data->first();
            $data->update(['token'=>null]);
//            这里来一条短信
            $input=[
                'user_id'=>Auth::id(),
                'title'=>Auth::user()->getinfo()->first()->name,
                'content'=>'我已经同意您加入我的班级，'."<a href='/classhome/".$bbc->class_id."/index.html'> 点击进入主页</a>",
                'type_id'=>3,
                'can_reply'=>0
            ];
//            dd($input);
            $user=User::find($bbc->user_id);
            $message=User::find($bbc->user_id)->messages()->create($input);
            $this->dispatch(new JoinClassMessage($user, $message));
            return "<script>alert('同意成功');window.location.href='/message/index.html'</script>";
        }else{
            return "<script>alert('没有权限');window.location.href='/home'</script>";
        }
    }

    //这是一个回复函数，当然只能回复别人发送给我的信息，查询回复，只需要我们加入一个with
    public function reply(){

    }

//    已读操作
    public function isread(Request $request){
        $this->validate($request, [
            'ids.*' => 'required|exists:messages,id',
        ]);
        $ids=$request->input('ids');

        foreach ($ids as $id){
            $message =User::find(Auth::id())->messages()->where('is_read',null)->where('id',$id);
            if ($message){
                //修改为已1读
                $message->update(['is_read'=>1]);
            }
        }
        return redirect('/message/index.html');
    }

    //修改为未读
    public function noread(Request $request){
        $this->validate($request, [
            'ids.*' => 'required|exists:messages,id',
        ]);
        $ids=$request->input('ids');

        foreach ($ids as $id){
            $message =User::find(Auth::id())->messages()->where('is_read',1)->where('id',$id);
            if ($message){
                //修改为已1读
                $message->update(['is_read'=>null]);
            }
        }
        return redirect('/message/index.html');
    }

//    查询回收站
    public function trash(){
        $messages = Auth::user()->messages()->onlyTrashed()->with('senderinfo')->where('type_id','>','2')->paginate(15);
        return view('admin.message.trash',compact('messages'));

    }
}
