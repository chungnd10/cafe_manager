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
                                                <span class="text-danger required-password"></span>
                                                <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Nhập mật khẩu"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Nhập lại mật khẩu</label>
                                                <span class="text-danger  required-password"></span>
                                                <input type="password" name="cf_password" id="cf_password" class="form-control"
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
                                                <textarea placeholder="Hà nội..." name="address" id="address"  rows="5"
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
    <script type="text/javascript">
        var urlIndex = "{{ route('users.index') }}";
        var urlStore = "{{ route('users.store') }}";
        var urlUpdate = "{{ route('users.update') }}";
    </script>
    <script src="{{ asset('js/user/user.js') }}"></script>
@endsection
