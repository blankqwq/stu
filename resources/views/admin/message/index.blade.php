@extends('layouts.admin')
@section('message','active')
@section('message-noread','active')
@section('content')
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
                            $('#xiangqing').empty();
                            $("#xiangqing").html(htmlobj.responseText);
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
                        <h3 class="box-title">收件箱表</h3>
                        <div class="box-tools">
                            <form action="" method="post">
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
                        <form action="/message/destroy" method="post">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>标题</th>
                                    <th>内容</th>
                                    <th>发送人</th>
                                    <th>发送时间</th>
                                </tr>
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                @forelse($messages as $message)
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="{{ $message->id }}" name="ids[]">
                                        </td>
                                        <td>{{ $message->title }}</td>
                                        <td>{!!  mb_substr(strip_tags($message->content),0,30) !!}</td>
                                        <td>{{ $message->sender->email }} 【{{ $message->sender->getinfo->first()->name }}】</td>
                                        <td>{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</td>

                                        <td><a href="/message/{{$message->id}}.html" id="read"><span
                                                        class="label label-warning">查看详情</span></a>
                                        <a href="/message" id="read"><span
                                                        class="label label-default">回复</span></a>
                                        </td>
                                    </tr>

                                @empty
                                    <tr> 暂无消息</tr>
                                @endforelse
                            </table>

                            <div class="box-footer">
                                <button class="btn btn-google btn-sm ">放入到回收站</button>
                                <button class="btn btn-github btn-sm " onclick="this.form.action='/message/read';">已读</button>
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    {{ $messages->links() }}
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="xiangqing">

            </div>

        </div>


    </section>


@endsection