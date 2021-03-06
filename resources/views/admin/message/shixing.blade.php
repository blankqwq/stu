<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-envelope-o"></i>
    <span class="label label-success">{{$message_number}}</span>
</a>
<ul class="dropdown-menu">
    <li class="header">你有{{$message_number}} 条消息未读</li>
    <li>
        @forelse($messages as $message)
            <ul class="menu">
                <li><!-- start message -->
                    <a href="#">
                        <div class="pull-left">
                            <img src="{{ $message->sender->getinfo->first()->avatar }}" class="img-circle"
                                 alt="User Image">
                        </div>
                        <h4>
                            {{$message->sender->getinfo->first()->name }}
                            <small>
                                <i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}
                            </small>
                        </h4>
                        <p>{{$message->content }}</p>
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
        <li class="footer"><a href="/message/index.html">查看详情</a></li>
</ul>