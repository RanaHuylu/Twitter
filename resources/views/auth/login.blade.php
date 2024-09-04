@extends('layouts.app')

@section('content')
<div style="display: flex; height: 100vh;">
    <!-- Sol Taraf: Logo -->
    <div style="flex: 1; display: flex; justify-content: center; align-items: center;">
        <img src="images/x-white.png" alt="Logo" style="max-width: 50%; height: auto;">
    </div>

    <!-- Sağ Taraf: Login Formu -->
    <div style="flex: 1; display: flex; justify-content: center; align-items: center; background-color: #000000;">
        <div style="width: 100%; max-width: 24rem; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);">
            <h2 style="text-align: center; font-size: 1.875rem; font-weight: bold; color: #ffffff; margin-bottom: 1.5rem;">{{ __('Login to your account') }}</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label for="email" style="display: none;">{{ __('Email Address') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="display: block; width: 100%; padding: 0.5rem; background-color: #2d3748; color: #e2e8f0; border: none; border-radius: 0.375rem; font-size: 1rem;" placeholder="{{ __('Email Address') }}">
                    @error('email')
                        <span style="color: #e53e3e; font-size: 0.875rem; display: block; margin-top: 0.25rem;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="password" style="display: none;">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" style="display: block; width: 100%; padding: 0.5rem; background-color: #2d3748; color: #e2e8f0; border: none; border-radius: 0.375rem; font-size: 1rem;" placeholder="{{ __('Password') }}">
                    @error('password')
                        <span style="color: #e53e3e; font-size: 0.875rem; display: block; margin-top: 0.25rem;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center;">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} style="width: 1rem; height: 1rem; background-color: #4c51bf; border: 1px solid #e2e8f0; border-radius: 0.25rem;">
                        <label for="remember" style="margin-left: 0.5rem; font-size: 0.875rem; color: #a0aec0;">{{ __('Remember Me') }}</label>
                    </div>

                    @if (Route::has('password.request'))
                        <div>
                            <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: #667eea; text-decoration: none;">{{ __('Forgot Your Password?') }}</a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" style="display: flex; justify-content: center; width: 100%; padding: 0.5rem; background-color: #4c51bf; color: #ffffff; border: none; border-radius: 0.375rem; font-size: 1rem; cursor: pointer;">{{ __('Login') }}</button>
                </div>
            </form>

            @if (Route::has('register'))
                <div style="text-align: center; margin-top: 1.5rem;">
                    <p style="color: #a0aec0;">{{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}" style="color: #667eea; text-decoration: none; font-weight: bold;">{{ __('Register') }}</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
