@extends('layouts.guest')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2>
        <center>Admin Login</center>
    </h2>
    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
        @csrf
        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ trans('user.email') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required
                autofocus autocomplete="username">
            @if ($errors->has('email'))
                <div class="text-danger mt-2">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control" type="password" name="password" required
                autocomplete="current-password">
            @if ($errors->has('password'))
                <div class="text-danger mt-2">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
        </div>

        <!-- Forgot Password Link and Submit Button -->
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Log in') }}
            </button>
        </div>

    </form>
@endsection
