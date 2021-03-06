<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">查看详细</h3>

        <div class="box-tools pull-right">
            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i
                        class="fa fa-chevron-left"></i></a>
            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i
                        class="fa fa-chevron-right"></i></a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <div class="mailbox-read-info">
            <h3>{{$onemessage->title}}</h3>
            <h5>{{$onemessage->sender->email}}
                <span class="mailbox-read-time pull-right">{{\Carbon\Carbon::parse($onemessage->created_at)->diffForHumans()}}</span>
            </h5>
        </div>
        <!-- /.mailbox-read-info -->
        <div class="mailbox-controls with-border text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                        title="Delete">
                    <i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                        title="Reply">
                    <i class="fa fa-reply"></i></button>
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body"
                        title="Forward">
                    <i class="fa fa-share"></i></button>
            </div>
            <!-- /.btn-group -->
            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                <i class="fa fa-print"></i></button>
        </div>
        <!-- /.mailbox-controls -->
        <div class="mailbox-read-message">
            {!! $onemessage->content !!}
        </div>
        <!-- /.mailbox-read-message -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <ul class="mailbox-attachments clearfix">
            @foreach($onemessage->enclosures as $enclosure)
                <li>
                    <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                    <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> {{ $enclosure->name }}</a>
                        <span class="mailbox-attachment-size">
                          {{ $enclosure->size }}
                            <a href="{{'/storage/'.$enclosure->url}}" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                    </div>
                </li>
            @endforeach


        </ul>
    </div>
    @forelse ($onemessage->replies as $reply)
        <div class="item">
            <p class="message">
                <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 回复人。。。。需要改进，变成多级回复</small>
                    ll
                </a>
                ll
            </p>
        </div>
    @empty
        <div class="mailbox-read-message">
            <div class="item">
                <img src="" alt="user image" class="offline">

                <p class="message">
                    <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                       System
                    </a>
                   暂无消息
                </p>
            </div>
        </div>
    @endforelse
    {{--@if($onemessage->)--}}
    {{--@endif--}}
</div>
