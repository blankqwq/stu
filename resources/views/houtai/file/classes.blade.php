@extends('layouts.admin')

@section('files','active')
@section('files-class','active')
@section('content')
    <section class="content-header">
        <h1>
            用户管理
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">users/me</li>
        </ol>
    </section>

    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">全部班级</h3>
                        <div class="box-tools">
                            <form action="/classes/search" method="post">
                                <div class="input-group input-group-sm" style="width: 150px;">

                                    {{ csrf_field() }}
                                    <input type="text" name="name" class="form-control pull-right"
                                           placeholder="班级名">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>#</th>
                                <th>班级名</th>
                                <th>类型</th>
                                <th>创建时间</th>
                                <th>班级人数</th>
                                <th>班级bossemail</th>
                                <th>操作</th>
                            </tr>
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            @foreach($classes as $classe)
                                <tr>
                                    <td>
                                        <input type="checkbox" value="{{ $classe->id }}" name="ids[]">
                                    </td>
                                    <td>{{ $classe->name }}</td>
                                    <td>
                                        @foreach($classe->types as $type)
                                            {{ $type->category }}
                                        @endforeach</td>
                                    <td>{{ $classe->created_at }}</td>
                                    <td>{{ $classe->number }}</td>
                                    <td>{{$classe->boss->email }}</td>
                                    <td><a href="/classhome/{{ $classe->id }}/file.html"><span
                                                    class="label label-warning">文件</span></a>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(!$classes)
                                没有班级
                            @endif

                        </table>

                        <div class="box-footer">
                            {{$classes->links()}}
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </section>


@endsection
