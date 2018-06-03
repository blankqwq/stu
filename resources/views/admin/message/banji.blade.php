<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell-o"></i>
    <span class="label label-warning">{{$message_number}}</span>
</a>
<ul class="dropdown-menu">
    <li class="header">你有{{$message_number}} 条关于团体</li>
    <li>
        @forelse($messages as $message)
            <ul class="menu">
                <li>
                    <a href="/classhome/{{ $message->id }}/index.html"> {{ $message->name }}
                        <i class="fa fa-users text-aqua"></i> {{$message->messages->last()->title }}
                    </a>
                </li>
            </ul>
    @empty
        <li><a href="#">
                <div class="pull-left">
                    暂无
                </div>
            </a>
            @endforelse
        </li>
        <!-- end message -->

        <li class="footer"><a href="/class">查看详情</a></li>
</ul>
