<div class="model-movies-item model-file-item">
    <div class="model-movies-item-image">
        <img src="{{ $file->thumbnail }}" alt="{{ $file->file }}" class="img-responsive">
    </div>
    <div class="caption">
        @if(isset($owner->name))
            <div class="name">
                {{ $owner->name }}
                <a href="{{ adminUrl($owner->getModelName(true, true) . DIRECTORY_SEPARATOR . $owner->id . DIRECTORY_SEPARATOR . 'edit') }}">
                    <i class="fa fa-link"></i>
                </a>
            </div>
        @endif
        @if(isset($owner->email))
            <div class="email">{!! mailTo($owner->email) !!}</div>
        @endif
        <p>{{ $file->description }} </p>
    </div>
    <div class="buttons">
        <div class="model-movies-item-name">
            <span class="label label-primary">{{ $owner->getModelName(false) }}</span>
        </div>

        <div class="btn-group pull-right dropup">
            <a href="{{ $file->file }}" target="_blank" class="btn btn-default" role="button">View</a>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>

            <ul class="dropdown-menu pull-right">
                <li>
                    <a class="action-trash" role="button" data-id="{{ $file->id }}" data-url="{{ adminUrl('videos/trash/restore') }}" data-confirm="{{ trans('dashboard.video.trash.confirm') }}">
                        <i class="fa fa-undo" aria-hidden="true"></i>
                        Restore
                    </a>
                </li>
                <li>
                    <a class="action-trash" role="button" data-id="{{ $file->id }}" data-url="{{ adminUrl('videos/trash/delete') }}" data-confirm="{{ trans('dashboard.video.forever.confirm') }}">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Delete forever
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>