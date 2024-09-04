@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div style="width: 100%; max-width: 24rem; padding: 2rem; background-color: #1a202c; border-radius: 0.5rem; box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; font-size: 1.875rem; font-weight: bold; color: #ffffff; margin-bottom: 1.5rem;">{{ __('Reset Password') }}</h2>

        @if (session('status'))
            <div style="background-color: #38a169; color: white; padding: 0.5rem; border-radius: 0.375rem; margin-bottom: 1rem; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
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

            <div>
                <button type="submit" style="display: block; width: 100%; padding: 0.75rem; background-color: #4c51bf; color: white; border: none; border-radius: 0.375rem; font-size: 1rem; cursor: pointer;">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
