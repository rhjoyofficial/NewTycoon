@extends('frontend.layouts.guest')

@section('title', 'Register')

@section('card-header', 'Create New Account')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Name') }}
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                autocomplete="name"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
            @error('name')
                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Email') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
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
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
            @error('password')
                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
        </div>

        <!-- Register Button -->
        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}"
                class="text-sm text-gray-600 hover:text-primary transition-colors duration-200 underline">
                {{ __('Already registered?') }}
            </a>
            <button type="submit"
                class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-md font-medium transition-colors duration-200">
                {{ __('Register') }}
            </button>
        </div>
    </form>
@endsection

@section('card-footer')
    <p class="text-sm text-gray-600">
        By registering, you agree to our
        <a href="{{ route('terms') }}" class="text-primary hover:underline">Terms of Service</a>
        and
        <a href="{{ route('privacy') }}" class="text-primary hover:underline">Privacy Policy</a>.
    </p>
@endsection
