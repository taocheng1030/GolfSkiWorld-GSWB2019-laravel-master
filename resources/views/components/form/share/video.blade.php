@if($value !="")
    <div class="row form-group form-group-calspace" @if($filedId) id='{{ $filedId }}' @endif>
        {{ Form::label($name, isset($label) ? $label : null, ['class' => 'col-sm-2 label-colspan-center']) }}
        <div class="col-sm-10">
            {{ $value }}
        </div>
    </div>
@endif