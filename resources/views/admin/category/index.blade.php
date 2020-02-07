@extends('admin.layouts.index')
@section('content')
    <section class="content-header">
        <h1>

            Danh sách danh mục
        </h1>
        <ol class="breadcrumb">
            <li>
                <button type="button" class="btn btn-success btn-sm"
                        data-toggle="modal"
                        data-target="#form-modal"
                        id="create_record"
                        name="create_record"
                >
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                </button>
                <div class="modal fade" id="form_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Thêm danh mục</h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="category_form" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Tên danh mục:</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" autofocus name="name" id="name">
                                        <span class="text-danger errors" id="name_errors"></span>
                                    </div>
                                    <div class="form-group ">
                                        <button type="button"
                                                class="btn btn-danger"
                                                data-dismiss="modal">
                                            <i class="fa fa-close"></i>&nbsp;&nbsp;Hủy
                                        </button>
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="submit" name="action_button" id="action_button"
                                               class="btn btn-success" value="Thêm" />
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="category-table"
                               class="table table-bordered dataTable"
                               role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th width="10%">ID</th>
                                <th>Tên</th>
                                <th width="20%">Hành động</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            // START: config datatable
            var category_table = $('#category-table');

            category_table.DataTable({
                "order": [],
                "language": {
                    url: "{{ asset('admin_assets/bower_components/datatables.net-bs/lang/vietnamese-lang.json') }}"
                },
                "processing": true,
                "serverSide": true,
                ajax: {
                    url: "{{ route('categories.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }

                ]
            });
            // END: config datatable


            // START: create category new
            var category_form = $("#category_form");
            var errors = $(".errors");

            category_form.on('submit', function (event) {
                event.preventDefault();

                var action = $("#action").val();
                var formData = new FormData(this);
                var name_errors = $("#name_errors");

                //function update
                function storeCategory() {
                    return $.ajax({
                        url: "{{ route('categories.store') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json"
                    });
                }

                //function update
                function updateCategory() {
                    return $.ajax({
                        url: "{{ route('categories.update') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json"
                    });
                }

                // if click add category
                if (action === "Thêm") {
                    // execute create
                    storeCategory().done(function (data) {
                        if (data.errors) {
                            // display errors
                            name_errors.text(data.errors.name);
                        }
                        if (data.success) {
                            // hidden modal
                            form_modal.modal('hide');
                            // reset form
                            category_form[0].reset();
                            // reload datatable
                            category_table.DataTable().ajax.reload();
                            // show message
                            Swal.fire(
                                'Thành công!',
                                'Thêm danh mục thành công!',
                                'success'
                            )
                        }
                    });
                }

                // START: if click update category
                if (action === "Cập nhật"){
                    //execute update
                    updateCategory().done(function (data) {
                        if (data.errors) {
                            // display errors
                            name_errors.text(data.errors.name);
                        }
                        if (data.success) {
                            // hidden modal
                            form_modal.modal('hide');
                            // reset form
                            category_form[0].reset();
                            // reload datatable
                            category_table.DataTable().ajax.reload();
                            // remove id updated
                            hidden_id.val('');
                            // show message
                            Swal.fire(
                                'Thành công!',
                                'Cập nhật danh mục thành công!',
                                'success'
                            )
                        }
                    });
                }
                // END: if click update category
            });
            // END: create category new

            var modal_title = $('.modal-title');
            var action = $('#action');
            var action_button = $('#action_button');
            var form_modal = $('#form_modal');
            var create_buton = $('#create_record');

            // START: while click button create
            create_buton.click(function () {
                // add title for modal
                modal_title.text('Thêm danh mục');
                // add action for button
                action_button.val('Thêm');
                // add action
                action.val('Thêm');
                // show modal
                form_modal.modal('show');
            });
            // END: while click button create

            // START: show category for edit
            var hidden_id = $("#hidden_id");
            var input_name = $("#name");

            $(document).on('click', '.edit', function () {
                //get id
                var id = $(this).attr('id');
                // function get data
                function getCategory(){
                    return $.ajax({
                        url: "categories/" + id + "/edit",
                        dataType: "json"
                    });
                }

                // get data
                getCategory().done(function (html) {
                    // add data for edit
                    input_name.val(html.data.name);
                    hidden_id.val(html.data.id);
                    // edit title modal
                    modal_title.text('Sửa danh mục');
                    // edit action
                    action.val('Cập nhật');
                    // add action for button
                    action_button.val('Cập nhật');
                    // show modal
                    form_modal.modal('show');
                })
            });
            // END: show category for edit

            // START: delete category
            // get id and show modal
            $(document).on('click', '.delete', function () {
                //get id
               var user_id = $(this).attr('id');

                // funtion delete
                function deleteCategory() {
                    return $.ajax({
                        url: "categories/destroy/" + user_id
                    });
                }
                // confirm delete
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa không?',
                    text: "Dữ liệu thuộc danh mục này cũng sẽ bị xóa",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true
                }).then((result) => {
                    // if confirm ok
                    if (result.value) {
                        deleteCategory().done(function (data) {
                            if (data.success) {
                                //show message
                                Swal.fire(
                                    'Đã xóa!',
                                    'Dữ liệu đã được xóa.',
                                    'success'
                                );
                                //reload datatable
                                category_table.DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
            // END: delete category

            // START: handle while close modal
            form_modal.on('hidden.bs.modal', function () {
                // clear message errors
                errors.text('');
                // reset form
                category_form[0].reset();
            });
            // END: handle while close modal
        });
    </script>
@endsection
