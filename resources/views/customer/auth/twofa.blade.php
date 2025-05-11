@php
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')
@section('content')
  @include('layouts.partials.success-message')
  <div class="container">
    <div class="raw">
      <div class="col-md-8 offset-2">
        <div class="card pt-10 mt-10">
          <div class="card-body">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
              {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
              <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
              </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
              <form method="POST" action="{{ route('customer.2fa.verify') }}">
                @csrf
                <input type="text" autocomplete="false" name="code" class="form-control" placeholder="Verification code..." required />
                <div class="mt-3">
                  <button type="submit" class="btn btn-primary">{{ __('Verify') }}</button>
                </div>
              </form>
              <form method="POST" action="{{ route('customer.2fa.resend') }}">
                @csrf

                <div class="mt-3">
                  <button type="submit" class="btn btn-secondary">
                    {{ __('Resend Verification code') }}
                  </button>
                </div>
              </form>

              <form method="POST" action="{{ route('user.logout') }}">
                @csrf

                <button type="submit" class="btn btn-danger mt-3">
                  {{ __('Log Out') }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
