<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                <a href="{{ route('dashboard') }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-element-11 fs-2">
                                <span class="path1"></span><span class="path2"></span>
                                <span class="path3"></span><span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dashboards</span>
                    </span>
                </a>
            </div>

            <div class="menu-item menu-accordion">
                <a href="{{ route('users.index') }}">
                    <span class="menu-link {{ (in_array(Route::currentRouteName(), ['users.index','users.show','users.filter'])) ? 'active':'' }}">
                        <span class="menu-icon"><i class="ki-duotone ki-user-square fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <span class="menu-title">Users</span>
                    </span>
                </a>
            </div>

{{--            <div class="menu-item menu-accordion">--}}
{{--                <a href="{{ route('blood-pressures.index') }}">--}}
{{--                    <span class="menu-link {{ (in_array(Route::currentRouteName(), ['blood-pressures.index','blood-pressures.filter'])) ? 'active':'' }}">--}}
{{--                        <span class="menu-icon"><i class="ki-duotone ki-abstract-1 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>--}}
{{--                        <span class="menu-title">Blood Pressure</span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </div>--}}

{{--            <div class="menu-item menu-accordion">--}}
{{--                <a href="{{ route('blood-sugars.index') }}">--}}
{{--                    <span class="menu-link {{ (in_array(Route::currentRouteName(), ['blood-sugars.index','blood-sugars.filter'])) ? 'active':'' }}">--}}
{{--                        <span class="menu-icon"><i class="ki-duotone ki-abstract-2 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>--}}
{{--                        <span class="menu-title">Blood Sugar</span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </div>--}}

            <div class="menu-item here show menu-accordion mt-7">
                <span class="menu-link">
                    <span class="menu-title fs-5">Admin</span>
                </span>
            </div>
            <div class="menu-item menu-accordion">
                <a href="{{ route('sugar-units.index') }}">
                    <span class="menu-link {{ Route::currentRouteName()=='sugar-units.index' ? 'active':'' }}">
                        <span class="menu-icon"><i class="ki-duotone ki-abstract-2 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <span class="menu-title">Sugar Unit</span>
                    </span>
                </a>
            </div>
            <div class="menu-item menu-accordion">
                <a href="{{ route('water-units.index') }}">
                    <span class="menu-link {{ Route::currentRouteName()=='water-units.index' ? 'active':'' }}">
                        <span class="menu-icon"><i class="ki-duotone ki-abstract-2 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <span class="menu-title">Water Unit</span>
                    </span>
                </a>
            </div>
            <div class="menu-item menu-accordion">
                <a href="{{ route('weight-units.index') }}">
                    <span class="menu-link {{ Route::currentRouteName()=='weight-units.index' ? 'active':'' }}">
                        <span class="menu-icon"><i class="ki-duotone ki-abstract-2 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <span class="menu-title">Weight Unit</span>
                    </span>
                </a>
            </div>
            <div class="menu-item menu-accordion">
                <a href="{{ route('feeling-lists.index') }}">
                    <span class="menu-link {{ Route::currentRouteName()=='feeling-lists.index' ? 'active':'' }}">
                        <span class="menu-icon"><i class="ki-duotone ki-abstract-2 fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
                        <span class="menu-title">Feeling Lists</span>
                    </span>
                </a>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ in_array(Route::currentRouteName(),['vlogs.index','notification-days.index','sugar-types.index','sugar-units.index','settings','settings.data','settings.value'])?'show':'' }}">
                <span class="menu-link">
                    <span class="menu-icon"><i class="ki-duotone ki-setting-2 fs-2"><span class="path1"></span><span class="path2"></span></i></span>
                    <span class="menu-title">Settings</span><span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ Route::currentRouteName()=='sugar-units.index'?'active':'' }}" href="{{ route('sugar-units.index') }}">--}}
{{--                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>--}}
{{--                            <span class="menu-title">Sugar Units</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ Route::currentRouteName()=='sugar-types.index'?'active':'' }}" href="{{ route('sugar-types.index') }}">--}}
{{--                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>--}}
{{--                            <span class="menu-title">Sugar Types</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ Route::currentRouteName()=='notification-days.index'?'active':'' }}" href="{{ route('notification-days.index') }}">--}}
{{--                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>--}}
{{--                            <span class="menu-title">Notification Days</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ Route::currentRouteName()=='vlogs.index'?'active':'' }}" href="{{ route('vlogs.index') }}">--}}
{{--                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>--}}
{{--                            <span class="menu-title">Vlog Links</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ Route::currentRouteName()=='settings'?'active':'' }}" href="{{ route('settings') }}">--}}
{{--                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>--}}
{{--                            <span class="menu-title">Settings</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ Route::currentRouteName()=='settings.data'?'active':'' }}" href="{{ route('settings.data') }}">--}}
{{--                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>--}}
{{--                            <span class="menu-title">Site Data</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="menu-item">--}}
{{--                        <a class="menu-link {{ Route::currentRouteName()=='settings.value'?'active':'' }}" href="{{ route('settings.value') }}">--}}
{{--                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>--}}
{{--                            <span class="menu-title">Site Value</span>--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
