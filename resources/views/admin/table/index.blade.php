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
            <!-- /.box-body -->i
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        var urlIndex = "{{ route('tables.index') }}";
        var urlStore = "{{ route('tables.store') }}";
        var urlUpdate = "{{ route('tables.update') }}";
    </script>
    <script src="{{ asset('js/table/table.js') }}"></script>
@endsection
