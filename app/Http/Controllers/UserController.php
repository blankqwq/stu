<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取当前自己用户资料
     */
    public function me()
    {
        try {
            $user = Auth::user();
            $userinfo = $user->getinfo()->get();
        } catch (\Exception $exception) {
            abort('404');
        }
        return view('admin.users', compact('user', 'userinfo'));
    }

    /**
     * 传说中的修改用户信息
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::find(Auth::id());
                $user->getinfo()->update($request);
            });
        } catch (\Exception $exception) {
            abort('403');
        }
        return 'ojbk';
    }


    public function index($id)
    {
        $user = User::find($id);
        $userinfo = $user->getinfo()->get();
        return view('admin.users', compact('user', 'userinfo'));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user)
            Session::flash('message', '未找到传说中的用户');
        $user->delete();
        if ($user->trashed()) {
            return response()->json('删除成功');
        }
    }


    /***
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
//        更新资料
        DB::transaction(function () use ($id, $request) {
            $userinfo = User::find($id)->getinfo()->update($request);
        });
        return redirect("users/$id");
    }
}
