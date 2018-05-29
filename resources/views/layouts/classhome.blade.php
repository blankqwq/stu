@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            {{$classe->name}}主页
            <small>{{ $classe->number }}人</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">{{$classe->name}}首页</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="/classhome/{{$classe->id}}/write.html" class="btn btn-primary btn-block margin-bottom">发消息</a>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">功能栏</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="@yield('gonggao')"><a href="/classhome/{{$classe->id}}/index.html"><i class="fa fa-inbox"></i>{{$classe->types->first()['category']}}公告
                                    <span class="label label-primary pull-right">1</span></a></li>
                            <li class="@yield('file')"><a href="#"><i class="fa fa-envelope-o"></i> {{$classe->types->first()['category']}}文件</a></li>
                            <li class="@yield('xuqiu')"><a href="#"><i class="fa fa-file-text-o"></i> {{$classe->types->first()['category']}}需求</a></li>
                            <li class="@yield('send')"><a href="/classhome/{{$classe->id}}/write.html"><i class="fa fa-filter"></i> 发送<span
                                            class="label label-warning pull-right">65</span></a>
                            </li>
                            <li class="@yield('upload')"><a href="#"><i class="fa fa-trash-o"></i> 上传</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @yield('home-content')
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->
@endsection