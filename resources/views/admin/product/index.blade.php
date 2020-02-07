@extends('admin.layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            Sản phẩm
        </h1>
        <ol class="breadcrumb">
            <li></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="product-table"
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
                                    <th width="20%">Hành dộng</th>
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
            $('#product-table').DataTable({
                "language": {
                    url: "{{ asset('admin_assets/bower_components/datatables.net-bs/lang/vietnamese-lang.json') }}"
                },
                "processing": true,
                "serverSide": true,
                ajax: {
                    url:  "{{ route('products.index') }}",
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
                        data: 'avatar',
                        name: 'avatar',
                        render: function (data) {
                            return "<img class='profile-user-img' src=/upload/images/products/"+data+" width='60' />"
                        }
                    },
                    {
                        data: 'price',
                        name: 'price',
                    },
                    {
                        data: 'description',
                        name: 'description',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endsection
