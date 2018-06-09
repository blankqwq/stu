<form action="/admin/permissions/{{$permission->id}}" method="post">
    {{ csrf_field() }}
    {{method_field('put')}}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">权限详情</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="name">姓名</label>
                <input type="text" class="form-control" id="name" placeholder="姓名" value="{{$permission->name}}" name="name">
            </div>
            <div class="form-group">
                <label for="display_name">别名</label>
                <input type="text" class="form-control" value="{{$permission->display_name}}" id="display_name" placeholder="别名"
                       name="display_name">
            </div>

            <div class="form-group">
                <label for="description">简介</label>
                <input type="text" class="form-control" value="{{$permission->description}}" id="description" placeholder="用途简介"
                       name="description">
            </div>
            <div class="modal-footer">

                <button type="submit" class="btn btn-primary">修改</button>
            </div>
        </div>
    </div>
</form>