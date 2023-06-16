@extends('layouts.ext-layout')

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="login"><b>Admin</b>LTE</a>
    </div>

    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fa fa-ban"></i>{{ session('error') }}</h5>
        </div>
    @endif
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group has-feedback">
                <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="email" value="{{ old('email') }}">
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            @error('email')
                <div class="form-group has-error">
                    <span class="help-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror

            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @error('password')
                <div class="form-group has-error">
                    <span class="help-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            @enderror
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label><input type="checkbox" name="remember"> Remember Me</label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
        </form>
        {{-- @if (Route::has('password.request'))
           <a class="btn btn-link" href="{{ route('password.request') }}">
               {{ __('I forgot my password') }}
            </a>
        @endif --}}
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

@endsection
