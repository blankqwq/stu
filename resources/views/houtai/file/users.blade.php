@extends('houtai.layouts.index')
@section('files','active')
@section('files-users','active')
@section('content')

    <section class="content-header">
        <h1>
            用户个人文件
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
                    @include('particles.error')
                    <div class="box-header">
                        <h3 class="box-title">用户表</h3>
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
                        <form action="/admin/users/del" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>email</th>
                                    <th>创建时间</th>
                                    {{--<th>角色</th>--}}
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
                                        <td><a href="/admin/users/file/{{ $user->id }}"><span
                                                        class="label label-warning">文件查看</span></a>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$users)
                                    未找到任何信息
                                @endif

                            </table>

                            <div class="box-footer">

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

        </div>


    </section>



@endsection
