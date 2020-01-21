<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GolfSkiWorld :: Dashboard @yield('title')</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{!! asset('vendor/bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') !!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('vendor/font-awesome/css/font-awesome.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('vendor/ionic-framework/ionicons.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('vendor/admin-lte/css/AdminLTE.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('vendor/admin-lte/css/skins/skin-blue.min.css') !!}">
    <!-- Plugins style -->
    <link href="{!! asset('vendor/datatables/dataTables.bootstrap.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('vendor/multiselect/bootstrap-multiselect.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('vendor/datetimepicker/css/bootstrap-datetimepicker.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <!-- Custom styles -->
    <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />
    {{--<link href="{!! asset('css/editor.css') !!}" media="all" rel="stylesheet" type="text/css" />--}}
    <link href="{!! asset('css/table.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{!! asset('vendor/intl-tel-input/css/intlTelInput.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('header')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    @include('layouts.admin.header')

    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.admin.sidebar-main')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page-header')
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ adminUrl('') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                @yield('breadcrumb')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    @include('layouts.admin.footer')

    <!-- Control Sidebar -->
    @include( ($sidebarControl != null && $sidebarControl->filterPages()) ? $sidebarControl->layout : 'layouts.admin.sidebar-control')

    <div id="CSRF" data-token="{{ csrf_token() }}"></div>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery -->
<script src="{!! asset('vendor/jQuery/jquery.min.js') !!}"></script>
<script src="{!! asset('vendor/jQuery/jquery-migrate.min.js') !!}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{!! asset('vendor/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') !!}"></script>
<script src="{!! asset('vendor/bootbox/bootbox.min.js') !!}"></script>
<!-- iCheck -->
<script src="{!! asset('vendor/iCheck/icheck.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('vendor/admin-lte/js/app.min.js')!!}"></script>
<script src="{!! asset('vendor/intl-tel-input/js/intlTelInput.min.js')!!}"></script>

<!-- Plugins script -->
<script src="{!! asset('vendor/moment/moment.min.js')!!}"></script>
<script src="{!! asset('vendor/moment/moment-with-locales.min.js')!!}"></script>
<script src="{!! asset('vendor/datatables/jquery.dataTables.min.js')!!}"></script>
<script src="{!! asset('vendor/datatables/dataTables.bootstrap.min.js')!!}"></script>
<script src="{!! asset('vendor/multiselect/bootstrap-multiselect.js')!!}"></script>
<script src="{!! asset('vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')!!}"></script>
{{--<script src="{!! asset('editor/ckfinder/ckfinder.js')!!}"></script>--}}

<!-- Custom script -->
<script src="{!! asset('js/helpers.js') !!}"></script>
<script src="{!! asset('js/location.js')!!}"></script>
{{--<script src="{!! asset('js/editor.js')!!}"></script>--}}
<script src="{!! asset('js/app-admin.js') !!}"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

<!-- Socket.Io -->
<script src="{!! asset('vendor/socket.io/socket.io.min.js') !!}"></script>
<script src="{!! asset('js/client.js') !!}"></script>

@yield('script')

</body>
</html>
