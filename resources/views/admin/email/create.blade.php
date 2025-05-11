@extends('layouts/layoutMaster')

@section('title',  __('Send email'))
@section('vendor-style')
  @vite([
  'resources/assets/vendor/libs/quill/typography.scss',
  'resources/assets/vendor/libs/quill/katex.scss',
  'resources/assets/vendor/libs/quill/editor.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  ])
@endsection

@section('content')
  <div class="raw">
  <div class="col-md-12">
    <div class="card">
      <h5 class="card-header">Send email</h5>
      <hr class="m-0" />
      <div class="card-body">
        <form action="{{ route('users.email.send') }}" class="form" method="post">
          @csrf
          <div class="mt-2 mb-4">
            <label for="select2Basic" class="form-label">{{ __('select_user_group') }}</label>
            <select name="user_group" id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
              <option value="" >{{ __('select_user_group') }}</option>
              <option value="1" >Send Email to All Users</option>
              <option value="2" >Send Email to Single User</option>
              <option value="3" >Send Email to Multiple Users</option>
              <option value="4" >Send Email to All Paid Users</option>
              <option value="5" >Send Email to Monthly Subscribers</option>
              <option value="6" >Send Email to Monthly Subscription Inactive</option>
              <option value="7" >Send Email to Monthly Unsubscribers</option>
              <option value="8" >Send Email to With Balance</option>
              <option value="9" >Send Email to All Free Users</option>
              <option value="10" >Send Email to Banned Users</option>
              <option value="11" >Send Email to Email Unverified</option>
              <option value="12" >Send Email to KYC Unverified</option>
              <option value="13" >Send Email to KYC Pending</option>
              <option value="14" >Send Email to KYC Rejected</option>
              <option value="15" >Send Email to Number Unverified</option>

            </select>
          </div>
          <div class="mt-2 mb-4 user_email d-none">
            <label for="user_email" class="form-label">{{ __('select_user') }}</label>
            <select name="user_email" id="user_email" class="select2 form-select form-select-lg" data-allow-clear="true">
              <option value="" >{{ __('select_user') }}</option>
              @foreach($customers as $customer)
                <option value="{{ $customer->email }}" >{{ $customer->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-2 mb-4 user_emails d-none">
            <label for="user_emails" class="form-label">{{ __('select_user') }}</label>
            <select name="user_emails[]" id="user_emails" class="select2 form-select form-select-lg" data-allow-clear="true" multiple>
              <option value="" >{{ __('select_user') }}</option>
              @foreach($customers as $customer)
                <option value="{{ $customer->email }}" >{{ $customer->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-2 mb-4">
            <label for="subject" class="form-label">{{ __('subject') }}</label>
            <input id="subject" type="text" name="subject" class="form-control" placeholder="{{__('email_subject_placeholder')}}">
          </div>
          <div class="mt-2 mb-4">
            <label for="full-editor" class="form-label">{{ __('message') }}</label>
            <textarea id="full-editor" name="email_body" style="display:none;"></textarea>
            <div id="quill-editor"></div> <!-- New div to contain the Quill editor -->

          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button>
          </div>
        </form>
      </div>
      <hr class="m-0" />
    </div>
  </div>
  </div>
@endsection

@section('page-script')
  @vite([
  'resources/assets/vendor/libs/quill/katex.js',
  'resources/assets/vendor/libs/quill/quill.js',
  'resources/assets/js/qeditor.js',
  'resources/assets/js/emailcreate.js'
  ])
@endsection

