<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
    {{ HTML::image(Auth::user()->avatar, Auth::user()->name, ['class' => 'user-image']) }}
    <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
            {{ HTML::image(Auth::user()->avatar, Auth::user()->name, ['class' => 'img-circle']) }}
            <p>{{ Auth::user()->name }}</p>
            <div id="Auth" class="hide" data-url="{{ adminUrl('check') }}" data-id="{{ Auth::id() }}"></div>
        </li>
    {{--<!-- Menu Body -->--}}
    {{--<li class="user-body">--}}
    {{--<div class="row">--}}
    {{--<div class="col-xs-4 text-center">--}}
    {{--<a href="#">Followers</a>--}}
    {{--</div>--}}
    {{--<div class="col-xs-4 text-center">--}}
    {{--<a href="#">Sales</a>--}}
    {{--</div>--}}
    {{--<div class="col-xs-4 text-center">--}}
    {{--<a href="#">Friends</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!-- /.row -->--}}
    {{--</li>--}}
    <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a class="btn btn-default btn-flat" href="{{ adminUrl('profile') }}">
                    <i class="fa fa-btn fa-user"></i>
                    Profile
                </a>
            </div>
            <div class="pull-right">
                <a class="btn btn-default btn-flat" href="{{ adminUrl('logout') }}">
                    <i class="fa fa-btn fa-sign-out"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</li>