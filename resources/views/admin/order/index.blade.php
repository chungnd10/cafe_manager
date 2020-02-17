@extends('admin.layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách order
        </h1>
        <ol class="breadcrumb">
            <li>
                @can('create-orders')
                    <button type="button" class="btn btn-success btn-sm"
                            data-toggle="modal"
                            data-target="#form-modal"
                            id="create_record"
                            name="create_record">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                    </button>
                @endcan
                {{--modal create and update--}}
                <div class="modal fade" id="form_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Thêm order</h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" id="order_form" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Chọn bàn</label>
                                                <span class="text-danger">*</span>
                                                <select name="table_id" id="table_id" class="form-control">
                                                    <option value="">Chọn bàn</option>
                                                    @foreach($tables as $table)
                                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sản phẩm</label>
                                                <span class="text-danger">*</span>
                                                <select name="product_id" id="product_id" class="form-control">
                                                    <option value="">Chọn sản phẩm</option>
                                                    1
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        @if(auth()->user()->isBartender())
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Trạng thái</label>
                                                    <span class="text-danger">*</span>
                                                    <select name="order_status_id" id="order_status_id"
                                                            class="form-control">
                                                        <option value="">Chọn trạng thái</option>
                                                        @foreach($order_status as $status)
                                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped" id="product_order">
                                                <thead>
                                                <tr>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Số lượng</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot class="hidden" id="product_hidden">
                                                </tfoot>
                                            </table>
                                        </div><!-- /.col -->
                                        <div class="col-md-12">
                                            <div class="form-group">
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
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                {{--modal view info--}}
                <div class="modal fade" id="modal_info">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Thông tin order</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul>
                                            <li><b>Bàn: </b><span id="info_table"></span></li>
                                            <li><b>Người tạo: </b><span id="info_created_by"></span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul>
                                            <li><b>Trạng thái: </b><span id="info_status"></span></li>
                                            <li><b>Người pha chế: </b><span id="info_bartender"></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <br>
                                <table class="table table-bordered" id="tbody_info">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="order_table"
                               class="table table-bordered table-striped dataTable"
                               role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th>Bàn</th>
                                <th>Người tạo</th>
                                <th>Trạng thái</th>
                                <th>Người xử lý</th>
                                <th>Thời gian tạo</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        let urlIndex = "{{ route('orders.index') }}";
        let urlStore = "{{ route('orders.store') }}";
        let urlUpdate = "{{ route('orders.update') }}";
    </script>
    <script src="{{ asset('js/order/order.js') }}"></script>
@endsection
