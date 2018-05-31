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
    #___________________________文件上传___________
    Route::post('editor_upload','FunctionController@upload');

    #_____________________________用户管理___________________________

    //用户管理高级管理（需要权限,删除和修改）


    //查看自己的资料
    Route::get('users/me','UserController@me');
    //搜索人
    Route::post('users/search','UserController@search');
    //搜索人界面
    Route::get('users/search','UserController@searchindex');
    //修改自己的资料
    Route::put('users/me','UserController@store');

    //查询用户资料
    Route::get('users/{id}','UserController@index');

    Route::group(['middleware'=>'permission:manage-user'],function (){
        //更新资料
        Route::put('users/{id}','UserController@update');
        //删除用户（’设定未高级权限‘）
        Route::delete('users/del','UserController@destroy');

        //获取全部用户资料
        Route::get('all/users','UserController@all');
    });



    #______________________班级管理__________________________________
    Route::group(['middleware'=>'permission:manage-class'],function (){
        //加入某班级
        Route::get('classes/verify','ClassController@verifyindex');
        //审核
        Route::post('agree/classes/{id}','ClassController@agree');
        Route::post('disagree/classes/{id}','ClassController@disagree');
        //删除班级

    });

    //    获取班级成员
    Route::get('class/{id}','ClassController@oneclass');

    //查询已经加入的班级
    Route::get('classes/me','ClassController@me');
    Route::get('classes/my','ClassController@my');

    //查询全部班级
    Route::get('all/classes','ClassController@all');

    //查询指定班级
    Route::post('classes/search','ClassController@search');

    //创建班级界面
    Route::get('classes/create','ClassController@createindex');

    //创建班级
    Route::post('classes/create','ClassController@create');

    //获取班级详情
    Route::get('classes/{id}','ClassController@index');

//    加入班级
    Route::get('join/class/{id}','ClassController@getjoin');
    Route::post('join/class/{id}','ClassController@join');

    //加入某班级
    Route::post('classes/{id}','ClassController@join');


    //班级主页
    Route::get('classhome/{id}','ClassController@classhome');

    //修改班级信息
    Route::put('classes/{id}','ClassController@update');
    //班级管理权限
    Route::group(['middleware'=>'permission:edit-class'],function (){
        //删除班级
        Route::delete('classes','ClassController@destroy');
        //申请创建小团体or班级
        Route::post('classes','ClassController@create');
        //删除班级指定成员
        Route::delete('classes/deluser/{id}','ClassController@deleteuser');
    });

    #_________________________站内消息(发送什么的)__________________
    Route::get('test',function (){
        $user=\App\Classes::find(1)->messages()->create(['title'=>'你好','type_id'=>1,'content'=>'哈哈哈','user_id'=>\Illuminate\Support\Facades\Auth::id()]);
        dd($user);
    });

    Route::group([],function (){
        //默认收件箱页面
        Route::get('message/user','MessageController@homeuser');
        //默认班级收件箱
        Route::get('message/class','MessageController@homeclass');
        //发送消息的界面
        Route::get('message/send','MessageController@send');
        //发送消息
            //发送用户
        Route::post('message/send/user/{id}','MessageController@senduser');
            //发送班级
        Route::post('message/send/class/{id}','MessageController@sendclass');
            //发送全体（队列系统）
        Route::post('message/send/all','MessageController@sendall');

        //查看消息
        Route::get('get/message','MessageController@getmessage');
        //获取信息详情
        Route::get('message/{id}','MessageController@index');
        //设置已读
        Route::post('message/{id}/read');
        //设置未读
        Route::post('message/{id}/read');
        //消息管理___管理员的大本营
    });

    #_________________ClassHome班级主页

    Route::group([],function (){
        Route::get('classhome/{id}/index.html','ClassHomeController@index');

        Route::get('classhome/{id}/write.html','ClassHomeController@write');

        Route::post('classhome/{id}','ClassHomeController@send');
        Route::get('classhome/{id}/read.html','ClassHomeController@read');
        Route::get('classhome/{id}/request.html','ClassHomeController@xuqiu');
    });




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
