@extends('houtai.layouts.index')
@section('permissions','active')
@section('permissions-role','active')
@section('content')

    <section class="content-header">
        <h1>
            角色表
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">权限设置</li>
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
                    @include('particles.error')
                    <div class="box-header">
                        <h3 class="box-title">角色设定</h3>
                        <div class="box-tools">
                            <form action="/admin/users/search" method="post">
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
                        <form action="/admin/roles" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>name</th>
                                    <th>别名</th>
                                    <th>简介</th>
                                    <th>创建时间</th>
                                    <th>更新时间</th>
                                    <th>操作</th>
                                </tr>
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                @foreach($roles as $role)
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="{{ $role->id }}" name="ids[]"></td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->disply_name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>{{ $role->created_at }}</td>
                                        <td>{{ $role->updated_at }}</td>
                                        <td><a href="/admin/roles/{{ $role->id }}" id="read"><span
                                                        class="label label-warning">角色绑定权限</span></a>
                                            <a href=""><span
                                                        class="label label-success">删除</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$role)
                                    未找到任何信息
                                @endif

                            </table>

                            <div class="box-footer">
                                <button class="btn btn-google btn-sm " type="submit">删除角色</button>
                                <button onclick="$('#users-content').empty();" type="button"
                                        class="btn btn-facebook btn-sm " data-toggle="modal" data-target="#myModal">创建角色
                                </button>
                                <!-- 模态框（Modal） -->

                                <ul class="pagination pagination-sm no-margin pull-right">
                                    {{ $roles->links() }}
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

                    <form action="/admin/roles" method="post">
                        {{ csrf_field() }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel">创建角色</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">姓名</label>
                                    <input type="text" class="form-control" id="name" placeholder="姓名" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="display_name">别名</label>
                                    <input type="text" class="form-control" id="display_name" placeholder="display_name"
                                           name="display_name">
                                </div>

                                <div class="form-group">
                                    <label for="description">简介</label>
                                    <input type="text" class="form-control" id="description" placeholder="用途简介"
                                           name="description">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                    </button>
                                    <button type="submit" class="btn btn-primary">确认创建</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </section>



@endsection
