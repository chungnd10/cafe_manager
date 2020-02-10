@extends('admin.layouts.index')
@section('content')
    <section class="content-header">
        <h1>

            Danh sách bàn
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
                                <h4 class="modal-title">Thêm bàn</h4>
                            </div>
                            <div class="modal-body">
                                <span id="form_message"></span>
                                <form action="#" id="table_form" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tên bàn:</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="name" id="name">
                                                <label id="name-error" class="error" for="name"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Số chỗ:</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control"
                                                       name="number_of_seats" id="number_of_seats">
                                                <label id="number_of_seats-error" class="error"
                                                       for="number_of_seats"></label>
                                            </div>
                                        </div>
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
                        <table id="table_table"
                               class="table table-bordered dataTable"
                               role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Số chỗ</th>
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
            let table_table = $('#table_table');
            table_table.DataTable({
                "order": [],
                "language": {
                    url: "{{ asset('admin_assets/bower_components/datatables.net-bs/lang/vietnamese-lang.json') }}"
                },
                "processing": true,
                "serverSide": true,
                ajax: {
                    url: "{{ route('tables.index') }}",
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
                        data: 'number_of_seats',
                        name: 'number_of_seats',
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
            let table_form = $("#table_form");
            table_form.validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    number_of_seats: {
                        required: true,
                        digits: true,
                        maxlength: 10
                    }
                },
                message: {
                    name: {
                        maxlength: "*Không được vượt quá 255 ký tự."
                    },
                    number_of_seats: {
                        maxlength: "*Không được vượt quá 10 ký tự."
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
                let table_form = $("#table_form");

                table_form.find('label.error').text('');
                table_form.find('input').removeClass('error');
                table_form[0].reset();
            });
            // END: handle while close modal

            // START: create category new
            table_form.on('submit', function (event) {
                if (table_form.valid()) {
                    let action = $("#action").val();
                    let formData = new FormData(this);

                    if (action === "Thêm") {
                        let urlStore = "{{ route('tables.store') }}";

                        storeModel(urlStore, formData).done(function (data) {
                            if (data.errors) {
                                Swal.fire(
                                    'Lỗi !',
                                    data.errors[0],
                                    'error'
                                )
                            }
                            if (data.success) {
                                form_modal.modal('hide');
                                table_form[0].reset();
                                table_table.DataTable().ajax.reload();
                                Swal.fire(
                                    'Thành công!',
                                    'Thêm bàn thành công!',
                                    'success'
                                )
                            }
                        });
                    }

                    if (action === "Cập nhật") {
                        let urlUpdate = "{{ route('tables.update') }}";
                        let hidden_id = $("#hidden_id");

                        updateModel(urlUpdate, formData).done(function (data) {
                            if (data.errors) {
                                Swal.fire(
                                    'Lỗi !',
                                    data.errors[0],
                                    'error'
                                )
                            }
                            if (data.success) {
                                form_modal.modal('hide');
                                table_form[0].reset();
                                table_table.DataTable().ajax.reload();
                                hidden_id.val('');
                                Swal.fire(
                                    'Thành công!',
                                    'Cập nhật bàn thành công!',
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
                let urlEdit = "tables/" + id + "/edit";

                let hidden_id = $("#hidden_id");
                let input_name = $("#name");
                let number_of_seats = $("#number_of_seats");

                let modal_title = $('.modal-title');
                let action = $('#action');
                let action_button = $('#action_button');

                getModel(urlEdit).done(function (data) {
                    hidden_id.val(data.id);
                    input_name.val(data.name);
                    number_of_seats.val(data.number_of_seats);

                    modal_title.text('Sửa bàn');
                    action.val('Cập nhật');
                    action_button.val('Cập nhật');

                    form_modal.modal('show');
                })
            });
            // END: show category for edit

            // START: delete category
            $(document).on('click', '.delete', function () {
                let user_id = $(this).attr('id');
                let urlDelete = "tables/destroy/" + user_id;

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa không?',
                    text: "Dữ liệu thuộc bàn này cũng sẽ bị xóa",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        deleteModel(urlDelete).done(function (data) {
                            if (data.success) {
                                Swal.fire(
                                    'Đã xóa!',
                                    'Dữ liệu đã được xóa.',
                                    'success'
                                );
                                table_table.DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
            // END: delete category
        });
    </script>
@endsection
