@extends('layouts.admin')

@section('content')

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>email</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->getinfo->name }}</td>
                            <td>{{ $user->getinfo->sex }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td><a href="users/{{ $user->id }}"><span class="label label-warning">查看</span></a>
                                <span class="label label-danger">删除</span></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        </div>



    </section>


@endsection
