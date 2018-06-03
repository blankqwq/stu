<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-flag-o"></i>
    <span class="label label-success">{{$message_number}}</span>
</a>
<ul class="dropdown-menu">
    <li class="header">你有{{$message_number}} 条申请未读</li>
    <li>
        @forelse($messages as $message)
            <ul class="menu">
                <li><!-- Task item -->
                    <a href="#">
                        <h3>
                            {{$message->sender->getinfo->first()->name }}发来申请
                            <small class="pull-right">{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</small>
                        </h3>
                        <div class="progress ">

                                <span >{{$message->title }}</span>
                        </div>
                    </a>
                </li>
            </ul>
    @empty
        <li><a href="#">
                <div class="pull-left">
                    暂无
                </div>
            </a></li>
    @endforelse
    <li class="footer"><a href="/message/index.html">查看详情</a></li>
</ul>

