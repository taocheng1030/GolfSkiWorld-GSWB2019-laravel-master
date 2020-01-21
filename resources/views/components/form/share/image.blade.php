@if($value !="")
    <div class="row form-group form-group-calspace" @if($filedId) id='{{ $filedId }}' @endif>
        {{ Form::label($name, isset($label) ? $label : null, ['class' => 'col-sm-2 label-colspan-center']) }}
        <div class="col-sm-10">
            <img src="{{ $value }}" class="img-thumbnail" width="304" height="236">
        </div>
    </div>
@endif