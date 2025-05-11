@extends('layouts/blankLayout')
<x-guest-layout>

    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-8">
        <div class="mx-auto">
            <h2 class="text-2xl center justify bg-green-300 p-4 shadow-md rounded-lg mb-5">Register form for your new
                account
            </h2>
        </div>
        <form method="POST" action="{{ route('user.customer.register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name"
                    class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Phone -->
            <div class="mb-6">
                <input type="hidden" name="ref" value="{{ request()->query('ref') }}" />
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone"
                    class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    type="text" name="phone" :value="old('phone')" required autocomplete="phone" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Email Address -->
            <div class="mb-6">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email"
                    class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                    class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mt-4">
                <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>