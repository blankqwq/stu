@extends('layouts.admin')

@section('content')

    <section class="content-header">
        <h1>
            用户搜索
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
            <form action="/users/search" method="post">
                <div class="input-group text-center" >
                    {{ csrf_field() }}
                    <input type="text" name="search" class="form-control pull-right"
                           placeholder="Search">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection