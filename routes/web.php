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


############仅仅只需要登陆的路由
Route::group(['middleware'=>'auth'],function (){
    #___________________________文件上传
    Route::post('upload',' FunctionController@upload');

    #_____________________________用户管理___________________________
    //查看自己的资料
    Route::get('users/me','UserController@me');
    //搜索人
    Route::post('users/search','UserController@search');
    //修改自己的资料
    Route::put('users/me','UserController@store');
    //用户管理高级管理（需要权限,删除和修改）
    Route::group(['middleware'=>'permission:manage-user'],function (){
        //删除用户（’设定未高级权限‘）
        Route::delete('users/del','UserController@destroy');
        //查询用户资料
        Route::get('users/{id}','UserController@index');
        //赋予权限
        Route::put('users/{id}','UserController@update');

        Route::get('all/users','UserController@all');
    });



    #______________________班级管理__________________________________
    //查询已经加入的班级
    Route::get('classes/me','ClassController@me');

    //查询全部班级
    Route::get('classes/all','ClassController@all');

    //查询指定班级
    Route::get('classes/search','ClassController@search');

    Route::get('classes/{id}','ClassController@index');

    //加入某班级
    Route::post('classes/{id}','ClassController@join');
    //班级管理权限
    Route::group(['middleware'=>'permission:edit-classes'],function (){
        //删除班级
        Route::delete('classes','ClassController@destroy');
        //申请创建小团体or班级
        Route::post('classes','ClassController@create');
        //修改班级信息
        Route::put('classes','ClassController@update');
        //删除班级指定成员
        Route::delete('classes/{user}','ClassController@delmember');
    });

    #_________________________站内消息(发送什么的)__________________




    #_________________________即时聊天系统__________________



    #_______________________________________________黄金分割线---学生路由
    Route::group(['prefix' => 'student','middleware' => ['role:student']],function (){

        #___________作业提交，作业查询，分数统计

        #___________成绩管理

        #___________请假

        #___________任务查询(答题功能)


    });




    #_________________________________________________黄金分割线——老师路由
    Route::group(['prefix' => 'teacher','middleware' => ['role:ateacher']],function (){
        #_________作业管理

        #_________审批假条

        #_________发布答题，答题统计

    });

    #__________________________________________________黄金分割线——管理员路由
    Route::group(['prefix' => 'admin','middleware' => ['role:admin']],function (){
        #___________管理生成教师等


        #_____________高级管理

    });
});
