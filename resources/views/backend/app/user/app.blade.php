@extends('backend.layouts.app')
@section('body')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
        <div id="kt_app_toolbar_container" class="app-container   d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0 mb-2">
                    User Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">User</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div id="kt_app_content_container" class="app-container   ">
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative shadow">
                                <img src="{{ asset($user->avatar??'blank.jpg') }}" alt="image"/>
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 {{ $user->status == 1 ? 'bg-success rounded-circle border border-4 border-body h-20px w-20px' : '' }}"></div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                            {{ $user->name }}
                                        </a>
                                        @if($user->is_active == 1)
                                            <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i></a>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        @if($user->gender)
                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-user fs-4 me-1">
                                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                                </i>
                                                {{ $user->gender }}
                                            </a>
                                        @endif
                                        @if($user->birthdate)
                                            <a href="#"
                                               class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-calendar-2 fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>
                                                {{ \App\Helper\Helper::calculateAge($user->birthdate) }}
                                            </a>
                                        @endif
                                        <a href="#"
                                           class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-sms fs-4 me-1"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                            {{ $user->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <!--begin::BP Records-->
                                        <div class="border border-gray-300 text-center border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold mx-auto" data-kt-countup="true"
                                                     data-kt-countup-value="{{ \App\Models\BloodPressure::where('user_id', $user->id)->count() }}">0
                                                </div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-400">Total BP Records</div>
                                        </div>
                                        <!--begin::Sugar Record-->
                                        <div class="border border-gray-300 text-center border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold mx-auto" data-kt-countup="true"
                                                     data-kt-countup-value="{{ \App\Models\BloodSugar::where('user_id', $user->id)->count() }}">0
                                                </div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-400">Total Sugar Records</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <li class="nav-item mt-2">
                            <a href="{{ route('users.show', encrypt($user->id)) }}" class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::currentRouteName() == 'users.show'?'active':'' }}">Overview</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a href="{{ route('users.all-bp', encrypt($user->id)) }}" class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::currentRouteName() == 'users.all-bp'?'active':'' }}">BP Records</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a href="{{ route('users.all-sugar', encrypt($user->id)) }}" class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::currentRouteName() == 'users.all-sugar'?'active':'' }}">Sugar Records</a>
                        </li>
                    </ul>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
@endsection
