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
                    <i class="fa fa-dashboard"></i> <span>控制面板</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@yield('zhu-menu-home')"><a href="/admin/home.html"><i class="fa fa-circle-o"></i> 首页</a></li>
                    {{--<li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>--}}
                </ul>
            </li>
            {{--<li class="treeview @yield('homework')">--}}
                {{--<a href="#">--}}
                    {{--<i class="fa fa-files-o"></i>--}}
                    {{--<span>作业管理</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<span class="label label-primary pull-right">4</span>--}}
            {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li class="@yield('homework-all')"><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> 全部作业</a></li>--}}
                    {{--<li class="@yield('homework-search')"><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> 作业查询</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <li>
                <a href="pages/widgets.html">
                    <i class="fa fa-th"></i> <span>在线聊天系统管理</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
                </a>
            </li>
            <li class="treeview @yield('classes')">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>班级管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    {{--<li class="@yield('classes-create')"><a href="/classes/number"><i class="fa fa-circle-o"></i>创建班级</a></li>--}}
                    <li class="@yield('classes-shenhe')"><a href="/admin/classes/"><i class="fa fa-circle-o"></i> 班级审核</a></li>
                    <li class="@yield('classes-all')"><a href="/admin/classes/index.html"><i class="fa fa-circle-o"></i> 全部班级</a></li>
                    <li class="@yield('classes-classtype')"><a href="/admin/classtype"><i class="fa fa-circle-o"></i> 班级类型</a></li>
                    <li class="@yield('classes-trash')"><a href="/admin/classes/trash"><i class="fa fa-circle-o"></i> 班级回收站</a></li>


                    {{--<li><a href="/classes/verify"><i class="fa fa-circle-o"></i> 审批班级</a></li>--}}
                    {{--<li><a href="/classes/my"><i class="fa fa-circle-o"></i> 我创建的班级</a></li>--}}
                    {{--<li><a href="/classes/me"><i class="fa fa-circle-o"></i> 我加入的班级</a></li>--}}
                </ul>
            </li>
            <li class="treeview @yield('users')">
                <a href="/admin/users/index.html">
                    <i class="fa fa-laptop"></i>
                    <span>用户管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@yield('users-search')"><a href="/admin/users/search"><i class="fa fa-circle-o"></i> 用户搜索</a></li>
                    <li class="@yield('users-all')"><a href="/admin/users/index.html"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                    <li class="@yield('users-trash')"><a href="/admin/users/trash"><i class="fa fa-circle-o"></i> 用户回收站</a></li>

                </ul>
            </li>
            <li class="treeview @yield('permissions')">
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span>权限设定</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@yield('permissions-index')"><a href="/admin/permissions"><i class="fa fa-circle-o"></i> 权限管理</a></li>
                    <li class="@yield('permissions-role')"><a href="/admin/roles"><i class="fa fa-circle-o"></i> 角色管理</a></li>
                </ul>
            </li>
            <li class="treeview @yield('messages')">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>消息管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@yield('messages-send')"><a href="/admin/messages/create"><i class="fa fa-circle-o"></i> 消息发送</a></li>
                    <li class="@yield('messages-all')"><a href="/admin/messages"><i class="fa fa-circle-o"></i> 消息目录</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>答题管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> 创建题库</a></li>
                    <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> 发布任务</a></li>
                    <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> 题目导入</a></li>
                    <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> 回收站</a></li>
                </ul>
            </li>
            {{--<li>--}}
                {{--<a href="pages/calendar.html">--}}
                    {{--<i class="fa fa-calendar"></i> <span>日历</span>--}}
                    {{--<span class="pull-right-container">--}}
              {{--<small class="label pull-right bg-red">3</small>--}}
              {{--<small class="label pull-right bg-blue">17</small>--}}
            {{--</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="treeview @yield('files')">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>文件管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu ">
                    <li class=" @yield('files-classes')"><a href="/admin/classfile"><i class="fa fa-circle-o"></i> 班级文件管理</a></li>
                    <li class=" @yield('files-users')"><a href="/admin/userfile"><i class="fa fa-circle-o"></i> 用户文件管理</a></li>
                </ul>
            </li>
            <li class="header">主页</li>
            <li><a href="/home"><i class="fa fa-circle-o text-red"></i> <span>返回</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>