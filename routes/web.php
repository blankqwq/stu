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
Route::get('/testmail',function (){
    $user
});
//Route::post('/register', 'AuthController@register')->name('register');
Route::get('/1', function () {
    \Illuminate\Support\Facades\Auth::user()->delete();
});

############仅仅只需要登陆的路由
Route::group(['middleware' => 'auth'], function () {
    #___________________________文件上传___________
    Route::post('editor_upload', 'FunctionController@upload');

    #_____________________________用户管理___________________________

    //用户管理高级管理（需要权限,删除和修改）


    //查看自己的资料
    Route::get('users/me', 'UserController@me');
    //搜索人
    Route::post('users/search', 'UserController@search');
    //搜索人界面
    Route::get('users/search', 'UserController@searchindex');
    //修改自己的资料
    Route::put('users/me', 'UserController@store');

    //查询用户资料
    Route::get('users/{id}', 'UserController@index');

    Route::group(['middleware' => 'permission:manage-user'], function () {
        //更新资料
        Route::put('users/{id}', 'UserController@update');
        //删除用户（’设定未高级权限‘）
        Route::delete('users/del', 'UserController@destroy');

        //获取全部用户资料
        Route::get('all/users', 'UserController@all');
    });


    #______________________班级管理__________________________________
    Route::group(['middleware' => 'permission:manage-class'], function () {
        //加入某班级
        Route::get('classes/verify', 'ClassController@verifyindex');
        //审核
        Route::post('agree/classes/{id}', 'ClassController@agree');
        Route::post('disagree/classes/{id}', 'ClassController@disagree');
        //删除班级
    });

    //    获取班级成员
    Route::get('class/{id}', 'ClassController@oneclass');

    //查询已经加入的班级
    Route::get('classes/me', 'ClassController@me');
    Route::get('classes/my', 'ClassController@my');

    //查询全部班级
    Route::get('all/classes', 'ClassController@all');

    //查询指定班级
    Route::post('classes/search', 'ClassController@search');

    //创建班级界面
    Route::get('classes/create', 'ClassController@createindex');

    //创建班级
    Route::post('classes/create', 'ClassController@create');

    //获取班级详情
    Route::get('classes/{id}', 'ClassController@index');

//    加入班级
    Route::get('join/class/{id}', 'ClassController@getjoin');
    Route::post('join/class/{id}', 'ClassController@join');

    //加入某班级
    Route::post('classes/{id}', 'ClassController@join');


    //班级主页
    Route::get('classhome/{id}', 'ClassController@classhome');

    //修改班级信息
    Route::put('classes/{id}', 'ClassController@update');
    //班级管理权限
    Route::group(['middleware' => 'permission:edit-class'], function () {
        //删除班级
        Route::delete('classes', 'ClassController@destroy');
        //申请创建小团体or班级
        Route::post('classes', 'ClassController@create');
        //删除班级指定成员
        Route::delete('classes/deluser/{id}', 'ClassController@deleteuser');
    });

    #_________________________站内消息(发送什么的)__________________

    Route::group([], function () {
        //默认收件箱页面
        Route::get('message/index.html', 'MessageController@homeuser');

        Route::get('message/receive.html', 'MessageController@homereceive');
        Route::get('message/trash.html', 'MessageController@trash');
        //发送消息的界面
        Route::get('message/send.html', 'MessageController@sendhome');
        Route::get('message/outbox.html', 'MessageController@outhome');
        Route::get('message/{id}.html', 'MessageController@xiangqing');
        //发送消息

        Route::post('message/send', 'MessageController@send');
        //删除操作
        Route::post('message/destroy', 'MessageController@destroy');
        //恢复操作
        Route::delete('message/restore', 'MessageController@restore');
        //设置已读
        Route::delete('message/read', 'MessageController@isread');
        //设置未读
        Route::delete('message/noread', 'MessageController@noread');

        //消息的回复
        Route::post('message/reply', 'MessageController@reply');

        //动态获取一些信息
        Route::get('message/getshixing', 'MessageController@getshixing');
        //动态获取班级中的需求什么的，自动获取追后一个
        Route::get('message/banji', 'MessageController@getbanji');
        //动态获取申请的信息，
        Route::get('message/shengqing', 'MessageController@getshengqing');


        //获取信息详情
        Route::get('message/{id}', 'MessageController@index');
        //撤回消息
        Route::post('message/{id}/del');

        //获取班级申请信息然后就直接选择同意or不同意
        //1.点击token即可同意加入，我们在消息处加上一个这种连接即可,,可是全体都得改一下了
        Route::get('message/request/agree', 'MessageController@agreerequest');
        //点击即同意或者不同意
        Route::get('message/request/{id}', 'MessageController@getrequest');

    });

    #_________________ClassHome班级主页交作业
    Route::group(['middleware'], function () {
//
        Route::get('classhome/{id}/index.html', 'ClassHomeController@index');

        Route::get('classhome/{id}/write.html', 'ClassHomeController@write');

        Route::post('classhome/{id}', 'ClassHomeController@send');
        Route::get('classhome/{id}/read.html', 'ClassHomeController@read');
        Route::get('classhome/{id}/request.html', 'ClassHomeController@xuqiu');


        Route::get('classhome/{id}/homework/index.html', 'HomeworkController@index')->name('homework.index');
        Route::get('classhome/{id}/homework/me.html', 'HomeworkController@me');
        Route::get('classhome/{id}/homework/create.html', 'HomeworkController@create');

//        ___________________________
        Route::get('classhome/{id}/homework/create.html', 'HomeworkController@create');

        Route::post('classhome/{id}/homework/store', 'HomeworkController@store');

        Route::get('classhome/{id}/homework/{homework}', 'HomeworkController@read');

        Route::get('classhome/{id}/homework/edit/{homework}', 'HomeworkController@edit');

        Route::get('classhome/{id}/homework/correct/{homework}', 'HomeworkController@correct');

        Route::post('classhome/{id}/homework/{homework}', 'StuHomeworkController@post');


        Route::get('classhome/{id}/homework/correct/{homework}/{stuhomework}', 'HomeworkController@correcthome');

        Route::post('classhome/{id}/homework/correct/{homework}/{stuhomework}', 'HomeworkController@correctgive');

        Route::put('classhome/{id}/homework/{homework}', 'HomeworkController@update');

        Route::delete('classhome/{id}/homework/{homework}', 'HomeworkController@destroy');

        Route::get('classhome/{id}/file.html', 'ClassHomeFileController@index');
        Route::get('classhome/{id}/file/{file}', 'ClassHomeFileController@show');
        //创建
        Route::post('classhome/{id}/filesystem/folder/{file}','ClassHomeFileController@storefolder');
        Route::post('classhome/{id}/filesystem/file/{file}','ClassHomeFileController@storefile');
        //删除
        Route::delete('classhome/{id}/filesystem/del','ClassHomeFileController@destroy');

//        查询已交作业


    });

    Route::group([], function () {
        Route::get('permissions/{class}/{id}', 'PermissionController@giveclass');
    });

    #_________________________即时聊天系统__________________




    #______________________文件系统
    Route::delete('filesystem/del','FileSystemController@destroy');
    Route::resource('filesystem', 'FileSystemController',
        array('only' => array('index','show',)));
    Route::post('filesystem/new/folder/{id}','FileSystemController@storefolder');
    Route::post('filesystem/update/file/{id}','FileSystemController@storefile');
    Route::get('classfile','FileSystemController@classfile');

//    答题系统
    Route::resource('A','DatiController');

    #_______________________________________________黄金分割线---学生路由
    Route::group(['prefix' => 'student', 'middleware' => ['role:student']], function () {

        //        提交作业模块

        #___________成绩管理

        #___________请假

        #___________任务查询(答题功能)


    });


    #_________________________________________________黄金分割线——老师路由
    Route::group(['prefix' => 'teacher', 'middleware' => ['role:ateacher']], function () {
        #_________作业管理

        #_________审批假条

        #_________发布答题，答题统计

    });

    #__________________________________________________黄金分割线——管理员路由
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|owner']], function () {
        Route::get('home.html', 'AdminController@home');

//        各种管理界面的首页路由
        //user
        Route::get('users/index.html', 'AdminController@userindex');
        //class
        Route::get('classes/index.html', 'AdminController@classindex');
        //permission
        Route::get('permissions/index.html', 'AdminController@permissionindex');
        //tiku
        Route::get('tikus/index.html', 'AdminController@tikuindex');
        //file
        Route::get('files/index.html', 'AdminController@fileindex');
        //开始控制器走一波,
        Route::group(['namespace' => 'Admin'], function () {
//            ______用户管理_______
            Route::get('users/trash', 'AdminUsersController@trash');
            Route::get('users/search', 'AdminUsersController@search');
            Route::post('users/search', 'AdminUsersController@searchto');
            Route::post('users/restore', 'AdminUsersController@restore');
            Route::resource('users', 'AdminUsersController',
                array('only' => array('show', 'update', 'store')));
            Route::delete('users/del', 'AdminUsersController@destroy');
            Route::delete('users/restore', 'AdminUsersController@destroy');

//差一个用户搜索


//            _______班级管理_________
            Route::post('classes/restore', 'AdminClassesController@restore');
            Route::get('classes/trash', 'AdminClassesController@trash');

            Route::resource('classes', 'AdminClassesController',
                array('only' => array('show', 'update', 'store')));
            Route::delete('classes/del', 'AdminClassesController@destroy');

            Route::get('classtype/trash', 'AdminClassTypeController@trash');
            Route::delete('classtype/restore', 'AdminClassTypeController@restore');

            Route::resource('classtype', 'AdminClassTypeController',
                array('only' => array('show', 'update', 'store', 'index')));
            Route::delete('classtype/del', 'AdminClassTypeController@destroy');


//            __________权限管理_______

            Route::resource('permissions', 'AdminPermissionController',
                array('only' => array('show', 'update', 'store', 'index')));
            Route::resource('roles', 'AdminRoleController',
                array('only' => array('show', 'update', 'store', 'index')));

//            ________题库管理_________


//            _______文件管理______

            Route::get('userfile','AdminFileController@userindex');
            Route::get('classfile','AdminFileController@classinex');

            Route::get('userfile/{id}','AdminFileController@usershow');
            Route::get('classfile/{id}','AdminFileController@classshow');

            Route::delete('userfile','AdminFileController@userdestroy');
            Route::delete('classfile','AdminFileController@classdestroy');
//            消息管理
            Route::resource('messages', 'AdminMessageController',
                array('only' => array('show', 'store', 'index','create')));
            //删除
            Route::delete('messages', 'AdminMessageController@destroy');

//            #作业管理


        });


    });
});
