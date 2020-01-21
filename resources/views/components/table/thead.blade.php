<thead>
<tr>
@foreach($fields as $col => $field)
    @if(\App\Http\Controllers\Controller::$pagination == true)
        @if (is_array($field))
            <th class="table-filter" style="@if(isset($field['options']) && isset($field['options']['style'])) {{ $field['options']['style'] }} @endif">
                @if(isset($field['sortable']) && $field['sortable'] === false)
                    {{ $field['label'] }}
                @else
                    {!! \App\Traits\Filter::link_to_sorting_action($col, $field['label']) !!}
                @endif
                @if(isset($field['filter']) && $field['filter'] == 'boolean')
                    {{ Form::select($col, [1 => 'Yes', 0 => 'No'], filterSelected('filter', $col), ['class' => 'form-control', 'placeholder' => '']) }}
                @endif
                @if(isset($field['filter']) && is_array($field['filter']))
                    {{ Form::select($col, $field['filter'], filterSelected('filter', $col), ['class' => 'form-control', 'placeholder' => '']) }}
                @endif
                @if(isset($field['filter']) && $field['filter'] == 'input')
                    {{ Form::text($col, filterSelected('filter', $col), ['class' => 'form-control']) }}
                @endif
            </th>
        @else
            <th class="table-filter">
                {!! \App\Traits\Filter::link_to_sorting_action($col, $field) !!}
            </th>
        @endif
    @else
        <th>
            {{ $field }}
        </th>
    @endif
@endforeach
</tr>
</thead>

@section('script')
<script src="{!! asset('vendor/uri/URI.min.js') !!}"></script>
<script>

    function setQueryURI(filter) {
        var filterName = 'filter[' + filter.attr('name') + ']';

        var url = new URI(window.location.href);
        url.normalizeQuery();

        if (url.hasQuery(filterName) === true) {
            url.removeQuery(filterName);
        }

        window.location.href = url.addSearch(filterName, filter.val());
    }

    var tableFilter = $('.table-filter');

    tableFilter.on('change', 'select', function (e) {
        e.preventDefault();
        setQueryURI($(this));
    });

    tableFilter.on('keypress', 'input', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13')
            setQueryURI($(this));

    })

</script>
@append
