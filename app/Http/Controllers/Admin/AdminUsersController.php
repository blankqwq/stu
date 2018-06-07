<?php

namespace App\Http\Controllers\Admin;

use App\Classes;
use App\Http\Requests\StoreUserAdminRequest;
use App\Permission;
use App\Role;
use App\User;
use App\UserInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminUsersController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('');
    }

    /**
     * Store a newly created resource in storage.
     *也就是创建操作
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAdminRequest $request)
    {
        $userinfo=$request->only('name','sign','sex');
        $user=$request->only('email','password');
        if ($request->hasFile('avatar')){
            $avatar=Storage::disk('public')->putfile('upload/user',$request->file('avatar'));
            $userinfo['avatar']='/storage/'.$avatar;
        }
        $roles=$request->roles;
        $permissions=$request->permissions;
        $user['password']=bcrypt($user['password']);
        try{
            DB::transaction(function () use ($user,$userinfo,$roles,$permissions){
                $new_user = User::create($user);
                $new_info = $new_user->getinfo()->create($userinfo);
                $new_user->roles()->attach($roles);
            });
        }catch (\Exception $exception){
            dd(123);
        }
        return redirect('/admin/users/index.html');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * 与编辑可以二者合一
     */
    public function show($id)
    {
        $user=User::with('getinfo','classes','stuhomeworks')->find($id);
        return view('houtai.user.show',compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input=$request->only('name','sign');
        if ($request->hasFile('avatar')){
            $avatar=Storage::disk('public')->putfile('upload/user',$request->file('avatar'));
            $input['avatar']='/storage/'.$avatar;
        }
        try{
            User::find($id)->update(['password'=>bcrypt($request->input('password'))]);
            $user=User::find($id)->getinfo();
            $user->update($input);
        }catch (\Exception $exception){
            return "出错了";
        }
        return "ok";

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'ids.*' => 'required|exists:users,id',
        ]);
        $ids=$request->input('ids');
        foreach ($ids as $id){
            $user = User::find($id);
            if ($user){
                $user->delete();
                $delid[]=$id;
            }
        }
        return redirect('/admin/users/index.html');
    }

    public function trash(){
        $users=User::onlyTrashed()->with('getinfo')->paginate(15);
        return view('houtai.user.trash',compact('users','roles','permissions'));
    }

    public function restore(Request $request){
        $this->validate($request, [
            'ids.*' => 'required|exists:users,id',
        ]);
        $ids=$request->input('ids');
        foreach ($ids as $id){
            $user = User::onlyTrashed()->find($id);
            if ($user){
                $user->restore();
            }
        }
        return redirect('/admin/users/index.html');
    }
}
