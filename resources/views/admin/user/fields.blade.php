    {{ Form::adminInput('name', old('name')) }}

    {{ Form::adminInput('email', old('email')) }}

    {{ Form::adminInput('password', '') }}

    @if(is_null($model))
        {{ Form::adminSelect('role', $roles->lists('name', 'id'), old('role'), 'Type', ['id' => 'ddlSelectHotel', 'placeholder' => 'None']) }}
    @else
        {{ Form::adminSelect('role', $roles->lists('name', 'id'), $model->roles()->first() ? $model->roles()->first()->id : '', 'Type', ['id' => 'ddlSelectHotel', 'placeholder' => 'None']) }}
    @endif

