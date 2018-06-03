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
            <h3>{{$homework->title}}</h3>
            <h5>{{$homework->poster->email}}
                <span class="mailbox-read-time pull-right">{{\Carbon\Carbon::parse($homework->created_at)->diffForHumans()}}</span>
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
            {!! $homework->content !!}
        </div>
        <!-- /.mailbox-read-message -->
    </div>
    {{--下面显示一个表格，先显示提交框--}}
    @ability('admin,owner,teacher,class'.$classe->id, 'edit-homework,manage-homework')
        @forelse ($homework->stuhomeworks as $stuhomework)
            <div class="item">
                <img src="{{}}" alt="user image" class="offline">

                <p class="message">
                    <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                        Susan Doe
                    </a>
                    I would like to meet you to discuss the latest news about
                    the arrival of the new theme. They say it is going to be one the
                    best themes on the market
                </p>
            </div>
        @empty
            <div class="mailbox-read-message">
                <div class="item">
                    <img src="" alt="user image" class="offline">

                    <p class="message">
                        <a href="#" class="name">
                            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                            Susan Doe
                        </a>
                        I would like to meet you to discuss the latest news about
                        the arrival of the new theme. They say it is going to be one the
                        best themes on the market
                    </p>
                </div>
            </div>
        @endforelse
    @endability
    {{--@if($onemessage->)--}}
    {{--@endif--}}
</div>
