<?php

namespace App\Http\Controllers;

use App\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classe=Auth::user()->classes()->first();
        $stuhomework=Auth::user()->stuhomeworks()->first();
        $messages=Auth::user()->messages()->count();
        $file=Auth::user()->files()->count();
        return view('admin.index',compact('classe','file','messages','stuhomework'));
    }
}
