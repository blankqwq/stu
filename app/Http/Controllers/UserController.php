<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Http\Requests\UserInfoRequest;
use App\User;
use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取当前自己用户资料
     */
    public function me()
    {
        try {
            $users = Auth::user();
            $user_info = $users->getinfo()->first();
        } catch (\Exception $exception) {
            abort('404');
        }
//        dd(compact('user', 'userinfo'));
//        dd($user_info);
        return view('admin.users', compact('users', 'user_info'));
    }

    /**
     * 传说中的修改用户信息
     * @param Request $request
     * @return string
     */
    public function store(UserInfoRequest $request)
    {
        $input=$request->only('name','password','sign');
        if ($request->hasFile('avatar')){
            $avatar=Storage::disk('public')->putfile('upload/user',$request->file('avatar'));
            $input['avatar']='/storage/'.$avatar;
        }
//        dd($request->file('avatar'));
//        $avatar=Storage::disk('public')->putfile('upload',$request->file('avatar'));
//        dd($input);
        try {
            DB::transaction(function () use ($input) {
                $user = User::find(Auth::id());
                $user->getinfo()->update($input);
            });
        } catch (\Exception $exception) {
            abort('403');
        }
        //刷新缓存
        Cache::forget('userinfo'.Auth::id());
        return redirect('users/me');
    }


    /**
     * 查询用户
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $users = User::find($id);
        if (!$users)
            abort('404');

        $user_info = $users->getinfo()->first();
//        dd(compact('user', 'userinfo'));
        return view('admin.user.manage', compact('users', 'user_info'));

    }

    /**
     * 删除用户
     * @param $id
     * @return \Illuminate\Http\JsonResponse
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
        return redirect('/all/users');
    }


    /***
     * 更新用户资料
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UserInfoRequest $request)
    {

        $input=$request->only('name','password','sign');
        if ($request->hasFile('avatar')){
            $avatar=Storage::disk('public')->putfile('upload/user',$request->file('avatar'));
            $input['avatar']='/storage/'.$avatar;
        }
        if (!User::find($id))
            return abort('404');
        DB::transaction(function () use ($id, $input) {
            $userinfo = User::find($id)->getinfo()->update($input);
        });
        Cache::forget('userinfo'.$id);
        return redirect('/all/users');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 根据用户姓名查询用户
     */
    public function search(Request $request){
        $this->validate($request, [
            'ids' => 'required|',
        ]);
        $users=User::with('getinfo','roles')->where('email','like','%'.$request->input('search').'%')->paginate(15);
        return view('admin.usersall',compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取全部的数据
     */
    public function all(){
//        dd(123);
        $users=User::with('getinfo','roles')->paginate(15);
        return view('admin.usersall',compact('users'));
    }

    public function searchindex(){
        return view('admin.user.search');
    }


}
