<!DOCTYPE html>
<html>
@include('houtai.particles.head')
<body class="@yield('bar','hold-transition skin-blue sidebar-mini')">
<div class="wrapper">
    @include('houtai.particles.header')

    @include('houtai.particles.siderbar')

    <div class="content-wrapper">
        @yield('content')

    </div>
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