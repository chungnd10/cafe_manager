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
                                <span id="form_message"></span>
                                <form action="#" id="category_form" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">Tên danh mục:</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" autofocus name="name" id="name">
                                        <label id="name-error" class="error" for="name"></label>
                                    </div>
                                    <div class="form-group ">
                                        <button type="button"
                                                class="btn btn-danger"
                                                data-dismiss="modal">
                                            <i class="fa fa-close"></i>&nbsp;&nbsp;Hủy
                                        </button>
                                        <input type="hidden" name="action" id="action"/>
                                        <input type="hidden" name="hidden_id" id="hidden_id"/>
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa fa-save"></i>&nbsp;Lưu
                                        </button>
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
    <script src="{{ asset('js/category/category.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // START: config datatable
            let category_table = $('#category-table');
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
            // END: config datatcomable

            //START: validate
            let category_form = $("#category_form");
            category_form.validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    }
                },
                message: {
                    name: {
                        maxlength: "*Không được vượt quá 255 ký tự."
                    }
                }
            });
            //END: validate


            // START: while click button create
            let create_buton = $('#create_record');
            create_buton.click(function () {
                let action = $('#action');
                let form_modal = $('#form_modal');

                action.val('Thêm');
                form_modal.modal('show');
            });
            // END: while click button create

            // START: handle while close modal
            let form_modal = $('#form_modal');
            form_modal.on('hidden.bs.modal', function () {
                let category_form = $("#category_form");
                let form_message = $("#form_message");

                form_message.html();
                category_form.find('label.error').text('');
                category_form.find('input').removeClass('error');
                category_form[0].reset();
            });
            // END: handle while close modal

            // START: create category new
            category_form.on('submit', function () {
                if (category_form.valid()) {

                    let action = $("#action").val();
                    let formData = new FormData(this);

                    if (action === "Thêm") {
                        let urlStore = "{{ route('categories.store') }}";

                        storeCategory(urlStore, formData).done(function (data) {
                            if (data.errors) {
                                let form_message = $("#form_message");
                                form_message.html(printErrorMessage(data));
                            }
                            if (data.success) {
                                form_modal.modal('hide');
                                category_form[0].reset();
                                category_table.DataTable().ajax.reload();
                                Swal.fire(
                                    'Thành công!',
                                    'Thêm danh mục thành công!',
                                    'success'
                                )
                            }
                        });
                    }

                    if (action === "Cập nhật") {
                        let urlUpdate = "{{ route('categories.update') }}";
                        let hidden_id = $("#hidden_id");

                        updateCategory(urlUpdate, formData).done(function (data) {
                            if (data.errors) {
                                let form_message = $("#form_message");
                                form_message.html(printErrorMessage(data));
                            }
                            if (data.success) {
                                form_modal.modal('hide');
                                category_form[0].reset();
                                category_table.DataTable().ajax.reload();
                                hidden_id.val('');
                                Swal.fire(
                                    'Thành công!',
                                    'Cập nhật danh mục thành công!',
                                    'success'
                                )
                            }
                        });
                    }
                }
            });
            // END: create category new

            // START: show category for edit
            $(document).on('click', '.edit', function () {
                let id = $(this).attr('id');
                let urlEdit = "categories/" + id + "/edit";

                let hidden_id = $("#hidden_id");
                let input_name = $("#name");
                let modal_title = $('.modal-title');
                let action = $('#action');
                let action_button = $('#action_button');

                getCategory(urlEdit).done(function (data) {
                    hidden_id.val(data.data.id);
                    input_name.val(data.data.name);

                    modal_title.text('Sửa danh mục');
                    action.val('Cập nhật');
                    action_button.val('Cập nhật');

                    form_modal.modal('show');
                })
            });
            // END: show category for edit

            // START: delete category
            $(document).on('click', '.delete', function () {
                let user_id = $(this).attr('id');
                let urlDelete = "categories/destroy/" + user_id;

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa không?',
                    text: "Dữ liệu thuộc danh mục này cũng sẽ bị xóa",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        deleteCategory(urlDelete).done(function (data) {
                            if (data.success) {
                                Swal.fire(
                                    'Đã xóa!',
                                    'Dữ liệu đã được xóa.',
                                    'success'
                                );
                                category_table.DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
            // END: delete category
        });
    </script>
@endsection
