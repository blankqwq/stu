@extends('layouts.admin')

@section('content')

    <section class="content-header">
        <h1>
            用户管理
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">users/me</li>
        </ol>
    </section>
    <script>
        $(document).ready(function () {
            $('[id=read]').click(function () {
                htmlobj = $.ajax(
                    {

                        type: "GET",
                        url: this.href,
                        success: function () {
                            $("html,body").animate({scrollTop:0},800);
                            var data=htmlobj.responseText;
                            $('#users-content').empty();
                            $("#users-content").html(htmlobj.responseText);
                        },
                        error: function () {
                            alert('获取失败联系管理员')
                        }

                    });
                return false;
            });
        });
    </script>

    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">用户表</h3>
                        <div class="box-tools">
                            <form action="/users/search" method="post">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    {{ csrf_field() }}
                                    <input type="text" name="search" class="form-control pull-right"
                                           placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <form action="/users/del" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>email</th>
                                    <th>创建时间</th>
                                    <th>更新事件</th>
                                    <th>操作</th>
                                </tr>
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                @foreach($users as $user)
                                    <tr>
                                        <td>@if(\Illuminate\Support\Facades\Auth::id()!==$user->id)
                                                <input type="checkbox" value="{{ $user->id }}" name="ids[]">
                                            @endif</td>
                                        <td>{{ $user->getinfo->name }}</td>
                                        <td>{{ $user->getinfo->sex }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->getinfo->updated_at }}</td>
                                        <td><a href="/users/{{ $user->id }}" id="read"><span
                                                        class="label label-warning">查看</span></a>
                                            <a href="/permissions/{{ $user->id }}"><span
                                                        class="label label-success">权限</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$users)
                                    未找到任何信息
                                @endif

                            </table>

                            <div class="box-footer">
                                <button class="btn btn-google btn-sm ">删除用户</button>
                                <button onclick="$('#users-content').empty();" type="button" class="btn btn-facebook btn-sm "  data-toggle="modal" data-target="#myModal">创建用户</button>
                                <!-- 模态框（Modal） -->

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    {{ $users->links() }}
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="users-content">

            </div>
                <!-- 模态框（Modal） -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">

                        <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">修改用户资料</h4>
                                </div>
                                <div class="modal-body">

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
                                        <button type="submit" class="btn btn-primary">确认创建</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.modal -->
                </div>
        </div>



    </section>



@endsection
