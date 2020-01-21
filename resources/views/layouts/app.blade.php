<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" href="{!! asset('vendor/font-awesome/css/font-awesome.css') !!}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{!! asset('vendor/bootstrap/css/bootstrap.min.css') !!}">
    <!-- Custom styles -->
    <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />

    @yield('header')

</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('') }}">
                    @if (Auth::guest())
                        Admin
                    @else
                        {{ Auth::user()->name }}
                    @endif
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ adminUrl('login') }}">Login</a></li>
                        <li><a href="{{ adminUrl('register') }}">Register</a></li>
                    @else
                        <li><a href="{{ adminUrl('/') }}"><i class="fa fa-btn fa-dashboard"></i> Dashdoard</a></li>
                        <li><a href="{{ adminUrl('logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('breadcrumb')

    @yield('content')

    <!-- jQuery -->
    <script src="{!! asset('vendor/jQuery/jquery.min.js') !!}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{!! asset('vendor/bootstrap/js/bootstrap.min.js') !!}"></script>

    @yield('script')

</body>
</html>
