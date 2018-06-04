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
                            $("html,body").animate({scrollTop: 0}, 800);
                            var data = htmlobj.responseText;
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
                        <h3 class="box-title">{{$classe->name}}班级用户表</h3>
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
                        <form action="/classes/deluser/{{$classe->id}}" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>email</th>
                                    <th>创建时间</th>
                                    <th>角色</th>
                                    <th>更新事件</th>
                                    <th>操作</th>
                                </tr>
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            @if(\Illuminate\Support\Facades\Auth::id()!==$user->id)
                                                <input type="checkbox" value="{{ $user->id }}" name="ids[]">
                                            @endif</td>
                                        <td>{{ $user->getinfo->name }}</td>
                                        <td>{{ $user->getinfo->sex }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <?php $i = 0?>
                                            @foreach($user->roles as $role)
                                                <?php
                                                $i++;?>
                                                @if($i>2)
                                                    @break
                                                @endif
                                                <span class="label label-success">{{ $role->display_name }}</span>
                                            @endforeach</td>
                                        <td>{{ $user->getinfo->updated_at }}</td>
                                        <td><a href="/users/{{ $user->id }}" id="read"><span
                                                        class="label label-warning">查看</span></a>
                                            <a href="/permissions/{{$classe->id}}/{{ $user->id }}"><span
                                                        class="label label-success">设置身份</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$users)
                                    未找到任何信息
                                @endif

                            </table>

                            <div class="box-footer">
                                <button class="btn btn-google btn-sm ">从班级中删除</button>
                                <button onclick="$('#users-content').empty();" type="button"
                                        class="btn btn-facebook btn-sm " data-toggle="modal" data-target="#myModal">邀请
                                </button>
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

        </div>


    </section>



@endsection
