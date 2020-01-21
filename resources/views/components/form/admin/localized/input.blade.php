<div class="row form-group form-group-calspace">
    {{ Form::label($name['main'], isset($label) ? $label : null, ['class' => 'col-sm-2 label-colspan-center']) }}
    <div class="col-sm-10">
        <!-- Nav tabs -->
        <ul class="nav nav-pills" role="tablist">
            <li role="presentation" class="active">
                <a href="#{{ $name['main'] }}_main" aria-controls="{{ $name['main'] }}_main" role="tab" data-toggle="tab">Main</a>
            </li>
            @foreach ($languages as $language)
                <li role="presentation">
                    <a href="#{{ $name['main'] }}_{{ $language->id }}" aria-controls="{{ $name['main'] }}_{{ $language->id }}" role="tab" data-toggle="tab">{{ $language->name }}</a>
                </li>
            @endforeach
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="{{ $name['main'] }}_main">
                {{ Form::text($name['main'], $value['main'],
                    array_merge(['class' => 'form-control',
                        'placeholder' => isset($attributes['main']['placeholder']) ? $attributes['main']['placeholder'] : isset($label) ? $label : ucfirst($name['main'])
                    ], $attributes['main'])
                ) }}
            </div>
            @foreach ($languages as $language)
                <div role="tabpanel" class="tab-pane" id="{{ $name['main'] }}_{{ $language->id }}">
                    {{ Form::text($name['lang'].'['.$language->id.']', $model->getLocalizationField($name['main'], $language->id),
                        array_merge(['class' => 'form-control',
                            'placeholder' => isset($attributes['lang']['placeholder'][$language->id]) ? $attributes['lang']['placeholder'][$language->ig] : ucfirst($name['main']) . ' in ' . $language->name
                        ], $attributes['lang'])
                    ) }}
                </div>
            @endforeach
        </div>
    </div>
</div>
