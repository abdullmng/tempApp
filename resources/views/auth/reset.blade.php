@extends('layouts.auth')
@section('title', 'Password Reset')
@section('form')
<form class="js-validation-signin" action="" method="POST">
    @csrf
    <h2 class="h5 fw-medium text-muted mb-5 text-center">Please reset your password</h2>
    <input type="hidden" name="email" value="{{ request()->get('email') }}">
    <input type="hidden" name="token" value="{{ request()->token }}">
    <div class="form-floating mb-4">
        <input type="password" class="form-control" id="password" name="password"
            placeholder="Enter your new password">
        <label class="form-label" for="password">Password</label>
        @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div class="form-floating mb-4">
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            placeholder="Enter your new password again">
        <label class="form-label" for="password_confirmation">Password Confirmation</label>
    </div>
    
    <div class="row g-sm mb-4">
        <div class="col-12 mb-2">
            <button type="submit" class="btn btn-lg btn-alt-primary w-100 py-3 fw-semibold">
                Update Password
            </button>
        </div>
        <div class="col-sm-12 mb-1">
            <a class="btn btn-alt-secondary w-100" href="{{ route('login') }}">
                Back to login
            </a>
        </div>
    </div>
</form>
@endsection