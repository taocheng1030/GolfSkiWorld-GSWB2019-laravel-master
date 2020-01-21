@extends('layouts.admin')
@section('title', ':: Watchtower')
@section('page-header')
	Watchtower
@endsection
@section('breadcrumb')
	<li class="active">Watchtower</li>
@endsection

@section('header')

    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

    <!-- Pace loader -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/silver/pace-theme-center-circle.min.css">

    <!-- Sweetalert (modal) styles  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <!-- modernizr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    @yield('header_assets')

@endsection

@section('content')

    @include(config('watchtower.views.layouts.flash'))

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div id="navbar-collapse" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <!-- navigation links -->
                    @foreach( config('watchtower-menu.navigation') as $nav_menu )
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="{{ $nav_menu['group'] }}">
                                <i class="{{$nav_menu['class']}}"></i><span class="sr-only"> {{$nav_menu['group']}}</span> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @forelse($nav_menu['links'] as $navlink)
                                    @if ($navlink == 'separator')
                                        <li role="separator" class="divider"></li>
                                    @elseif ($navlink['route'] === 'header')
                                        <li class="text-muted text-center"><i class="{{ $navlink['class'] }}"></i> {{ $navlink['title'] }}</li>
                                    @else
                                        <li><a href="{{ route($navlink['route']) }}"><i class="{{ $navlink['class'] }}"></i>  {{ $navlink['title'] }}</a></li>
                                    @endif
                                @empty
                                    <li><a href="#">No links defined yet</a></li>
                                @endforelse
                            </ul>
                        </li>
                    @endforeach

                    <!-- user dropdown links -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="User Information">
                            <i class="glyphicon glyphicon-user"></i> {{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route( config('watchtower.route.as') . 'index') }}"><i class="fa fa-fw fa-tasks"></i> Dashboard</a></li>

                            <li role="separator" class="divider"></li>
                            <li class="text-muted text-center"><i class="fa fa-users"></i> Your Roles</li>
                            @forelse(Auth::user()->roles as $role)
                                <li><a href="{{ route( config('watchtower.route.as') . 'role.permission.edit', $role->id) }}"><i class="fa fa-users fa-xs"></i> {{ $role->name }}</a></li>
                            @empty
                                <li><a href="#"><i class="fa fa-hand-stop-o fa-xs"></i> No roles</a></li>
                            @endforelse
                            {{--<li role="separator" class="divider"></li>--}}
                            {{--<li><a href="{{ url( config('watchtower.auth_routes.logout') ) }}"><i class="fa fa-fw fa-sign-out"></i> Logout</a></li>--}}
                        </ul>
                    </li>
                </ul>
            </div>

        </div><!-- /.container-fluid -->
    </nav>

    @yield('wt_content')

@endsection

@section('script')


    <!-- Pace Loader -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>

    <!-- For Delete Modal prompts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script>
        /*!
         * IE10 viewport hack for Surface/desktop Windows 8 bug
         * Copyright 2014-2015 Twitter, Inc.
         * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
         */

        // See the Getting Started docs for more information:
        // http://getbootstrap.com/getting-started/#support-ie10-width

        (function () {
            $('[data-toggle="popover"]').popover();

            'use strict';

            if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                var msViewportStyle = document.createElement('style')
                msViewportStyle.appendChild(
                    document.createTextNode(
                        '@-ms-viewport{width:auto!important}'
                    )
                )
                document.querySelector('head').appendChild(msViewportStyle)
            }
        })();

        /**
         * To auto-hide all alerts, except danger
         */
        $('div.alert').not('div.alert-danger').delay(4000).slideUp();

        /**
         * To use the bootstrap tooltip popups.
         */
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body',
            trigger:'click hover focus'
        });

        /*!
         * For Delete Modal prompts
         *
         */
        $('button[type="submit"]').click(function(e) {
            if ( $(this).hasClass('btn-danger') ) {
                var currentForm = this.closest("form");
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this object.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, keep it.",
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            currentForm.submit();
                        } else {
                            swal({
                                title: "Cancelled!",
                                text: 'Object not deleted. <br /> <em><small>(I will close in 2 seconds)</em></small>',
                                timer: 2000,
                                showConfirmButton: true,
                                confirmButtonText: "Close now.",
                                type: 'error',
                                html: true
                            });
                        }
                    }
                );
            }
        });
    </script>

    @yield('footer_assets')

@endsection