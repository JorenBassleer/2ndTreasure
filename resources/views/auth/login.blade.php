@extends('layouts.app')

@section('content')
<div class="login-page container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <h3 class="login-heading">{{ __('Login') }}</h3>

                        <div class="email-form form-group row">
                            <label for="email" class="label-email col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="email" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="password-form form-group row">
                            <label for="password" class="label-password col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="rememberme-from form-group row">
                            <div class="col-md-6">
                                <div class="form-check">

                                    <label class="form-check-label checkbox bounce" for="remember">
                                        {{ __('Remember Me') }}
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <svg viewBox="0 0 21 21">
                                            <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="login-from form-group row mb-0">
                            <div class="col-md-8">
                                <button type="submit" class="login-btn btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="register-form form-group row mb-0">
                            <div class="col-md-8 ">
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
