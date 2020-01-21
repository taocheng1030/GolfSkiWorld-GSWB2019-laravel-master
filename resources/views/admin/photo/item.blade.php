<div class="model-gallery-item">
    <div class="model-gallery-item-image">
        <img src="{{ $file->file }}" alt="{{ $file->file }}" class="img-responsive">
    </div>
    <div class="caption">
        @if(isset($owner->name))
            <div class="name">{{ $owner->name }}</div>
        @endif
        @if(isset($owner->email))
            <div class="email">{{ HTML::mailto($owner->email) }}</div>
        @endif
        <p>{{ $file->description }} </p>
    </div>
    @if(!isset($withoutButtons))
    <div class="buttons">
        <div class="btn-group pull-right dropup">
            <button type="button" class="btn @if(isset($isThumbnail) && $isThumbnail) btn-success @else btn-default @endif action-thumbnail left" role="button" data-id="{{ $file->id }}" data-url="{{ adminUrl('photos/thumbnail') }}" data-confirm="{{ trans('dashboard.photo.thumbnail.confirm') }}" title="{{ trans('dashboard.photo.thumbnail.title') }}">
                <i class="fa fa-desktop" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a class="action-remove" role="button" data-id="{{ $file->id }}" data-url="{{ adminUrl('photos/delete') }}" data-confirm="{{ trans('dashboard.photo.delete.confirm') }}">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        Delete item
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @endif
</div>