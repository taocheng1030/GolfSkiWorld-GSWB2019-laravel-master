<div class="btn-group buttons">
    <a class="btn btn-default" href="{{ $edit }}">Edit</a>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu pull-right">
        @if(isset($menu))
            @foreach($menu as $key => $item)
                <li>
                    <a href="#{{ $key }}" class="{{ array_exist($item, 'class') }}" data-url="{{ array_exist($item, 'href') }}" data-method="{{ array_exist($item, 'method') }}">
                        {!! array_exist($item, 'label') !!}
                    </a>
                </li>
            @endforeach
            <li role="separator" class="divider"></li>
        @endif
        <li>
            <a href="#delete" class="action-delete" data-url="{{ $delete }}" data-method="DELETE" data-confirm="{{ trans('dashboard.CRUD.delete.confirm') }}">
                <i class="fa fa-times"></i>
                Delete item
            </a>
        </li>
    </ul>
</div>