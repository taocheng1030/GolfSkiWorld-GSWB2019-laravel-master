<div class="model-movies-item">
    <div class="model-movies-item-image">
        <img src="{{ $file->thumbnail }}" alt="{{ $file->file }}" class="img-responsive">
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
    <div class="buttons">
        <div class="btn-group pull-left">
            @if(isset($buttons) && in_array('tags', $buttons))
        <button type="button" class="btn btn-default action-tags" role="button" data-id="{{ $file->video->id }}" data-url="{{ adminUrl('videos/tags') }}" title="{{ trans('dashboard.video.tag.title') }}">
                <i class="fa fa-tags" aria-hidden="true"></i>
            </button>
            @endif
            @if(isset($buttons) && in_array('awarded', $buttons))
                <button type="button" class="btn @if($file->video->awarded) btn-success @else btn-default @endif action-awarded" role="button" data-id="{{ $file->id }}" data-url="{{ adminUrl('videos/award') }}" data-confirm="{{ trans('dashboard.video.award.confirm') }}" title="{{ trans('dashboard.video.award.title') }}">
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                </button>
            @endif
            @if(isset($buttons) && in_array('promo', $buttons))
                <button type="button" class="btn @if($file->video->promo) btn-success @else btn-default @endif action-promo" role="button" data-id="{{ $file->id }}" data-url="{{ adminUrl('videos/promo') }}" data-confirm="{{ trans('dashboard.video.promo.confirm') }}" title="{{ trans('dashboard.video.promo.title') }}">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                </button>
            @endif
        </div>
        <div class="btn-group pull-right dropup">
            <a href="{{ $file->file }}" target="_blank" class="btn btn-default" role="button">View</a>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>

            <ul class="dropdown-menu pull-right">
                <li>
                    <a class="action-remove" role="button" data-id="{{ $file->id }}" data-url="{{ adminUrl('videos/delete') }}" data-confirm="{{ trans('dashboard.video.delete.confirm') }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Delete item
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>