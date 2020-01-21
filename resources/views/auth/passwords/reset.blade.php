@extends('auth.app')

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="{{ adminUrl('') }}"><b>GolfSki</b>World</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>

        {{ Form::open([
            'url' => adminUrl('password/reset'),
            'role' => 'form',
        ]) }}

        {{ Form::hidden('token', $token) }}

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', $email ? $email : old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
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

            <div class="row">
                <div class="col-xs-6 col-xs-offset-6">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="fa fa-btn fa-refresh"></i> Reset Password
                    </button>
                </div>
                <!-- /.col -->
            </div>

        {{ Form::close() }}

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
