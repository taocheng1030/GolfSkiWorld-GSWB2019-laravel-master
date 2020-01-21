<div class="row form-group form-group-calspace @if($errors->has($name)) has-error @endif" @if($filedId) id='{{ $filedId }}' @endif>
    {{ Form::label($name, isset($label) ? $label : null, ['class' => 'col-sm-2 label-colspan-center']) }}
    <div class="col-sm-10">
        @foreach($list as $id => $value)
            <div>
                {{ Form::checkbox($name."[]", $id, in_array($id, $checked)) }}
                {{$value}}
            </div>
        @endforeach
        @if($errors->has($name))<span class="help-block">{{ $errors->first($name) }}</span>@endif
    </div>
</div>