@extends('layouts.classhome')

@section('send','active')
@section('home-content')
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">发送一条新公告</h3>
            </div>
            <form action="/classhome/{{ $classe->id }}" method="post">
            {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <input class="form-control" placeholder="To:" value="To:全体人员" disabled>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="标题" name="title">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="type_id">
                            <option>请选择班级</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div id="editer">
                            <p>欢迎使用 <b>stu系统</b> </p>
                        </div>
                        <textarea id="content" hidden="hidden" name="content"></textarea>
                        <script type="text/javascript" src="{{ asset('admin/wangEditor.min.js') }}"></script>
                        <script type="text/javascript">
                            var E = window.wangEditor
                            var editor = new E('#editer')
                            editor.customConfig.uploadFileName = 'myfile'
                            editor.customConfig.uploadImgServer = '/editor_upload?_token={{csrf_token()}}';
                            var $text1 = $('#content')
                            editor.customConfig.onchange = function (html) {
                                // 监控变化，同步更新到 textarea
                                $text1.val(html)
                            }
                            editor.create()
                            // 初始化 textarea 的值
                            $text1.val(editor.txt.html())
                        </script>
                    </div>
                </div>
                <div class="form-group">
                    <div class="btn btn-default btn-file">
                        <i class="fa fa-paperclip"></i> 附件
                        <input type="file" name="attachment">
                    </div>
                    <p class="help-block">Max. 32MB</p>
                </div>

                <div class="box-footer">
                    <div class="pull-right">
                        {{--<button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>--}}
                        <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> 发送</button>
                    </div>
                    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> 清空</button>
                </div>
            </form>
            <!-- /.box-footer -->
        </div>
        <!-- /. box -->
    </div>



@endsection