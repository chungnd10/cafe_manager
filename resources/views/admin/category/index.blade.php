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
    <script type="text/javascript">
        let urlIndex = "{{ route('categories.index') }}";
        let urlStore = "{{ route('categories.store') }}";
        let urlUpdate = "{{ route('categories.update') }}";
    </script>
    <script src="{{ asset('js/category/category.js') }}"></script>
@endsection
