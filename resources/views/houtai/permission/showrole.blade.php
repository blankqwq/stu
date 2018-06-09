<form action="/admin/roles/{{$role->id}}" method="post">
    {{ csrf_field() }}
    {{method_field('put')}}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">角色详情</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="name">姓名</label>
                <input type="text" class="form-control" id="name" placeholder="姓名" value="{{$role->name}}" name="name">
            </div>
            <div class="form-group">
                <label for="display_name">别名</label>
                <input type="text" class="form-control" value="{{$role->display_name}}" id="display_name"
                       placeholder="别名"
                       name="display_name">
            </div>

            <div class="form-group">
                <label for="description">简介</label>
                <input type="text" class="form-control" value="{{$role->description}}" id="description"
                       placeholder="用途简介"
                       name="description">
            </div>

            <select multiple class="form-control" name="permissions[]">
                @foreach($permissions as $permission)
                    <option value="{{$permission->id}}"
                            @foreach($role->perms as $perm)
                                @if($perm->id==$permission->id)
                                selected
                                @endif
                            @endforeach>
                            {{$permission->display_name}}
                            :{{ $permission->description }}</option>
                @endforeach


            </select>
            <div class="modal-footer">

                <button type="submit" class="btn btn-primary">修改</button>
            </div>
        </div>
    </div>
</form>