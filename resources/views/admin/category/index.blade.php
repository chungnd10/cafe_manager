@extends('admin.layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            Danh mục
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
                                <span id="form_result"></span>
                                <form action="#" id="category_form" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Tên danh mục:</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="name" id="name">
                                        <span class="text-danger" id="name_erros"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="button"
                                                class="btn btn-danger"
                                                data-dismiss="modal">
                                            <i class="fa fa-close"></i>&nbsp;&nbsp;Hủy
                                        </button>
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Thêm" />
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <div id="confirm_modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title">Xác nhận</h2>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Bạn có chắc chắn muốn xóa dữ liệu này không?<br>
                                    Tất cả sản phẩm thuộc danh mục này cũng sẽ bị xóa!
                                </p>
                            </div>
                            <div class="modal-footer ">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <i class="fa fa-close"></i>&nbsp;
                                    Hủy
                                </button>
                                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </div>
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

            var category_form = $("#category_form");
            //START: validate form
            // category_form.validate({
            //     rules: {
            //         name: {
            //             required: true
            //         }
            //     }
            // });
            //END: validate form

            // START: create category new
            var form_result = $("#form_result");

            category_form.on('submit', function (event) {
                event.preventDefault();

                var action = $("#action").val();

                // if click add category
                if (action === "Thêm") {
                    $.ajax({
                        url: "{{ route('categories.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",
                        success: function (data) {
                            var html = "";
                            if (data.errors) {
                                html = " <div class='alert alert-danger'></div>";
                                for (let i = 0; i < data.errors.length; i++) {
                                    html += "<p>" + data.errors[i] + "</p>";
                                }
                                html += "</div>"
                            }

                            if (data.success) {
                                html = " <div class='alert alert-success'>" + data.success + "</div>"
                                category_form[0].reset();
                                category_table.DataTable().ajax.reload();
                            }

                            form_result.html(html);
                        }
                    })
                }

                // START: if click update category
                if (action === "Cập nhật"){
                    $.ajax({
                        url: "{{ route('categories.update') }}",
                        method: "POST",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            if (data.errors) {
                                $('#name_errors').text(data.errors.name);
                                console.log(data);
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                category_form[0].reset();
                                category_table.DataTable().ajax.reload();
                            }
                            form_result.html(html);
                        },
                        failed(){
                            console.log(data);
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

            // START: while click button create
            var create_buton = $('#create_record');
            create_buton.click(function () {
                modal_title.text('Thêm danh mục');
                action_button.val('Thêm');
                action.val('Thêm');
                form_modal.modal('show');
            });
            // END: while click button create

            // START: show category for edit

            var hidden_id = $("#hidden_id");

            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');
                var name = $("#name");

                form_result.html('');
                $.ajax({
                    url : "categories/" + id + "/edit",
                    dataType: "json",
                    success: function (html) {
                        name.val(html.data.name);
                        hidden_id.val(html.data.id);
                        modal_title.text('Sửa danh mục');
                        action.val('Cập nhật');
                        action_button.val('Cập nhật');
                        form_modal.modal('show');
                    }
                });
            });
            // END: show category for edit

            // START: delete category
            var user_id;
            var confirm_modal = $('#confirm_modal');
            var ok_button = $('#ok_button');

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('#confirm_modal').modal('show');
            });

            ok_button.click(function () {
                $.ajax({
                    url: "categories/destroy/" + user_id,
                    beforeSend: function () {
                        ok_button.text('Đang xóa...');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            confirm_modal.modal('hide');
                            category_table.DataTable().ajax.reload();
                            ok_button.text('Xóa');
                        }, 1000);
                    }
                });
            });
            // END: delete category
        });
    </script>
@endsection
