<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function login(Request $request){

    }

    public function loginindex(){
        return view('auth.login');
    }

    public function register(Request $request){
//        try{
//            dd($request->all());
            DB::transaction(function () use ($request) {
                $user = User::insertGetId(
                [
                    'email' => $request['email'],
                    'password' => bcrypt($request['password']),
                ]);
                $user=User::find($user);
                dd( $user->getinfo()->create([
                    'name' => $request->input('name'),
                    'sex' => $request['sex'],
                ]));
                $user->getinfo()->create([
                    'name' => $request->input('name'),
                    'sex' => $request['sex'],
                ]);
                // 绑定用户为学生权限
                $user->attachRole(4);
            });

    }
    //
}
