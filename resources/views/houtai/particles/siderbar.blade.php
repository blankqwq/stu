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
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>控制面板</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="/admin/home.html"><i class="fa fa-circle-o"></i> 首页</a></li>
                    {{--<li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>--}}
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>作业管理</span>
                    <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> 全部作业</a></li>
                    <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> 作业查询</a></li>
                    <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> 发布作业</a></li>
                    <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i>  </a></li>
                </ul>
            </li>
            <li>
                <a href="pages/widgets.html">
                    <i class="fa fa-th"></i> <span>在线聊天系统管理</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>班级管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/classes/number"><i class="fa fa-circle-o"></i>创建班级</a></li>
                    <li><a href="/classes/create"><i class="fa fa-circle-o"></i> 班级审核</a></li>
                    <li><a href="/all/classes"><i class="fa fa-circle-o"></i> 全部班级</a></li>
                    {{--<li><a href="/classes/verify"><i class="fa fa-circle-o"></i> 审批班级</a></li>--}}
                    {{--<li><a href="/classes/my"><i class="fa fa-circle-o"></i> 我创建的班级</a></li>--}}
                    {{--<li><a href="/classes/me"><i class="fa fa-circle-o"></i> 我加入的班级</a></li>--}}
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>用户管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/users/search"><i class="fa fa-circle-o"></i> 用户搜索</a></li>
                    <li><a href="/users/me"><i class="fa fa-circle-o"></i> 我的信息</a></li>
                    <li><a href="/all/users"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                    <li><a href="/all/users"><i class="fa fa-circle-o"></i> 用户回收站</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span>权限设定</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/message/index.html"><i class="fa fa-circle-o"></i> 创建权限</a></li>
                    <li><a href="/message/receive.html"><i class="fa fa-circle-o"></i> 权限管理</a></li>
                    <li><a href="/message/send.html"><i class="fa fa-circle-o"></i> 分配权限</a></li>
                    <li><a href="/message/trash.html"><i class="fa fa-circle-o"></i> 权限回收站</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i> <span>题库管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> 创建题库</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> 题库管理</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> 用户分数</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> 系统管理</a></li>
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
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>文件管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> 班级文件管理</a></li>
                    <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> 用户文件管理</a></li>
                </ul>
            </li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>