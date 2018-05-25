<div class="box">
    <script>
        $(document).ready(function () {
            $('[id=read]').click(function () {
                htmlobj = $.ajax(
                    {

                        type: "GET",
                        url: this.href,
                        success: function () {
                            $("html,body").animate({scrollTop:0},800);
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
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{ $classes->avatar }}"
             alt="未找到图片">
        <h3 class="profile-username text-center">班级名:{{ $classes->name }}</h3>
        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>创建时间：</b> <a class="pull-right">{{ $classes->created_at }}</a>
            </li>
            <li class="list-group-item">
                <b>创建者</b> <a class="pull-right" href="/users/{{ $classes->boss->id }}" id="read">{{ $classes->boss->email }}</a>
            </li>

            <li class="list-group-item">
                <b>审核人</b> <a class="pull-right" href="/users/{{ $classes->boss->id }}">
                    @if(\App\User::find($classes->userallow))
                        {{ \App\User::find($classes->userallow)->getinfo()->name }}
                @endif</a>
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
                <b>是否需要密码</b> <a class="pull-right">
                    @if($classes->verification!=0)
                        需要
                    @else
                        不需要
                    @endif</a>
            </li>
            <li class="list-group-item">
                <b>加入班级</b> <a class="pull-right" href="/join/{{ $classes->id }}">点击申请</a>
            </li>
        </ul>
        @if(\Illuminate\Support\Facades\Auth::id() === $classes->boss->id or \Illuminate\Support\Facades\Auth::user()->can('manage-class'))
            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">修改班级资料
            </button>
            <!-- 模态框（Modal） -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">

                    <form action="" method="post" enctype="multipart/form-data">
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