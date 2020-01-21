<div class="row form-group form-group-calspace @if($errors->has($name) || $errors->has($name.'_url')) has-error @endif" @if($filedId) id='{{ $filedId }}' @endif style="margin-bottom: 15px;">
    {{ Form::label($name, isset($label) ? $label : null, ['class' => 'col-sm-2 label-colspan-center']) }}
    <div class="col-sm-10">
        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            {{ Form::text($name.'_url', $value, ['class' => 'form-control', 'placeholder' => 'Movie link']) }}
            <div class="form-control" data-trigger="fileinput">
                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                <span class="fileinput-filename"></span>
            </div>
            <span class="input-group-addon btn btn-default btn-file">
                <span class="fileinput-new"><span class="fa fa-folder-open"></span> Browse movie</span>
                <span class="fileinput-exists"><span class="fa fa-folder-open"></span> Change</span>
                {{ Form::file($name) }}
            </span>
            <a class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">
                <span class="fa fa-times"></span>
                Remove
            </a>
        </div>
        @if($errors->has($name.'_url'))<span class="help-block">{{ $errors->first($name.'_url') }}</span>@endif
        @if($errors->has($name))<span class="help-block">{{ $errors->first($name) }}</span>@endif
    </div>
</div>