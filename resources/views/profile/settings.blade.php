{{ Form::model($user, [
    'action' => ['Auth\ProfileController@save'],
    'data-toggle' => 'validator',
    'role' => 'form',
    'class' => 'form-horizontal form-profile',
    'id' => 'form-Profile'
]) }}

    <div class="row form-group">
        {{ Form::label('name', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('email', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('firstname', 'First name', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('firstname', old('firstname') ? old('firstname') : $user->profile->firstname, ['class' => 'form-control', 'placeholder' => 'First name']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('lastname', 'Last name', ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('lastname', old('lastname') ? old('lastname') : $user->profile->lastname, ['class' => 'form-control', 'placeholder' => 'Last name']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('address', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('address', old('address') ? old('address') : $user->profile->address, ['class' => 'form-control', 'placeholder' => 'Address']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('zip', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('zip', old('zip') ? old('zip') : $user->profile->zip, ['class' => 'form-control', 'placeholder' => 'Zip']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('phone', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('phone', old('phone') ? old('phone') : $user->profile->phone, ['class' => 'form-control', 'placeholder' => 'Phone']) }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('newsletter', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10" style="padding-top: 5px;">
            {{ Form::checkbox('newsletter') }}
        </div>
    </div>

    <div class="row form-group">
        {{ Form::label('notify', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10" style="padding-top: 5px;">
            {{ Form::checkbox('notify') }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::button('Update', ['class' => 'btn btn-success action-update', 'type' => 'button']) !!}
        </div>
    </div>

{{ Form::close() }}