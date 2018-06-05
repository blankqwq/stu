<!DOCTYPE html>
<html>
@include('houtai.particles.head')
<body class="@yield('bar','hold-transition skin-blue sidebar-mini')">
<div class="wrapper">
    @include('houtai.particles.header')

    @include('houtai.particles.siderbar')

    <div class="content-wrapper">
        @section('content')
            <section class="content-header">
                <h1>
                    控制面板
                    <small>控制条</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/admin/home.html"><i class="fa fa-dashboard"></i>AdminHome</a></li>
                    <li class="active">控制面板</li>
                </ol>
            </section>

            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{$class_count}}<sup style="font-size: 20px">个</sup></h3>

                                <p>班级</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">班级管理<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$homework_count}}<sup style="font-size: 20px">份</sup></h3>

                                <p>作业</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">作业查看 <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{$user_count}}</h3>

                                <p>用户数量</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">用户管理 <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{$tiku_count}}</h3>

                                <p>题库</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">题库管理 <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>


            </section>
    </div>
    @show
    {{--</div>--}}

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.1.1
        </div>
        <strong>Copyright &copy; 2018 <a href="/">blank</a></strong>
    </footer>
    @include('houtai.particles.hsider')
    <div class="control-sidebar-bg"></div>
</div>


@include('houtai.particles.js')

</body>
</html>