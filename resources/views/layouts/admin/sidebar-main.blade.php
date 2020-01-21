<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="Search...">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>--}}
                {{--</button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Information</li>
            <li @if (Request::is('admin/deals*')) class="active" @endif><a href="{{ adminUrl('deals') }}"><i class="fa fa-ticket"></i> <span>Deals</span></a></li>
            <li @if (Request::is('admin/lastminutes*')) class="active" @endif><a href="{{ adminUrl('lastminutes') }}"><i class="fa fa-ticket"></i> <span>Last minutes</span></a></li>
            <li @if (Request::is('admin/notifications*')) class="active" @endif><a href="{{ adminUrl('notifications') }}"><i class="fa fa-bell"></i> <span>Notification center</span></a></li>
            <li class="header">Places</li>
            <li @if (Request::is('admin/resorts*')) class="active" @endif><a href="{{ adminUrl('resorts') }}"><i class="fa fa-map-o"></i> <span>Resorts</span></a></li>
            <li @if (Request::is('admin/restaurants*')) class="active" @endif><a href="{{ adminUrl('restaurants') }}"><i class="fa fa-cutlery"></i> <span>Restaurants</span></a></li>
            <li @if (Request::is('admin/accommodations*')) class="active" @endif><a href="{{ adminUrl('accommodations') }}"><i class="fa fa-bed"></i> <span>Accommodation</span></a></li>
            <li @if (Request::is('admin/destinfos*')) class="active" @endif><a href="{{ adminUrl('destinfos') }}"><i class="fa fa-map-pin"></i> <span>Destinations</span></a></li>

            @role('admin')
            <li class="header">Webpage</li>
            <li @if (Request::is('admin/awardinfos*')) class="active" @endif><a href="{{ adminUrl('awardinfos') }}"><i class="fa fa-life-ring"></i> <span>Awards info</span></a></li>
            <li @if (Request::is('admin/abouts*')) class="active" @endif><a href="{{ adminUrl('abouts') }}"><i class="fa fa-info-circle"></i> <span>About us</span></a></li>

            <li class="header">Files</li>
            <li @if (Request::is('admin/photos/users*')) class="active" @endif><a href="{{ adminUrl('photos/users') }}"><i class="fa fa-photo"></i> <span>Users photos</span></a></li>
            <li @if (Request::is('admin/videos/users*')) class="active" @endif><a href="{{ adminUrl('videos/users') }}"><i class="fa fa-video-camera"></i> <span>Users video</span></a></li>
            <li @if (Request::is('admin/videos/gsw*')) class="active" @endif><a href="{{ adminUrl('videos/gsw') }}"><i class="fa fa-video-camera"></i> <span>GSW videos</span></a></li>
            <li @if (Request::is('admin/articles*')) class="active" @endif><a href="{{ adminUrl('articles') }}"><i class="fa fa-newspaper-o"></i> <span>Articles</span></a></li>

            <li class="header">Settings</li>
            <li @if (Request::is('admin/tags*')) class="active" @endif><a href="{{ adminUrl('tags') }}"><i class="fa fa-tags"></i> <span>Tags</span></a></li>
            <li @if (Request::is('admin/languages*')) class="active" @endif><a href="{{ adminUrl('languages') }}"><i class="fa fa-language"></i> <span>Languages</span></a></li>
            <li @if (Request::is('admin/translations*')) class="active" @endif><a href="{{ adminUrl('translations') }}"><i class="fa fa-language"></i> <span>Translations</span></a></li>
            <li class="treeview @if (Request::is('admin/users*') || Request::is('watchtower*')) active @endif">
                <a href="#"><i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li @if (Request::is('admin/users*')) class="active" @endif><a href="{{ adminUrl('users') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
                    <li @if (Request::is('watchtower*')) class="active" @endif><a href="{{ url('watchtower') }}"><i class="fa fa-gear"></i> <span>Security</span></a></li>
                </ul>
            </li>
            <li class="treeview @if (Request::is('admin/system*')) active @endif">
                <a href="#"><i class="fa fa-cog"></i> <span>System</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li @if (Request::is('admin/system/logs*')) class="active" @endif><a href="{{ adminUrl('system/logs') }}"><i class="fa fa-users"></i> <span>Log viewer</span></a></li>
                </ul>
            </li>
            @endrole
            <li class="header">For tests</li>
            <li @if (Request::is('admin/tv*')) class="active" @endif><a href="{{ adminUrl('tv') }}"><i class="fa fa-video-camera"></i> <span>TV ( YouTube )</span></a></li>
            <li><a href="{{ adminUrl('logout') }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
    
</aside>