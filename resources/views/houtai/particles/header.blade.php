<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
        <span class="logo-mini"><b>STU后台</b></span>
        <span class="logo-lg"><b>STU后台管理</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu" id="shixing">

                </li>
                <li class="dropdown notifications-menu" id="banji">

                </li>
                <li class="dropdown tasks-menu" id="shengqing">

                </li>
                <li class="dropdown user user-menu">
                    <a href="/users/me" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ $userinfo->avatar  }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ $userinfo->name  }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ $userinfo->avatar  }}" class="img-circle" alt="User Image">

                            <p>
                                {{ $userinfo->name  }}
                                <small>{{ $userinfo->sign }}</small>
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="/users/me">信息</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="/classes/me">班级</a>
                                </div>
                            </div>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>

</header>