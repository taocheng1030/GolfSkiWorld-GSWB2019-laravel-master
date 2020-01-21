{{ Form::open([
    'action' => 'Auth\ProfileController@password',
    'role' => 'form',
    'class' => 'form-horizontal form-profile',
    'id' => 'form-Password'
]) }}

    <div class="row form-group">
        {{ Form::label('old', 'Old password', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::password('old', ['class' => 'form-control', 'placeholder' => 'Old password']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('new', 'New password', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::password('new', ['class' => 'form-control', 'placeholder' => 'New password']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('new_confirmation', 'Password confirmation', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::password('new_confirmation', ['class' => 'form-control', 'placeholder' => 'Password confirmation']) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::button('Update', ['class' => 'btn btn-success action-update', 'type' => 'button']) !!}
        </div>
    </div>

{{ Form::close() }}