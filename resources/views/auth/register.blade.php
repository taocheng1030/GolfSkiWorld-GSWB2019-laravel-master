@extends('auth.app')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ adminUrl('') }}"><b>GolfSki</b>World</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        {{ Form::open([
            'url' => adminUrl('register'),
            'role' => 'form',
        ]) }}

            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) }}
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('language') ? 'has-error' : '' }}">
                {{ Form::select('language', $languages->lists('name', 'id'), old('language'), ['class' => 'form-control', 'placeholder' => 'Language']) }}
                @if ($errors->has('language'))
                    <span class="help-block">
                        <strong>{{ $errors->first('language') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('country') ? 'has-error' : '' }}">
                {{ Form::select('country', $countries->lists('name', 'id'), old('country'), ['id' => 'countryId', 'class' => 'form-control countries', 'placeholder' => 'Countries']) }}
                @if ($errors->has('country'))
                    <span class="help-block">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('state') ? 'has-error' : '' }}">
                {{ Form::select('state', $states->lists('name', 'id'), old('state'), ['id' => 'stateId', 'class' => 'form-control states', 'placeholder' => 'States']) }}
                @if ($errors->has('state'))
                    <span class="help-block">
                        <strong>{{ $errors->first('state') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('city') ? 'has-error' : '' }}">
                {{ Form::select('city', $cities->lists('name', 'id'), old('city'), ['id' => 'cityId', 'class' => 'form-control cities', 'placeholder' => 'Cities']) }}
                @if ($errors->has('city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('address') ? 'has-error' : '' }}">
                {{ Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => 'Address']) }}
                <span class="glyphicon glyphicon-home form-control-feedback"></span>
                @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('zip') ? 'has-error' : '' }}">
                {{ Form::text('zip', old('zip'), ['class' => 'form-control', 'placeholder' => 'Zip code']) }}
                <span class="glyphicon glyphicon-home form-control-feedback"></span>
                @if ($errors->has('zip'))
                    <span class="help-block">
                        <strong>{{ $errors->first('zip') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                {{ Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Phone']) }}
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    {{--<div class="checkbox icheck">--}}
                        {{--<label>--}}
                            {{--<input type="checkbox">--}}
                            {{--I agree to the <a href="#">terms</a>--}}
                        {{--</label>--}}
                    {{--</div>--}}
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>

        {{ Form::close() }}

        <a href="{{ adminUrl('login') }}" class="text-center">I already have a membership</a>

    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
@endsection

@section('header')
    <style>
        .register-box {
            margin: 3% auto;
        }
    </style>
@endsection