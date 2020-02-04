<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts.top_assets')
</head>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
    {{--  header  --}}
    @include('admin.layouts.header')
    {{--  Content--}}
    <div class="content-wrapper">
        @yield('content')
    </div>
    {{--  footer --}}
    @include('admin.layouts.footer')
</div>
{{-- bottom_assets--}}
@include('admin.layouts.bottom_assets')

{{--@include('sweetalert::alert')--}}
{{--page script--}}
@yield('script')
</body>
</html>
