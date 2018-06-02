@extends('layouts.classhome')
@section('gonggao','active')
@section('home-content')
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
                            $('#home-content').empty();
                            $("#home-content").html(htmlobj.responseText);
                        },
                        error: function () {
                            alert('获取失败联系管理员')
                        }

                    });
                return false;
            });
        });
    </script>

    <div class="col-md-9" id="home-content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$classe->types->first()['category']}}公告</h3>

                <div class="box-tools pull-right">
                    <div class="has-feedback">
                        <input type="text" class="form-control input-sm" placeholder="Search ">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i>
                        </button>

                    </div>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>

                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>标题</th>
                            <th>内容预览</th>
                            <th>发送人</th>
                            <th>创建时间</th>
                        </tr>
                        @forelse ($messages as $message)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="mailbox-subject"><b><a href="/classhome/{{$message->id}}/read.html"
                                                                  id="read">{{$message->title}}</a></b></td>
                                <td class="mailbox-name"> {!!  mb_substr(strip_tags($message->content),0,30) !!} </td>
                                <td class="mailbox-attachment">{{ $message->sender->email }}</td>
                                <td class="mailbox-date">{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td>暂无公告</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
                        {{$messages->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /. box -->
    </div>
@endsection