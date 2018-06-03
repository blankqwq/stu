<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Homework;
use App\Http\Requests\StoreHomeworkRequest;
use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function check(Classes $classes){
        if (!Auth::user()->classes()->wherePivot('class_id',$classes->id)->count()>0)
            abort('403');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 查询班级界面
     */
    public function index($id)
    {
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $gongaocount=$classe->messages()->where('type_id','1')->count();
        $homecount=$classe->homeworks()->count();
        $xuqiucount=$classe->messages()->where('type_id','2')->count();
        $homeworks = Homework::with('poster')->where('class_id', '=', $id)->withCount('stuhomeworks')->paginate(15);
//        dd($homeworks);
        return view('admin.homework.index',compact('homeworks','classe','xuqiucount','gongaocount','homecount'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 创建界面
     */
    public function create($id)
    {
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $homecount=$classe->homeworks()->count();
        $gongaocount=$classe->messages()->where('type_id','1')->count();
        $xuqiucount=$classe->messages()->where('type_id','2')->count();
        return view('admin.homework.create',compact('classe','xuqiucount','gongaocount','homecount'));
    }

    /**
     * @param StoreHomeworkRequest $request
     * @return \Illuminate\Http\RedirectResponse|string
     * 发送逻辑
     */
    public function store($id,StoreHomeworkRequest $request)
    {
        $classe=Classes::find($id);
        $this->check($classe);
        try {
            $time = $request->input('time');
            $time = explode(' - ', $time);
            $start_time = date('Y-m-d H:i:s ', strtotime($time[0]));
            $stop_time = date('Y-m-d H:i:s ', strtotime($time[1]));
            if ($start_time == $stop_time)
                $stop_time = date('Y-m-d H:i:s', strtotime($start_time . '+24 hours'));
            $data = [
                'title' => $request->input('title'),
                'content' => clean($request->input('content')),
                'start_time' => $start_time,
                'stop_time' => $stop_time,
                'class_id' => $id,
                'teacher_id'=>Auth::id(),
//                'post_num'=>0
            ];

            Homework::create($data);

        } catch (\Exception $exception) {
            return "添加失败，指定跳转";
        }
            return redirect()->route('homework.index',$id);
    }

    public function destroy($id,Request $request)
    {
//        Homework::destroy($id);
        return redirect()->route('homework.index',$id);
    }

    public function edit($id,$homework)
    {
        $classe=Classes::with('boss','types')->withCount('messages')->find($id);
        $this->check($classe);
        if (!$classe)
            abort('404');
        $gongaocount=$classe->messages()->where('type_id','1')->count();
        $xuqiucount=$classe->messages()->where('type_id','2')->count();
        $homecount=$classe->homeworks()->count();
        $homework=$classe->homeworks()->find($homework)->first();
        return view('admin.homework.edit',compact('homework','classe','xuqiucount','gongaocount','homecount'));
    }

    /**
     * @param $id
     * @param StoreHomeworkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * 更新作业
     */
    public function update($id,$homework, StoreHomeworkRequest $request)
    {
        $classe=Classes::find($id);
        $this->check($classe);
        $homework=$classe->homeworks()->find($homework);
        //这里我们需要加强验证机制，否者很容易被盗用
        $time = $request->input('time');
        $time = explode(' - ', $time);
        $start_time = date('Y-m-d H:i:s ', strtotime($time[0]));
        $stop_time = date('Y-m-d H:i:s ', strtotime($time[1]));
        try{
            if ($start_time == $stop_time)
                $stop_time = date('Y-m-d H:i:s', strtotime($start_time . '+24 hours'));
            $data = [
                'title' => $request->input('title'),
                'content' => clean($request->input('content')),
                'start_time' => $start_time,
                'stop_time' => $stop_time,
            ];
            $homework->update($data);
        }catch (\Exception $exception){
            abort('500');
        }
        return redirect()->route('homework.index',$id);
    }

    public function read($id,$homework){
        $classe=Classes::find($id);
        $this->check($classe);
        $homework=$classe->homeworks()->with('stuhomeworks')->find($homework)->first();
//        dd($homework);
        return view('admin.homework.read',compact('homework','classe'));
    }

    public function me($id){
        $classe=Classes::find($id);
        $this->check($classe);
        $homeworks=$classe->homeworks()->with('stuhomeworks','poster')->paginate(15);
        $homecount=$classe->homeworks()->count();
        $gongaocount=$classe->messages()->where('type_id','1')->count();
        $xuqiucount=$classe->messages()->where('type_id','2')->count();
        return view('admin.homework.me',compact('homeworks','classe','xuqiucount','gongaocount','homecount'));


    }

    public function correct($id,$homework){
        $classe=Classes::find($id);
        $this->check($classe);
        $homecount=$classe->homeworks()->count();
        $gongaocount=$classe->messages()->where('type_id','1')->count();
        $xuqiucount=$classe->messages()->where('type_id','2')->count();
        $stuhomeworks=$classe->homeworks()->find($id)->stuhomeworks()->with('homeworks')->paginate(15);
//        dd($stuhomeworks);
        return view('admin.homework.correct',compact('stuhomeworks','classe','xuqiucount','gongaocount','homecount'));
    }

    public function correcthome($id,$homework,$stuhomework){
        $classe=Classes::find($id);
        $this->check($classe);
        $stuhomework=$classe->homeworks()->find($homework)->stuhomeworks()->find($stuhomework);
        return view('admin.homework.xiaochaung',compact('stuhomework','classe'));
    }

    public function correctgive($id,$homework,$stuhomework,Request $request){
        $classe=Classes::find($id);
        $this->check($classe);
        $stuhomework=$classe->homeworks()->find($homework)->stuhomeworks()->where('id',$stuhomework);
        $stuhomework->update(['fraction'=>$request->input('fraction')]);
        return redirect('classhome/'.$id.'/homework/correct/'.$homework);

    }






}
