@extends('layouts/layoutMaster')

@section('title',  __('switch_membership'))
@section('page-style')
  <!-- Page -->
  @vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  ])
@endsection

@section('content')
  <div class="col-md-6">
    <div class="card">
      <h5 class="card-header">{{ __('switch_subscription') }}</h5>
      <hr class="m-0" />
      <div class="card-body">
        <form action="{{ route('users.subscription.update') }}" class="form" method="post">
          @csrf
        <div class="mt-2 mb-4">
          <label for="select2Basic" class="form-label">{{ __('select_user') }}</label>
          <select name="user_id" id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
            <option value="" >{{ __('select_user') }}</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        </div>
          <div class="mt-2 mb-4">
            <label for="largeSelect" class="form-label">{{ __('select_package') }}</label>
            <select name="package_id" id="largeSelect" class="select2 form-select form-select-lg">
              <option value="">{{ __('select_package') }}</option>
              @foreach($packages as $package)
                <option value="{{ $package->id }}">{{ $package->name }}</option>
              @endforeach
            </select>
          </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('update') }}</button>
        </div>
        </form>
      </div>
      <hr class="m-0" />
    </div>
  </div>
@endsection
{{--@section('vendor-script')--}}
{{--  @vite([--}}
{{--  'resources/assets/vendor/libs/select2/select2.js',--}}
{{--  ])--}}
{{--@endsection--}}

