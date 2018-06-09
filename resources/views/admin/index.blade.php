@extends('layouts.admin')
@section('zhu-menu','active')
@section('zhu-menu-home','active')

@section('content')


    <section class="content-header">
        <h1>
            仪表盘
            <small>控制面板</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>
            <li class="active">仪表盘</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            @if($classe)
                                {{$classe->name}}
                            @else
                                0
                            @endif</h3>

                        <p>最近加入的班级</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="/classes/me" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>@if($stuhomework)
                            {{$stuhomework->fraction}}
                                @else
                                0
                                @endif<sup style="font-size: 20px">%</sup></h3>

                        <p>分数</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$file}}</h3>

                        <p>文件数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="/filesystem" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$messages}}</h3>

                        <p>消息数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="/message/index.html" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>

    </section>
            <!-- right col -->


@endsection