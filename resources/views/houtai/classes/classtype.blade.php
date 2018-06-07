@extends('houtai.layouts.index')
@section('classes','active')
@section('classes-classtype','active')

@section('content')
    <section class="content-header">
        <h1>
            用户管理
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">classtype</li>
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
                        <h3 class="box-title">班级分类列表</h3>
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
                        <form action="/admin/classtype/del" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>类型名</th>
                                    <th>创建时间</th>
                                    <th>更新时间</th>
                                    <th>操作</th>
                                </tr>
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                @forelse($classtypes as $classtype)
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="{{ $classtype->id }}" name="ids[]">
                                        </td>

                                        <td>{{ $classtype->category }}</td>
                                        <td>{{ $classtype->created_at }}</td>
                                        <td>{{ $classtype->updated_at }}</td>
                                        <td><a href="/admin/classtype/{{ $classtype->id }}" id="read"><span
                                                        class="label label-warning">查看</span></a></td>
                                    </tr>
                                @empty
                                    无类型，创建一个
                                @endforelse
                            </table>

                            <div class="box-footer">
                                <button class="btn btn-google btn-sm " type="submit">删除</button>
                                <button class="btn btn-github btn-sm " type="submit" onclick="this.form.action='/admin/classtype/restore'">恢复</button>
                                <button onclick="$('#class-content').empty();" type="button"
                                        class="btn btn-facebook btn-sm " data-toggle="modal" data-target="#myModal">创建类型
                                </button>
                                {{ $classtypes->links() }}
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

                <form action="/admin/classtype" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">创建类型</h4>
                        </div>
                        <div class="modal-body">


                            <div class="form-group">
                                <label>类型名</label>
                                <input type="text" class="form-control" name="category" placeholder="类型名">
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
