@extends('auth.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ adminUrl('') }}"><b>GolfSki</b>World</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Login</p>

        {{ Form::open([
            'url' => adminUrl('login'),
            'role' => 'form',
        ]) }}

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input id="password" type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="fa fa-btn fa-sign-in"></i> Login
                    </button>
                </div>
                <!-- /.col -->
            </div>

        {{ Form::close() }}

        <a href="{{ adminUrl('password/reset') }}">I forgot my password</a><br>
        <a href="{{ adminUrl('register') }}" class="text-center">Register a new membership</a>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection
