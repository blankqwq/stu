<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取当前自己用户资料
     */
    public function me(){
        try{
            $user=Auth::user();
            $userinfo=$user->getinfo()->get();
        }catch (\Exception $exception){
            abort('404');
        }
        return view('admin.users',compact('user','userinfo'));
    }

    /**
     * 传说中的修改用户信息
     * @param Request $request
     * @return string
     */

    public function store(Request $request){
        try{
            DB::transaction(function () use ($request) {
                $user = User::find(Auth::id());
                $user->getinfo()->update($request);
            });
        }catch (\Exception $exception){
           abort('403');
        }
        return 'ojbk';
    }



    public function index($id){


    }

    public function destroy($id){


    }

    public function update($id){

    }
}
