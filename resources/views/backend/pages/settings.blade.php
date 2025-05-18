@extends('backend.layouts.app')
@section('title', 'settings')
@section('body')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center mb-2">
                    Dashboard
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Settings</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container  container-xxl ">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Site All Settings</h3>
                    </div>
                </div>
                <div  class="collapse show">
                    <form action="{{ route('settings-update') }}" id="infoFormSubmit" method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label for="copyright" class="col-lg-4 col-form-label fw-semibold fs-6"><span class="">Has Reviewed</span></label>
                                <div class="col-lg-8 fv-row form-check form-switch form-check-custom form-check-solid">
                                    <input id="has_reviewed" class="form-check-input ms-5" type="checkbox" value="1" name="has_reviewed" {{ $setting->has_reviewed==1?'checked':'' }}/>
                                    <label class="form-check-label fs-5 fw-bold text-{{ $setting->has_reviewed==1?'success':'danger' }}" id="ns_text" for="status">{{ $setting->has_reviewed==1?'Yes':'No' }}</label>
                                    @error('has_reviewed')<div class="text-danger mt-2 ms-10">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label for="copyright" class="col-lg-4 col-form-label fw-semibold fs-6"><span class="">Show ReviewController</span></label>
                                <div class="col-lg-8 fv-row form-check form-switch form-check-custom form-check-solid">
                                    <input id="show_reviewController" class="form-check-input ms-5" type="checkbox" value="1" name="show_reviewController" {{ $setting->show_reviewController==1?'checked':'' }}/>
                                    <label class="form-check-label fs-5 fw-bold text-{{ $setting->show_reviewController==1?'success':'danger' }}" id="show_reviewController" for="status">{{ $setting->show_reviewController==1?'Yes':'No' }}</label>
                                    @error('show_reviewController')<div class="text-danger mt-2 ms-10">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label for="copyright" class="col-lg-4 col-form-label fw-semibold fs-6"><span class="">Show Disclaimer</span></label>
                                <div class="col-lg-8 fv-row form-check form-switch form-check-custom form-check-solid">
                                    <input id="show_disclaimer" class="form-check-input ms-5" type="checkbox" value="1" name="show_disclaimer" {{ $setting->show_disclaimer==1?'checked':'' }}/>
                                    <label class="form-check-label fs-5 fw-bold text-{{ $setting->show_disclaimer==1?'success':'danger' }}" id="show_disclaimer" for="show_disclaimer">{{ $setting->show_disclaimer==1?'Yes':'No' }}</label>
                                    @error('show_disclaimer')<div class="text-danger mt-2 ms-10">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label for="copyright" class="col-lg-4 col-form-label fw-semibold fs-6"><span class="">Force Update</span></label>
                                <div class="col-lg-8 fv-row form-check form-switch form-check-custom form-check-solid">
                                    <input id="force_update" class="form-check-input ms-5" type="checkbox" value="1" name="force_update" {{ $setting->force_update==1?'checked':'' }}/>
                                    <label class="form-check-label fs-5 fw-bold text-{{ $setting->force_update==1?'success':'danger' }}" id="force_update" for="force_update">{{ $setting->force_update==1?'Yes':'No' }}</label>
                                    @error('force_update')<div class="text-danger mt-2 ms-10">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <input type="submit" class="btn btn-primary data-submit" value="Save Changes">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function (){
            $('.data-submit').on('click', function (){
                event.preventDefault();
                Swal.fire({
                    title: 'Do you want to change site settings?' ,
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonText: 'Change',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#infoFormSubmit').submit();
                    }
                })
            });
        });
    </script>
@endsection
