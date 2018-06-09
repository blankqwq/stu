<?php

namespace App\Http\Controllers;

use App\Classes;
use App\ClassType;
use App\Http\Requests\ClassesRequest;
use App\Jobs\JoinClassMessage;
use App\Jobs\SendToClassRoleJob;
use App\Message;
use App\Role;
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
    public function me()
    {
        $classes = User::find(Auth::id())->classes()->withPivot('created_at')->with('types', 'boss')->paginate(15);;
        return view('admin.class.me', compact('classes'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取我创建的班级
     */
    public function my()
    {
        $classes = Classes::where('user_id', Auth::id())->with('types', 'boss')->paginate(15);
        return view('admin.class.my', compact('classes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取全部的班级列
     */
    public function all()
    {
        $classes = Classes::where('user_allow', '>', '0')->with('types', 'boss')->paginate(15);
        return view('admin.class.all', compact('classes'));
    }


    /**
     * 更具id进行查看详细信息
     * 获取详细信息
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $classes = Classes::with('types', 'boss')->find($id);
        if (!$classes)
            return "<h3>null</h3>";
        $types = ClassType::all();
        return view('admin.class.xiaochaung', compact('classes', 'types'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 班级查询功能
     */
    public function search(Request $request)
    {
        $classes = Classes::with('types', 'boss')->where('user_allow', '>', '0')->where('name', 'like', '%' . $request->input('name') . '%')->paginate(15);
        return view('admin.class.all', compact('classes'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取改班级中的所有成员
     */
    public function oneclass($id)
    {
        $classe = Classes::find($id);
        $users = Classes::find($id)->users()->with('getinfo', 'roles')->paginate(15);
        return view('admin.class.users', compact('users', 'classe'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 创建班级的界面
     */
    public function createindex()
    {
        $types = ClassType::all();
        return view('admin.class.create', compact('types'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 用户创建小团体地址
     */
    public function create(ClassesRequest $request)
    {
        $input = $request->only('name', 'password', 'verification');
        if ($request->hasFile('avatar')) {
            $avatar = Storage::disk('public')->putfile('upload/class', $request->file('avatar'));
            $input['avatar'] = '/storage/' . $avatar;
        }
        DB::transaction(function () use ($input, $request) {
            Classes::create([
                'name' => $input['name'],
                'avatar' => $input['avatar'],
                'password' => $input['password'],
                'verification' => $input['verification'],
                'number' => 1,
                'user_id' => Auth::id(),
            ])->types()->attach($request->input('type'));
        });

        return redirect('/classes/my');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取加入页面
     */
    public function getjoin($id)
    {
        if (Auth::user()->classes()->find($id))
            return "<script>alert('您已经加入了该团体');window.location.href='/classhome/" . $id . "/index.html'</script>";
        $classe = Classes::where('user_allow', '>=', 1)->find($id);
        return view('admin.class.join', compact('classe'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     */
    public function join($id, Request $request)
    {
        $classe = Classes::find($id);
        $input = $request->only('content');
        if (Auth::user()->classes()->find($id))
            return "<script>alert('您已经加入了,点击确定自动跳转到班级页面');window.location.href='/classhome/" . $classe->id . "/index.html'</script>";
        if (Auth::user()->notclasses()->find($id)){
            return "<script>alert('您已经发送通知了，请等待');window.location.href='/classes/me'</script>";
        }
        try {
            if ($classe->verification == 0) {
                if ($classe->password == $request->input('password')) {
                    $input['title'] = '我已加入您的' . $classe->name;
                    $a=null;
                } else {
                    return "密码错误";
                }
            } else {
                if ($classe->password == $request->input('password')) {
                    $input['title'] =Auth::user()->name.'申请加入您的' . $classe->name;
                    $a=str_random(20);
                } else {
                    return "<script>alert('密码错误');window.location.href='/join/class/" . $classe->id . "'</script>";
                }
            }
            $input['user_id'] = Auth::id();
            $input['can_reply'] = 1;
            $input['type_id'] = 4;
            $b=Auth::user()->classes()->save($classe, ['token' => $a]);
            $input['content']=$input['content']."<a href='".url('/message/request/agree?token='.$a)."'>点击该用户同意加入班级</a>";
            $message = $classe->boss()->first()->messages()->create($input);
            $this->dispatch(new SendToClassRoleJob($classe, $message));
        } catch (\Exception $exception) {
            abort('404');
        }
        return redirect('/classes/me');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取未授权的班级
     */
    public function verifyindex()
    {
        $classes = Classes::with('types', 'boss')->where('user_allow', '=', null)->orWhere('user_allow', '=', "0")->paginate(15);
        return view('admin.class.verify', compact('classes'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     * 班级审核赞同
     */
    public function agree($id, Request $request)
    {
        try {
            DB::transaction(function () use ($id, $request) {
                $classe = Classes::find($id);
                $classe->update(['user_allow' => Auth::id()]);
                $boss = User::find($classe->user_id);
                $teacher = new \App\Role();
                $teacher->name = 'class' . $classe->id;
                $teacher->display_name = $classe->name . '创建者';
                $teacher->description = '管理该班级下级学生';
                $teacher->save();
                $boss->roles()->attach($teacher);
                $boss->classes()->attach($id);
            });
        } catch (\Exception $exception) {
            return $exception;
        }
        return "1";
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     * 拒绝班级审核
     */
    public function disagree($id, Request $request)
    {
        try {
            $classe = Classes::find($id);
            $classe->update(['user_allow' => 0]);
        } catch (\Exception $exception) {
            return "0";
        }
        return "1";
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     * 删除班级中不符合要去的人
     */
    public function deleteuser($id, Request $request)
    {
//        dd($id);
        $this->validate($request, [
            'ids.*' => 'required|exists:classes,id',
        ]);
        $classe = Classes::find($id);
        $ids = $request->input('ids');
        try {
            $classe->users()->detach($ids);
        } catch (\Exception $exception) {
            return "0";
        }
        return "1";
    }

//    //删除班级在高级管理中设定
//    public function destroy($id, Request $request)
//    {
//
//    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 班级信息修改
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:10',
            'password' => 'max:6',
            'verification' => 'required|Integer|',
            'avatar' => 'image',
        ]);
        $input = $request->only('name', 'password', 'verification');
        if ($request->hasFile('avatar')) {
            $avatar = Storage::disk('public')->putfile('upload/class', $request->file('avatar'));
            $input['avatar'] = '/storage/' . $avatar;
        }
        try {
            DB::transaction(function () use ($id, $input) {
                Classes::find($id)->update($input);
            });

        } catch (\Exception $exception) {
            abort('404');
        }
        return redirect('all/classes');
    }


}
