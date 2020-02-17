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
    <script type="text/javascript">
        var urlIndex = "{{ route('products.index') }}";
        var urlStore = "{{ route('products.store') }}";
        var urlUpdate = "{{ route('products.update') }}";
    </script>
    <script src="{{ asset('js/product/product.js') }}"></script>
@endsection
