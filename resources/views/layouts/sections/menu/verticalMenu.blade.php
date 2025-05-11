@php
use Illuminate\Support\Facades\Route;
use App\Models\GlobalSetting;
$configData = Helper::appClasses();
$global_setting = GlobalSetting::where('id',1)->first()
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <!-- Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      @if(isset($globalSetting))
      <span><img src="{{ asset('storage/' . $globalSetting->logo) }}" alt="" class="admin-logo"
          style="width: 50%"></span>
      @endif
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
    </a>
  </div>
  @endif

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)
    {{-- Menu headers --}}
    @if (isset($menu->menuHeader))
    <li class="menu-header small">
      <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
    </li>
    @else
    {{-- Check permission for main menu --}}
    @if (!isset($menu->can) || (auth()->check() && auth()->user()->can($menu->can)))
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    if ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    } elseif (isset($menu->submenu)) {
    if (is_array($menu->slug)) {
    foreach ($menu->slug as $slug) {
    if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
    $activeClass = 'active open';
    }
    }
    } else {
    if (str_contains($currentRouteName, $menu->slug) && strpos($currentRouteName, $menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    @endphp

    {{-- Main menu item --}}
    <li class="menu-item {{ $activeClass }}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">
        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        @isset($menu->badge)
        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
        @endisset
      </a>

      {{-- Submenu --}}
      @isset($menu->submenu)
      <ul class="menu-sub">
        @foreach ($menu->submenu as $submenu)
        {{-- Check permission for submenu --}}
        @if (!isset($submenu->can) || (auth()->check() && auth()->user()->can($submenu->can)))
        <li class="menu-item">
          <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0);' }}" class="menu-link">
            @if (isset($submenu->target) && !empty($submenu->target))
            target="_blank"
            @endif
            @isset($submenu->icon)
            <i class="{{ $submenu->icon }}"></i>
            @endisset
            <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
          </a>
        </li>
        @endif
        @endforeach
      </ul>
      @endisset
    </li>
    @endif
    @endif
    @endforeach
  </ul>
</aside>