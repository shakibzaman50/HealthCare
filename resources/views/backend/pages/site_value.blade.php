@extends('backend.layouts.app')
@section('title', 'site value')
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
                    <li class="breadcrumb-item text-muted">Site Value</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container  container-xxl ">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Site All Value</h3>
                    </div>
                </div>
                <div  class="collapse show">
                    <form action="{{ route('settings.value-update') }}" id="infoFormSubmit" method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label for="bp_paginate" class="col-lg-4 col-form-label fw-semibold fs-6"><span class="required">Blood Pressure Paginate</span></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="bp_paginate" class="form-control form-control-lg form-control-solid"
                                           placeholder="bp paginate value" value="{{ old('bp_paginate')??$setting->bp_paginate }}" id="bp_paginate"/>
                                    @error('bp_paginate')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label for="bs_paginate" class="col-lg-4 col-form-label fw-semibold fs-6"><span class="required">Blood Sugar Paginate</span></label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="bs_paginate" class="form-control form-control-lg form-control-solid"
                                           placeholder="bs paginate value" value="{{ old('bs_paginate')??$setting->bs_paginate }}" id="bs_paginate"/>
                                    @error('bs_paginate')<div class="text-danger mt-2">{{ $message }}</div>@enderror
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
                    title: 'Do you want to change site value?' ,
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
