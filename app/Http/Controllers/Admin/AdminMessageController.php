<?php

namespace App\Http\Controllers\Admin;

use App\Enclosure;
use App\Jobs\SendAllUsersMessage;
use App\Mail\RequestJoinClass;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages=Message::withTrashed()->paginate(15);
        return view('houtai.message.index',compact('messages'));
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas=User::with('getinfo')->get();
        return view('houtai.message.send',compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->only('title','content');
        $input['content']=clean($input['content']);
        $input['can_reply']=1;
        $input['type_id']=3;
            $ids=$request->ids;
        try{
            DB::transaction(function () use ($ids, $input,$request) {
                $res=$this->upattachment($request);
                $input['enclosure_id']=$res;
                $input['user_id']=Auth::id();
                $this->dispatch(new SendAllUsersMessage($ids, $input));
            });
        }catch (\Exception $exception){
            abort('500');
        }
        return redirect('/admin/messages');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $onemessage=Message::withTrashed()->with('sender')->find($id);
        return view('houtai.message.xiaochaung',compact('onemessage'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
