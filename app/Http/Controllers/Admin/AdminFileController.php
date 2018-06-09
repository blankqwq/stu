<?php

namespace App\Http\Controllers\Admin;

use App\Classes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFileController extends Controller
{
    public function classinex(){
        $classes=Classes::with('boss','homeworks')->withCount('users')->paginate(15);
        return view('houtai.file.classes',compact('classes'));
    }

    public function userindex(){
        $users=User::with('getinfo')->paginate();
        return view('houtai.file.users',compact('users'));
    }

    public function classshow(){

    }

    public function usershow(){

    }

    public function destroy(Request $request){

    }
}
