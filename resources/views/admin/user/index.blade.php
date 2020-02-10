@extends('admin.layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách người dùng
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
                                <h4 class="modal-title">Thêm người dùng</h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="user_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Họ và tên</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="full_name" id="full_name" class="form-control"
                                                       placeholder="Nguyễn Văn A..."
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Email</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="email" id="email" class="form-control"
                                                       placeholder="example@example.com"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Số di động</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                                       placeholder="0987 654 321"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Ngày sinh</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="birthday" id="birthday" class="form-control"
                                                placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Mật khẩu</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="password" id="password" class="form-control"
                                                placeholder="Nhập mật khẩu"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Nhập lại mật khẩu</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="cf_password" id="cf_password" class="form-control"
                                                placeholder="Nhập lại mật khẩu"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ảnh</label>
                                                <span class="text-danger">*</span>
                                                <input type="file" name="avatar" id="avatar" class="form-control">
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <img src="{{ asset('upload/images/users/avatar-default.jpg') }}"
                                                     alt="image" id="img_display"
                                                     class="img-responsive img-bordered" width="130"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Quyền</label>
                                                <span class="text-danger">*</span>
                                                <select name="role_id" id="role_id" class="form-control">
                                                    <option value=''>Chọn quyền</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <span class="text-danger">*</span>
                                                <textarea placeholder="Hà nội..." name="address"
                                                          id="address"  rows="5"
                                                          class="form-control"></textarea>
                                            </div>
                                        </div><!-- /.col -->
                                        <div class="col-md-12">
                                            <div class="form-group">
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
                                        </div>
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
                        <table id="user_table"
                               class="table table-bordered table-striped dataTable"
                               role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th>Họ và tên</th>
                                <th>Ảnh</th>
                                <th>Số điện thoại</th>
                                <th>Quyền</th>
                                <th>Hành động</th>
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
    <script src="{{ asset('js/product/product.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            //START: config datatable
            let user_table = $('#user_table');
            user_table.DataTable({
                "order": [],
                "language": {
                    url: "{{ asset('admin_assets/bower_components/datatables.net-bs/lang/vietnamese-lang.json') }}"
                },
                "processing": true,
                "serverSide": true,
                "response": true,
                ajax: {
                    url: "{{ route('users.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'full_name',
                        name: 'full_name',
                    },
                    {
                        data: 'avatar',
                        name: 'avatar',
                        render: function (data) {
                            return "<img class=img-bordered src={{ asset('/upload/images/users/') }}/" + data + " width='80' />"
                        },
                        orderable: false
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                    },
                    {
                        data: 'role_name',
                        name: 'role_name',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });
            //END: config datatable

            //START: validate
            let user_form = $("#user_form");
            user_form.validate({
                rules: {
                    full_name: {
                        required: true,
                        maxlength: 255,
                    },
                    email: {
                        required: true,
                        emailGood: true,
                    },
                    phone_number: {
                        required: true,
                        phoneNumberVietNam: true
                    },
                    birthday: {
                        required: true,
                    },
                    role_id: {
                        required: true,
                    },
                    address: {
                        required: true,
                        maxlength: 255,
                    },
                    avatar: {
                        extension: "jpg|jpeg|png"
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 40,
                    },
                    cf_password: {
                        required: true,
                        equalTo: password,
                    },
                },
                messages: {
                    full_name: {
                        maxlength: '*Không được vượt quá 255 ký tự.',
                    },
                    address: {
                        maxlength: '*Không được vượt quá 255 ký tự.',
                    },
                    avatar: {
                        extension: "*Chỉ chấp nhận ảnh jpg, jpeg, png."
                    },
                    password: {
                        minlength: '*Yêu cầu mật khẩu từ 8-40 ký tự',
                        maxlength: '*Yêu cầu mật khẩu từ 8-40 ký tự',
                    },
                    cf_password: {
                        equalTo: '*Nhập lại mật khẩu không đúng.',
                    },
                }
            });
            //END: validate

            //START:
            $('#birthday').datepicker({
                autoclose: true,
                dateFormat: 'yyyy-mm-dd'
            });
            //END:


            // START: display image for input
            let inputImage = $("#avatar");
            inputImage.on('change', function () {
                let file = this.files[0];
                let img_display = $("#img_display");

                if (file) {
                    getBase64(file, img_display);
                }
            });
            // END: display image for input

            // START: while click button create
            let create_button = $('#create_record');
            create_button.click(function () {
                let action = $('#action');
                let form_modal = $('#form_modal');
                let password = $('#password');
                let cf_password = $('#cf_password');

                action.val('Thêm');
                form_modal.modal('show');
                password.rules('add', 'required');
                cf_password.rules('add', 'required');
            });
            // END: while click button create

            // START: handle while close modal
            let form_modal = $('#form_modal');
            form_modal.on('hidden.bs.modal', function () {
                let img_display = $("#img_display");
                let img_default = 'avatar-default.jpg';
                let urlImage = 'upload/images/users/';

                user_form[0].reset();
                user_form.find('label.error').text('');
                user_form.find('input').removeClass('error');
                user_form.find('select').removeClass('error');
                img_display.attr("src", urlImage + img_default);
            });
            // END: handle while close modal

            // START: create category new

            user_form.on('submit', function (e) {
                let formData = new FormData(this);
                let action = $("#action").val();

                if (user_form.valid()) {
                    if (action === "Thêm") {
                        let urlStore = "{{ route('users.store') }}";

                        storeModel(urlStore, formData).done(function (data) {
                            if (data.errors) {
                                Swal.fire(
                                    'Lỗi!',
                                    data.errors[0],
                                    'error'
                                )
                            }
                            if (data.success) {
                                let form_modal = $('#form_modal');

                                form_modal.modal('hide');
                                user_form[0].reset();
                                user_table.DataTable().ajax.reload();
                                Swal.fire(
                                    'Thành công!',
                                    'Thêm người dùng thành công!',
                                    'success'
                                )
                            }
                        });
                    }

                    if (action === "Cập nhật") {
                        let urlUpdate = "{{ route('users.update') }}";

                        updateModel(urlUpdate, formData).done(function (data) {
                            if (data.errors) {
                                Swal.fire(
                                    'Lỗi !',
                                    data.errors[0],
                                    'error'
                                )
                            }
                            if (data.success) {
                                let hidden_id = $("#hidden_id");
                                let form_modal = $('#form_modal');

                                form_modal.modal('hide');
                                user_form[0].reset();
                                user_table.DataTable().ajax.reload();
                                hidden_id.val('');
                                Swal.fire(
                                    'Thành công!',
                                    'Cập nhật người dùng thành công!',
                                    'success'
                                )
                            }
                        });
                    }
                }
            });
            // END: create category new

            // START: show  for edit
            $(document).on('click', '.edit', function () {

                let id = $(this).attr('id');
                let urlEdit = "users/" + id + "/edit";

                getModel(urlEdit).done(function (data) {

                    let hidden_id = $("#hidden_id");

                    let full_name = $("#full_name");
                    let email = $("#email ");
                    let phone_number = $("#phone_number ");
                    let birthday = $("#birthday ");
                    let role_id = $("#role_id ");
                    let address = $("#address ");

                    let img_display = $("#img_display");
                    let modal_title = $('.modal-title');
                    let action = $('#action');
                    let form_modal = $('#form_modal');
                    let urlImage = 'upload/images/users/';

                    hidden_id.val(data.id);
                    full_name.val(data.full_name);
                    email.val(data.email);
                    phone_number.val(data.phone_number);
                    birthday.val(data.birthday);
                    role_id.val(data.role_id);
                    address.val(data.address);

                    img_display.attr('src', urlImage + data.avatar);
                    modal_title.text('Sửa người dùng');
                    action.val('Cập nhật');
                    form_modal.modal('show');

                    let password = $('#password');
                    let cf_password = $('#cf_password');
                    password.rules('remove', 'required');
                    cf_password.rules('remove', 'required');
                })
            });
            // END: show for edit

            // START: delete category
            $(document).on('click', '.delete', function () {
                let product_id = $(this).attr('id');
                let urlDelete = "users/destroy/" + product_id;

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa không?',
                    text: "Dữ liệu liên quan đến người dùng này cũng sẽ bị xóa",
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
                                user_table.DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
            // END: delete category
        });
    </script>
@endsection
