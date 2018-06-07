@extends('houtai.layouts.index')

@section('classes','active')
@section('classes-all','active')
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
                            $('#class-content').empty();
                            $("#class-content").html(htmlobj.responseText);
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
                        <h3 class="box-title">全部班级</h3>
                        <div class="box-tools">
                            <form action="/classes/search" method="post">
                                <div class="input-group input-group-sm" style="width: 150px;">

                                    {{ csrf_field() }}
                                    <input type="text" name="name" class="form-control pull-right"
                                           placeholder="班级名">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <form action="/admin/classes/del" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>班级名</th>
                                    <th>类型</th>
                                    <th>创建时间</th>
                                    <th>班级人数</th>
                                    <th>班级bossemail</th>
                                    <th>操作</th>
                                </tr>
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                @foreach($classes as $classe)
                                    <tr>
                                        <td>
                                                <input type="checkbox" value="{{ $classe->id }}" name="ids[]">
                                           </td>
                                        <td>{{ $classe->name }}</td>
                                        <td>
                                            @foreach($classe->types as $type)
                                                {{ $type->category }}
                                            @endforeach</td>
                                        <td>{{ $classe->created_at }}</td>
                                        <td>{{ $classe->number }}</td>
                                        <td>{{$classe->boss->email }}</td>
                                        <td><a href="/admin/classes/{{ $classe->id }}" id="read"><span
                                                        class="label label-warning">查看</span></a>
                                            <a href="/class/{{ $classe->id }}"><span
                                                        class="label label-success">成员查看</span>
                                            </a>
                                            <a href="/classhome/{{$classe->id}}/index.html"><span
                                                        class="label label-success">班级首页</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$classes)
                                    未加入任何班级
                                @endif

                            </table>

                            <div class="box-footer">
                                <button class="btn btn-google btn-sm ">删除</button>
                                <button onclick="$('#class-content').empty();" type="button"
                                        class="btn btn-facebook btn-sm " data-toggle="modal" data-target="#myModal">创建班级
                                </button>
                                {{ $classes->links() }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="class-content">

            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">

                <form action="/admin/classes" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">创建用户</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <label>班级图片</label>
                                    <input type="file" name="avatar" id="pic" class="center-block"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>班级名</label>
                                <input type="text" class="form-control" name="name" placeholder="班级名称">
                            </div>
                            <div class="form-group">
                                <label>加入密码</label>
                                <input type="text" class="form-control" name="password" placeholder="需要则写入，不需要就不用写">
                            </div>
                            <div class="form-group">
                                <label>是否需要认证：</label>
                                <label class="radio-inline">
                                    <input type="radio" name="verification"  id="inlineRadio1" value="1"> 是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="verification"  id="inlineRadio2"  value="0"> 否
                                </label>
                            </div>
                            <div class="form-group">
                                <label>选择班级类型</label>
                                <select class="form-control" name="type">
                                    <option>请选择班级</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->category }}</option>
                                    @endforeach

                                </select>
                            </div>
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


    </section>


@endsection
