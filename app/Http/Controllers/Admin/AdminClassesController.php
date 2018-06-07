<?php

namespace App\Http\Controllers\Admin;

use App\Classes;
use App\ClassType;
use App\Http\Requests\StoreClassAdminRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminClassesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClassAdminRequest $request)
    {
        $input = $request->only('name', 'password', 'verification');
        if ($request->hasFile('avatar')) {
            $avatar = Storage::disk('public')->putfile('upload/class', $request->file('avatar'));
            $input['avatar'] = '/storage/' . $avatar;
        }
        DB::transaction(function () use ($input, $request) {
            $classe = Classes::create([
                'name' => $input['name'],
                'avatar' => $input['avatar'],
                'password' => $input['password'],
                'verification' => $input['verification'],
                'user_allow' => Auth::id(),
                'number' => 1,
                'user_id' => Auth::id(),
            ]);
            $classe->types()->attach($request->input('type'));
            $teacher = new \App\Role();
            $teacher->name = 'class' . $classe->id;
            $teacher->display_name = $classe->name . '创建者';
            $teacher->description = '管理该班级下级学生';
            $teacher->save();
            Auth::user()->roles()->attach($teacher);
            Auth::user()->classes()->attach($classe);
        });

        return redirect('/admin/classes/index.html');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classes = Classes::with('boss')->find($id);
        return view('houtai.classes.show', compact('classes'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        return redirect('admin/classes/index.html');
    }

    public function trash(){
        $classes=Classes::with('boss','homeworks')->withCount('users')->onlyTrashed()->paginate(15);
//        dd($classes);
        $types=ClassType::all();
        return view('houtai.classes.trash',compact('classes','types'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'ids.*' => 'required|exists:classes,id',
        ]);
        $ids = $request->input('ids');
//        try{
        foreach ($ids as $id) {
            $classe = Classes::find($id);
            if ($classe) {
//                $classe->users()->pivot()->delete();
                try {
                    $classe->delete();
                } catch (\Exception $exception) {
                }
                if ( Role::where('name', 'class' . $classe->id)->first())
                    Role::where('name', 'class' . $classe->id)->first()->delete();
                $delid[] = $id;
            }
        }
        return redirect('/admin/classes/index.html');
    }

    public function restore(Request $request){
        $this->validate($request, [
            'ids.*' => 'required|exists:classes,id',
        ]);
        $ids = $request->input('ids');
//        try{
        foreach ($ids as $id) {
            $classe = Classes::onlyTrashed()->find($id);
            if ($classe) {
                try {
                    $classe->restore();
                } catch (\Exception $exception) {
                }
            }
        }
        return redirect('/admin/classes/index.html');
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
}
