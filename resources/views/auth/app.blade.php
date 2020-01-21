<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GolfSkiWorld - Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{!! asset('vendor/bootstrap/css/bootstrap.min.css') !!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('vendor/font-awesome/css/font-awesome.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('vendor/ionic-framework/ionicons.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('vendor/admin-lte/css/AdminLTE.min.css') !!}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{!! asset('vendor/iCheck/square/blue.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('header')

</head>
<body class="hold-transition login-page">

    @yield('content')

<!-- jQuery -->
<script src="{!! asset('vendor/jQuery/jquery.min.js') !!}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{!! asset('vendor/bootstrap/js/bootstrap.min.js') !!}"></script>
<!-- iCheck -->
<script src="{!! asset('vendor/iCheck/icheck.min.js') !!}"></script>
<!-- Location -->
<script src="{!! asset('js/helpers.js') !!}"></script>
<script src="{!! asset('js/location.js')!!}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
@yield('script')
</body>
</html>
