@extends('auth.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ adminUrl('') }}"><b>GolfSki</b>World</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{ Form::open([
            'url' => adminUrl('password/email'),
            'role' => 'form',
        ]) }}

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="row">
                <div class="col-xs-8 col-xs-offset-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                    </button>
                </div>
                <!-- /.col -->
            </div>

        {{ Form::close() }}

        <a href="{{ adminUrl('login') }}" class="text-center">Back to login</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
