@extends('admin.layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách sản phẩm
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
                                <h4 class="modal-title">Thêm sản phẩm</h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="product_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tên sản phẩm</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="name" id="name" class="form-control"
                                                       placeholder="Sản phẩm 1..."
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Giá</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" name="price" id="price" class="form-control"
                                                       placeholder="120.000"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                            <div class="form-group">
                                                <label>Danh mục</label>
                                                <span class="text-danger">*</span>
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value=''>Chọn danh mục</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                                <img src="{{ asset('upload/images/products/product-default.jpg') }}"
                                                     alt="image" id="img_display"
                                                     class="img-responsive img-bordered" width="130"
                                                >
                                            </div>
                                            <!-- /.form-group -->
                                        </div><!-- /.col -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <textarea placeholder="Mô tả..." name="description"
                                                          id="description" cols="30" rows="6"
                                                          class="form-control"></textarea>
                                                <span class="text-danger errors" id="description_errors"></span>
                                            </div>
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
                        <table id="product_table"
                               class="table table-bordered table-striped dataTable"
                               role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Giá</th>
                                <th>Mô tả</th>
                                <th>Danh mục</th>
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
            let product_table = $('#product_table');
            product_table.DataTable({
                "order": [],
                "language": {
                    url: "{{ asset('admin_assets/bower_components/datatables.net-bs/lang/vietnamese-lang.json') }}"
                },
                "processing": true,
                "serverSide": true,
                "response": true,
                ajax: {
                    url: "{{ route('products.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'product_name',
                        name: 'product_name',
                    },
                    {
                        data: 'avatar',
                        name: 'avatar',
                        render: function (data) {
                            return "<img class=img-bordered src={{ asset('/upload/images/products/') }}/" + data + " width='80' />"
                        },
                        orderable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
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
            let product_form = $("#product_form");
            product_form.validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                    },
                    price: {
                        required: true,
                        digits: true,
                        maxlength: 16
                    },
                    category_id: {
                        required: true,
                    },
                    avatar: {
                        extension: "jpg|jpeg|png"
                    }
                },
                messages: {
                    name: {
                        maxlength: "*Không được vượt quá 255 ký tự.",
                    },
                    price: {
                        maxlength: "*Không được nhập quá 16 ký tự.",
                    },
                    avatar: {
                        extension: "*Chỉ chấp nhận định dạng jpg, jpeg, png.",
                    }
                }
            });
            //END: validate


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

                action.val('Thêm');
                form_modal.modal('show');
            });
            // END: while click button create

            // START: handle while close modal
            let form_modal = $('#form_modal');
            form_modal.on('hidden.bs.modal', function () {
                let img_display = $("#img_display");
                let img_default = 'product-default.jpg';
                let urlImage = 'upload/images/products/';

                product_form[0].reset();
                product_form.find('label.error').text('');
                product_form.find('input').removeClass('error');
                product_form.find('select').removeClass('error');
                img_display.attr("src", urlImage + img_default);
            });
            // END: handle while close modal

            // START: create category new

            product_form.on('submit', function () {

                let formData = new FormData(this);
                let action = $("#action").val();

                if (product_form.valid()) {
                    if (action === "Thêm") {
                        let urlStore = "{{ route('products.store') }}";

                        storeModel(urlStore, formData).done(function (data) {
                            if (data.errors) {
                                Swal.fire(
                                    'Lỗi !',
                                    data.errors[0],
                                    'error'
                                )
                            }
                            if (data.success) {
                                let form_modal = $('#form_modal');

                                form_modal.modal('hide');
                                product_form[0].reset();
                                product_table.DataTable().ajax.reload();
                                Swal.fire(
                                    'Thành công!',
                                    'Thêm sản phẩm thành công!',
                                    'success'
                                )
                            }
                        });
                    }

                    if (action === "Cập nhật") {
                        let urlUpdate = "{{ route('products.update') }}";

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
                                product_form[0].reset();
                                product_table.DataTable().ajax.reload();
                                hidden_id.val('');
                                Swal.fire(
                                    'Thành công!',
                                    'Cập nhật sản phẩm thành công!',
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
                let urlEdit = "products/" + id + "/edit";

                getModel(urlEdit).done(function (data) {

                    let hidden_id = $("#hidden_id");
                    let input_name = $("#name");
                    let input_price = $("#price");
                    let category_id = $("#category_id");
                    let description = $("#description");

                    let img_display = $("#img_display");
                    let modal_title = $('.modal-title');
                    let action = $('#action');
                    let form_modal = $('#form_modal');
                    let urlImage = 'upload/images/products/';

                    hidden_id.val(data.id);
                    input_name.val(data.name);
                    input_price.val(data.price);
                    category_id.val(data.category_id);
                    description.val(data.description);

                    img_display.attr('src', urlImage + data.avatar);
                    modal_title.text('Sửa sản phẩm');
                    action.val('Cập nhật');
                    form_modal.modal('show');
                })
            });
            // END: show for edit

            // START: delete category
            $(document).on('click', '.delete', function () {
                let product_id = $(this).attr('id');
                let urlDelete = "products/destroy/" + product_id;

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa không?',
                    text: "Dữ liệu liên quan đến sản phẩm này cũng sẽ bị xóa",
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
                                product_table.DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
            // END: delete category
        });
    </script>
@endsection
