@can('update-orders')
    <button type="button" name="edit" id="{{ $id }}" class="edit btn btn-warning btn-sm">
        <i class="fa fa-pencil"></i>&nbsp;Sửa
    </button>&nbsp;
@endcan
@can('delete-orders')
    <button type="button" name="delete" id="{{ $id }}" class="delete btn btn-danger btn-sm">
        <i class="fa fa-trash"></i>&nbsp;Xóa
    </button>
@endcan
