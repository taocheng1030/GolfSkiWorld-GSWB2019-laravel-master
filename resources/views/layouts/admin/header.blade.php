<header class="main-header">

    <!-- Logo -->
    <a href="{{ adminUrl('') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>GS</b>W</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>GolfSki</b>World</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages menu-->
                @include('layouts.admin.header.messages')
                <!-- Notifications Menu -->
                @include('layouts.admin.header.files')
                <!-- Notifications Menu -->
                @include('layouts.admin.header.notifications')
                <!-- Tasks Menu -->
                @include('layouts.admin.header.tasks')
                <!-- User Account Menu -->
                @include('layouts.admin.header.account')
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>