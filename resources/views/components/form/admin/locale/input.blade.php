<div class="row form-group form-group-calspace @if($errors->has($name)) has-error @endif" @if($filedId) id='{{ $filedId }}' @endif>
    {{ Form::label($name, isset($label) ? $label : null, ['class' => 'col-sm-2 label-colspan-center']) }}
    <div class="col-sm-10">
        <!-- Nav tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#{{ $name }}_eng" aria-controls="{{ $name }}_eng" role="tab" data-toggle="tab">Eng</a>
                </li>
                <li role="presentation">
                    <a href="#{{ $name }}_local" aria-controls="{{ $name }}_local" role="tab" data-toggle="tab">Local</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="{{ $name }}_eng">
                    {{ Form::text($name, $value['eng'],
                        array_merge(['class' => 'form-control',
                            'placeholder' => isset($attributes['eng']['placeholder']) ? $attributes['eng']['placeholder'] : isset($label) ? $label : ucfirst($name),
                            'maxlength'=>$maxlength
                        ], isset($attributes['eng']) ? $attributes['eng'] : [])
                    ) }}
                    @if($errors->has($name))<span class="help-block">{{ $errors->first($name) }}</span>@endif
                </div>
                <div role="tabpanel" class="tab-pane" id="{{ $name }}_local">
                    {{ Form::text("local[$name]", $model ? $model->getLocalizedField($name) : null,
                        array_merge(['class' => 'form-control',
                            'placeholder' => isset($attributes['local']['placeholder']) ? $attributes['local']['placeholder'] : ucfirst($name) . ' in local',
                            'maxlength'=>$maxlength
                        ], isset($attributes['local']) ? $attributes['local'] : [])
                    ) }}
                </div>
            </div>
        </div>
    </div>
</div>
