<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{ isset($site->icon)?asset($site->icon):'' }}"/>
    @include('backend.layouts.includes.css')
    @yield('style')
</head>
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default"
data-kt-app-sidebar-minimize="{{ Route::currentRouteName() == 'store' ? 'on' : 'off' }}">
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @include('backend.layouts.includes.header')
        <div class="app-wrapper  flex-column flex-row-fluid" id="kt_app_wrapper">
            <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                    <a href="{{ route('dashboard') }}">
                        <img alt="Logo" src="{{ isset($site->logo)?asset($site->logo):asset('/assets/logo.webp') }}" class="h-50px app-sidebar-logo-default"/>
                        <img alt="Logo" src="{{ isset($site->logo)?asset($site->logo):asset('/assets/logo.webp') }}" class="ms-1 h-30px app-sidebar-logo-minimize"/>
                    </a>
                    <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                        <i class="ki-duotone ki-double-left fs-2 rotate-180"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                @include('backend.layouts.includes.menu')
            </div>
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div class="d-flex flex-column flex-column-fluid" id="kt_app_body1">
                    @yield('body')
                </div>
                @include('backend.layouts.includes.footer')
            </div>
        </div>
    </div>
</div>
@yield('modal')
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true"><i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i></div>
@include('backend.layouts.includes.js')
@yield('js_in')
@yield('js1')
@yield('js2')
@yield('js3')
@yield('js')
@if(Session::has('delete'))
    <script>
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    </script>
@endif
</body>
</html>
