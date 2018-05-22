<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FunctionController extends Controller
{

    public function upload(Request $request){
//        dd($request->file('avatar'));
        return 1;
//        return $request->file('avatar');
//        $avatar=Storage::disk('public')->putfile('upload',$request->file('avatar'));
////        dd($avatar);
//        return $avatar;

    }
}
