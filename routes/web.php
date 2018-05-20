<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::post('/register', 'AuthController@register')->name('register');

Route::group(['middleware'=>'auth'],function (){
    ############仅仅只需要登陆的路由
    Route::get('users/me','UserController@me');
    Route::get('users/{id}','UserController@index');
    Route::post('users/me','UserController@store');



    ###########黄金分割线---学生路由
    Route::group(['prefix' => 'student','middleware' => ['role:student']],function (){

    });




    ###########黄金分割线——老师路由
    Route::group(['prefix' => 'teacher','middleware' => ['role:ateacher']],function (){
        Route::delete('users/{id}','UserController@destroy');
        Route::put('users/{id}','UserController@update');


    });

    ###########黄金分割线——管理员路由
    Route::group(['prefix' => 'admin','middleware' => ['role:admin']],function (){

    });
});
