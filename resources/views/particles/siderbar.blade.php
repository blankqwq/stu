<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $userinfo->avatar  }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $userinfo->name  }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i>{{ $userinfo->sign  }} </a>
            </div>
        </div>
        <!-- search form -->
        {{--//搜索框--}}
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主菜单</li>
            <li class=" treeview @yield('zhu-menu')">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>仪表盘</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@yield('zhu-menu-home')"><a href="/home"><i class="fa fa-circle-o"></i> 首页</a></li>
                    {{--<li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>--}}
                </ul>
            </li>
            {{--<li class="treeview @yield('homework')">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-files-o"></i>--}}
                    {{--<span>作业系统</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<span class="label label-primary pull-right">4</span>--}}
            {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>--}}
                    {{--<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>--}}
                    {{--<li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>--}}
                    {{--<li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <li>
                <a href="pages/widgets.html">
                    <i class="fa fa-th"></i> <span>在线聊天系统</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
                </a>
            </li>
            <li class="treeview @yield('classes')">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>班级系统</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    {{--<li><a href="/classes/number"><i class="fa fa-circle-o"></i>班级内务</a></li>--}}
                    <li class="@yield('classes-create')"><a href="/classes/create"><i class="fa fa-circle-o"></i> 创建班级</a></li>
                    <li class="@yield('classes-all')"><a href="/all/classes"><i class="fa fa-circle-o"></i> 全部班级</a></li>
                    <li class="@yield('classes-shenpi')"><a href="/classes/verify"><i class="fa fa-circle-o"></i> 审批班级</a></li>
                    <li class="@yield('classes-mycreate')"><a href="/classes/my"><i class="fa fa-circle-o"></i> 我创建的班级</a></li>
                    <li class="@yield('classes-myjoin')"><a href="/classes/me"><i class="fa fa-circle-o"></i> 我加入的班级</a></li>
                </ul>
            </li>
            <li class="treeview @yield('users')">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>用户管理系统</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@yield('users-search')"><a href="/users/search"><i class="fa fa-circle-o"></i> 用户搜索</a></li>
                    <li class="@yield('users-me')"><a href="/users/me"><i class="fa fa-circle-o"></i> 我的信息</a></li>
                    @permission('manage-user')
                    <li class="@yield('users-manage')"><a href="/all/users"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                    @endpermission
                </ul>
            </li>
            <li class="treeview @yield('message')">
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span>私信系统</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class=" @yield('message-noread')"><a href="/message/index.html"><i class="fa fa-circle-o"></i> 未读消息</a></li>
                    <li class=" @yield('message-read')"><a href="/message/receive.html"><i class="fa fa-circle-o"></i> 已读消息</a></li>
                    <li class=" @yield('message-post')"><a href="/message/send.html"><i class="fa fa-circle-o"></i> 发布消息</a></li>
                    <li class=" @yield('message-posted')"><a href="/message/outbox.html"><i class="fa fa-circle-o"></i> 已发布</a></li>

                    <li class=" @yield('message-trash')"><a href="/message/trash.html"><i class="fa fa-circle-o"></i> 消息回收站</a></li>

                </ul>
            </li>
            {{--<li class="treeview">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-edit"></i> <span>问答系统</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> 在线提问</a></li>--}}
                    {{--<li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> 问题列表</a></li>--}}
                    {{--<li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> 系统管理</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>答题系统</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> 最近任务</a></li>
                    <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> 在线测试</a></li>
                    <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> 答题管理</a></li>
                    <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> 发布答题</a></li>
                </ul>
            </li>
            <li>
                <a href="pages/calendar.html">
                    <i class="fa fa-calendar"></i> <span>日历</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
                </a>
            </li>

            <li class="treeview  @yield('files')">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>文件管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@yield('files-class')"><a href="/classfile"><i class="fa fa-circle-o"></i> 班级文件</a></li>
                    <li class="@yield('files-me')"><a href="/filesystem"><i class="fa fa-circle-o"></i> 我的文件</a></li>
                </ul>
            </li>

            <li class="header">LABELS</li>
            @ability('admin,owner','')
            <li><a href="/admin/home.html"><i class="fa fa-circle-o text-red"></i> <span>后台管理</span></a></li>
            @endability
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
</aside>