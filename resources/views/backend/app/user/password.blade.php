@extends('backend.app.user.app')
@section('title', 'change password')
@section('content')
    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Change Password</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row">
                <div class="col-md-8 mx-auto p-5 shadow">
                    <form action="{{ route('user.password', encrypt($user->id)) }}" method="POST">
                        @csrf
                        <div class="row mb-7 mt-5">
                            <label for="password" class="required fs-6 fw-semibold mb-2 col-4">Password</label>
                            <div class="col-8">
                                <input type="password" id="password" class="form-control form-control-solid" placeholder="new password"
                                       name="password" value="{{ old('password') }}"/>
                                @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row mb-7 mt-5">
                            <label for="confirm_password" class="required fs-6 fw-semibold mb-2 col-4">Confirm Password</label>
                            <div class="col-8">
                                <input type="password" id="confirm_password" class="form-control form-control-solid" placeholder="confirm password"
                                       name="confirm_password" value="{{ old('confirm_password') }}"/>
                                @error('confirm_password')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="modal-footer flex-center mt-5">
                            <button type="submit" onclick="this.disabled=true; this.form.submit()"  id="kt_modal_add_customer_submit1" class="btn btn-primary">
                                <span class="indicator-label" id="submit_btn">Change</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
