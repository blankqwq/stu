@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            班级详情表
            <small>操作界面</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">仪表盘</li>
        </ol>
    </section>

    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            <div class="box">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ $classes->avatar }}"
                         alt="未找到图片">
                    <h3 class="profile-username text-center">name:{{ $classes->name }}</h3>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>创建时间：</b> <a class="pull-right">{{ $classes->name }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>创建者</b> <a class="pull-right" href="/users/{{ $classes->boss->id }}">{{ $classes->boss->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>类型</b>
                            @foreach($classes->types as $type)

                                <a class="pull-right"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$type->category}}</a>
                            @endforeach
                        </li>
                        <li class="list-group-item">
                            <b>是否需要密码</b> <a class="pull-right">
                                @if($classes->password)
                                            需要
                                    @else
                                    不需要
                            @endif</a>
                        </li>
                        <li class="list-group-item">
                            <b>是否需要认证</b> <a class="pull-right">
                                @if($classe->verification==0)
                                    需要
                                    @else
                                    不需要
                            @endif</a>
                        </li>
                        <li class="list-group-item">
                            <b>加入班级</b> <a class="pull-right">点击申请加入</a>
                        </li>
                    </ul>
                    @if(\Illuminate\Support\Facades\Auth::id() === $classes->boss->id or \Illuminate\Support\Facades\Auth::user()->can('manage-class'))
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">修改班级资料
                        </button>
                        <!-- 模态框（Modal） -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">

                                <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">--}}
                                    {{--&times;--}}
                                    {{--</button>--}}
                                    {{--<h4 class="modal-title" id="myModalLabel">修改用户资料</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body">--}}

                                    {{--<div class="form-group">--}}
                                    {{--<div class="col-xs-12 text-center">--}}
                                    {{--<img src="{{ $user_info->avatar }}" id="avatarImg"--}}
                                    {{--class="profile-user-img img-responsive img-circle"/>--}}
                                    {{--<input type="file" name="avatar" id="pic" class="center-block"/>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                    {{--<label for="name">姓名</label>--}}
                                    {{--<input type="text" class="form-control" id="name" placeholder="姓名" name="name"--}}
                                    {{--value="{{ $user_info->name }}">--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                    {{--<label for="sign">个性签名</label>--}}
                                    {{--<input type="text" class="form-control" id="sign" placeholder="个性签名" name="sign"--}}
                                    {{--value="{{ $user_info->sign }}">--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                    {{--<label for="exampleInputPassword1">老密码</label>--}}
                                    {{--<input type="password" class="form-control" id="exampleInputPassword1" name="old_password"--}}
                                    {{--placeholder="Password">--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                    {{--<label for="exampleInputPassword1">新密码</label>--}}
                                    {{--<input type="password" class="form-control" id="exampleInputPassword1" name="new_password"--}}
                                    {{--placeholder="Password">--}}
                                    {{--</div>--}}
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                        </button>
                                        <button type="submit" class="btn btn-primary">提交更改</button>
                                    </div>
                                </form>
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</form>--}}
                                @endif
                            </div><!-- /.modal -->
                        </div>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </section>
@endsection