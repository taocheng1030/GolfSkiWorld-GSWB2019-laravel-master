<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GolfSkiWorld</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="http://davidstutz.github.io/bootstrap-multiselect/dist/css/bootstrap-multiselect.css" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{!! asset('css/bootstrap-datetimepicker.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/style.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/editor.css') !!}" media="all" rel="stylesheet" type="text/css" />

    <style>
        .carousel-inner img {
        -webkit-filter: grayscale(90%);
        filter: grayscale(90%); /* make all photos black and white */
        width: 100%; /* Set width to 100% */
        margin: auto;
        }
        .carousel-caption h3 {
        color: #fff !important;
        }
        @media (max-width: 600px) {
        .carousel-caption {
        display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
        }
        }
        .bg-1 {
        background: #2d2d30;
        color: #bdbdbd;
        }
        .bg-1 h3 {color: #fff;}
        .list-group-item:first-child {
        border-top-right-radius: 0;
        border-top-left-radius: 0;
        }
        .list-group-item:last-child {
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        }
        .thumbnail {
        padding: 0 0 15px 0;
        border: none;
        border-radius: 0;
        }
        .thumbnail p {
        margin-top: 15px;
        color: #555;
        }
        .nav-tabs li a {
        color: #777;
        }
        .navbar {
        font-family: Montserrat, sans-serif;
        margin-bottom: 0;
        background-color: #2d2d30;
        border: 0;
        font-size: 11px !important;
        letter-spacing: 4px;
        opacity: 0.9;
        }
        .navbar li a, .navbar .navbar-brand {
        color: #d5d5d5 !important;
        }
        .navbar-nav li a:hover {
        color: #fff !important;
        }
        .navbar-nav li.active a {
        color: #fff !important;
        background-color: #29292c !important;
        }
        .navbar-default .navbar-toggle {
        border-color: transparent;
        }
        .open .dropdown-toggle {
        color: #fff;
        background-color: #555 !important;
        }
        footer {
        background-color: #2d2d30;
        color: #f5f5f5;
        padding: 32px;
        }
        footer a {
        color: #f5f5f5;
        }
        footer a:hover {
        color: #777;
        text-decoration: none;
        }
        .form-control {
        border-radius: 0;
        }
    </style>

</head>
<body id="app-layout">

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="http://davidstutz.github.io/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
    <script src="{!! asset('editor/ckeditor/ckeditor.js')!!}"></script>
    <!-- <script src="{!! asset('editor/ckfinder/ckfinder.js')!!}"></script> -->
    <script src="{!! asset('js/bootstrap-datetimepicker.min.js')!!}"></script>
    <script src="{!! asset('js/location.js')!!}"></script>
    <script src="{!! asset('js/editor.js')!!}"></script>
    <script src="{!! asset('js/app.min.js') !!}"></script>
</body>
</html>
