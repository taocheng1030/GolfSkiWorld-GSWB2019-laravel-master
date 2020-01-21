<li>
    <a data-url="{{ adminUrl('system/notification/markRead') }}" data-id="{{ $notification->id }}">
        <div class="action" style="display: none">
            <button class="btn btn-default btn-xs action-delete">Mark read</button>
        </div>
        <div class="time">
            <small><i class="fa fa-clock-o"></i> {!! $notification->date !!}</small>
        </div>
        {!! $notification->message !!}
    </a>
</li>

