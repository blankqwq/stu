<div class="box">
    <form action="/admin/classtype/{{$classtype->id}}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}
        <div class="box-body box-profile">
            <div class="form-group">
                <label>班级名</label>
                <input type="text" class="form-control" name="category" placeholder="班级名称"
                       value="{{ $classtype->category }}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">提交更改</button>
        </div>
    </form>
</div>