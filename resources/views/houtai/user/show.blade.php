<div class="box">
    <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{ $user->getinfo->avatar }}"
             alt="User profile picture">

        <h3 class="profile-username text-center">姓名：{{ $user->getinfo->name }}</h3>

        <p class="text-muted text-center">个性签名：{{ $user->getinfo->sign }}</p>

        <p class="text-muted text-center">性别：{{ $user->getinfo->sex }}</p>

        <p class="text-muted text-center">邮箱地址：{{ $user->email }}</p>

        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>最高分</b> <a class="pull-right">{{ $user->stuhomeworks->max('fraction ')}}</a>
            </li>
            <li class="list-group-item">
                <b>最近加入的班级</b> <a class="pull-right">@if($user->classes->last())
                        {{$user->classes->last()->name}}
                    @else
                        暂无
                    @endif</a>
            </li>
            <li class="list-group-item">
                <b>Friends</b> <a class="pull-right">13,287</a>
            </li>
        </ul>
        @ability('admin,owner', 'manager-user')
        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">修改资料</button>
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">

                <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">修改用户资料</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <img src="{{ $user->getinfo->avatar }}" id="avatarImg"
                                         class="profile-user-img img-responsive img-circle"/>
                                    <input type="file" name="avatar" id="pic" class="center-block"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">姓名</label>
                                <input type="text" class="form-control" id="name" placeholder="姓名" name="name"
                                       value="{{ $user->getinfo->name }}">
                            </div>
                            <div class="form-group">
                                <label for="sign">个性签名</label>
                                <input type="text" class="form-control" id="sign" placeholder="个性签名" name="sign"
                                       value="{{ $user->getinfo->sign }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">新密码</label>
                                <input type="password" class="form-control" id="exampleInputPassword1"
                                       name="new_password"
                                       placeholder="Password">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                </button>
                                <button type="submit" class="btn btn-primary">提交更改</button>
                            </div>
                        </div>
                    </div>
                </form>
                @endability
            </div><!-- /.modal -->
        </div>

    </div>
    <!-- /.box-body -->
</div>