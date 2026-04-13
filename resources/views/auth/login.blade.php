@extends('frontend.layouts.guest')

@section('title', 'Login')

@section('card-header', 'Welcome Back')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Email') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="email"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
            @error('email')
                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Password') }}
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
            @error('password')
                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-primary shadow-sm focus:ring-0">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="flex items-center justify-between">
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="text-sm text-gray-600 hover:text-primary transition-colors duration-200 underline">
                    {{ __('Need an account?') }}
                </a>
            @endif
            <button type="submit"
                class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md font-medium transition-colors duration-200">
                {{ __('Login') }}
            </button>
        </div>
    </form>
@endsection

@section('additional-links')
    <!-- Social Login (Optional) -->
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            <!-- Google Button (Disabled State) -->
            <a href="{{ route('login.google') }}" aria-disabled="true"
                class="pointer-events-none opacity-50 cursor-not-allowed w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700">
                <i class="fab fa-google text-red-500 mr-2" aria-hidden="true"></i>
                Google
            </a>

            <!-- Facebook Button (Disabled State) -->
            <a href="{{ route('login.facebook') }}" aria-disabled="true"
                class="pointer-events-none opacity-50 cursor-not-allowed w-full inline-flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700">
                <i class="fab fa-facebook text-blue-600 mr-2" aria-hidden="true"></i>
                Facebook
            </a>
        </div>

    </div>
@endsection
