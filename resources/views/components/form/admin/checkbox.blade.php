<div class="row form-group form-group-calspace @if($errors->has($name)) has-error @endif" @if($filedId) id='{{ $filedId }}' @endif>
    {{ Form::label($name, isset($label) ? $label : null, ['class' => 'col-sm-2 label-colspan-center']) }}
    <div class="col-sm-10">
        {{ Form::checkbox($name) }}
    </div>
</div>