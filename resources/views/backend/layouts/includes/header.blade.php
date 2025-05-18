<div id="kt_app_header" class="app-header">
    <div class="app-container  container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-0" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ isset($site->logo)?asset($site->logo):asset('/assets/logo.webp') }}" class="h-35px"/>
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                 data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                 data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
                         class="menu-item active menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                        <a href="{{ route('dashboard') }}">
                            <span class="menu-link"><span class="menu-title">Dashboard</span></span>
                        </a>
                    </div>
                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
                         class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                        <a href="{{ route('refresh') }}">
                            <span class="menu-link"><span class="menu-title">Refresh</span></span>
                        </a>
                    </div>
                </div>
            </div>
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <div class="app-navbar-item ms-1 ms-md-3">
                    <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                       data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                       data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-night-day theme-light-show fs-2 fs-lg-1">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                            <span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span>
                        </i>
                        <i class="ki-duotone ki-moon theme-dark-show fs-2 fs-lg-1">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                         data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-night-day fs-2">
                                        <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                                        <span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-moon fs-2">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img src="{{ asset(Auth::user()->avatar??'/assets/media/avatars/300-1.jpg') }}" alt="user"/>
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{ asset(Auth::user()->avatar??'/assets/media/avatars/300-1.jpg') }}"/>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ Auth::check() ? Auth::user()->name : 'User Name'}}
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::check() ? Auth::user()->email : 'default@gmail.com'}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5 text-danger" onclick="logout()">Sign Out</a>
                            <form action="{{ route('logout') }}" method="POST" id="logout_form">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                        <i class="ki-duotone ki-element-4 fs-1">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
