@extends('layouts.auth')
@section('title', 'Login')
@section('form')
    <form class="js-validation-signin" action="" method="POST">
        @csrf
        <h2 class="h5 fw-medium text-muted mb-5 text-center">Please sign in</h2>
        <div class="form-floating mb-4">
            <input type="text" class="form-control" id="login-username" name="username"
                placeholder="Enter your username">
            <label class="form-label" for="login-username">Username/Email</label>
            @if ($errors->has('username'))
                <span class="text-danger">{{ $errors->first('username') }}</span>
            @endif
        </div>
        <div class="form-floating mb-4">
            <input type="password" class="form-control" id="login-password" name="password"
                placeholder="Enter your password">
            <label class="form-label" for="login-password">Password</label>
            @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label for="remember" class="form-check-label">Remember me</label>
        </div>
        <div class="row g-sm mb-4">
            <div class="col-12 mb-2">
                <button type="submit" class="btn btn-lg btn-alt-primary w-100 py-3 fw-semibold">
                    Sign In
                </button>
            </div>
            <div class="col-sm-12 mb-1">
                <a class="btn btn-alt-secondary w-100" href="op_auth_reminder.html">
                    Forgot password
                </a>
            </div>
        </div>
    </form>
@endsection
