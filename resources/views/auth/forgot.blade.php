@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('form')
<form class="js-validation-signin" action="" method="POST">
    @csrf
    <h2 class="h5 fw-medium text-muted mb-5 text-center">Enter your email address and we will send you steps to reset your password</h2>
    <div class="form-floating mb-4">
        <input type="email" class="form-control" id="login-email" name="email"
            placeholder="Enter your email">
        <label class="form-label" for="login-email">Email</label>
        @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif
    </div>
    @if (session()->has('status'))
        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        
            {{ session('status') }}
        </div>
        
    @endif
    <div class="row g-sm mb-4">
        <div class="col-12 mb-2">
            <button type="submit" class="btn btn-lg btn-alt-primary w-100 py-3 fw-semibold">
                Request Reset Link
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