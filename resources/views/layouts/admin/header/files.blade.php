<li class="dropdown notifications-menu notification-files">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-video-camera"></i>
        <span class="label label-warning">@if($notifications->count()) {{ $notifications->count() }} @endif</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">
        @if($notifications->count())
            @choice('dashboard.header.notifications.total', $notifications->count(), ['total' => $notifications->count()])
        @else
            @lang('dashboard.header.notifications.noMessages')
        @endif
        </li>
        <li>
            <ul class="menu">
            @if($notifications->count())
            @foreach($notifications as $notification)
                @include('layouts.admin.header.files-item', $notification)
            @endforeach
            @endif
            </ul>
        </li>
        <li class="footer" style="@if(!$notifications->count()) display:none; @endif">
            <a href="#markRead" data-url="{{ adminUrl('system/notification/markRead') }}">
                @lang('dashboard.header.notifications.readAll')
            </a>
        </li>
    </ul>
</li>
