@extends('backend.layouts.app')
@section('title', 'site data')
@section('body')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 mb-2 flex-column justify-content-center my-0">
                    Site Data
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a href="{{ route('home') }}" class="text-muted text-hover-primary">Home </a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Site Data</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container  container-xxl ">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Site All Data</h3>
                    </div>
                </div>
                <div  class="collapse show">
                    <form action="{{ route('settings.data-update') }}" id="infoFormSubmit" method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Favicon</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px"
                                             style="background-image: url({{ file_exists($setting->icon) ? asset($setting->icon) : '' }})">
                                        </div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" title="Change Favicon" data-kt-image-input-action="change" data-bs-toggle="tooltip">
                                            <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                            <input type="file" name="favicon" accept="image/*"/>
                                        </label>
                                        @error('favicon')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Logo</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px"
                                             style="background-image: url({{ file_exists($setting->logo) ? asset($setting->logo) : '' }})">
                                        </div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" title="Change Seal" data-kt-image-input-action="change" data-bs-toggle="tooltip">
                                            <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                            <input type="file" name="logo" accept="image/*"/>
                                        </label>
                                        @error('logo')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Report Icon</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px"
                                             style="background-image: url({{ file_exists($setting->report_icon) ? asset($setting->report_icon) : '' }})">
                                        </div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" title="Change Report Icon" data-kt-image-input-action="change" data-bs-toggle="tooltip">
                                            <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                            <input type="file" name="report_icon" accept="image/*"/>
                                        </label>
                                        @error('footer_icon')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label for="copyright" class="col-lg-4 col-form-label fw-semibold fs-6"><span class="required">Footer copyright text</span></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="footer_text" class="form-control form-control-lg form-control-solid"
                                           placeholder="Footer copyright text" value="{{ old('footer_text')??$setting->footer }}" id="copyright"/>
                                    @error('footer_text')<div class="text-danger mt-2">{{ $message }}</div>@enderror
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
                    title: 'Do you want to change site data?' ,
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
