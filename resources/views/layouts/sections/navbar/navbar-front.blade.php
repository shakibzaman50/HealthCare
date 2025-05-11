@php
use Illuminate\Support\Facades\Route;
$currentRouteName = Route::currentRouteName();
$activeRoutes = ['front-pages-pricing', 'front-pages-payment', 'front-pages-checkout', 'front-pages-help-center'];
$activeClass = in_array($currentRouteName, $activeRoutes) ? 'active' : '';
@endphp
<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0">
  <div class="container">
    <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
      <!-- Menu logo wrapper: Start -->
      <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-4 me-xl-8">
        <!-- Mobile menu toggle: Start -->
        <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <i class="ti ti-menu-2 ti-lg align-middle text-heading fw-medium"></i>
        </button>
        <!-- Mobile menu toggle: End -->
        <a href="/" class="">
          <div class="homepage-logo">
            <img src="{{ asset('storage/' . $globalSetting->logo) }}" width="100">
          </div>
        </a>
      </div>
      <!-- Menu logo wrapper: End -->

      <!-- Menu wrapper: Start -->
      <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
        <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl" type="button"
          data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
          aria-expanded="false" aria-label="Toggle navigation">
          <i class="ti ti-x ti-lg"></i>
        </button>

        <!-- Menu Items: Start -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'pages-home' ? 'active' : '' }}"
              href="{{ route('pages-home') }}">Home </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'product-page' ? 'active' : '' }}"
              href="{{ route('product-page') }}">All Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'category.page' && request('id') == 'khejur' ? 'active' : '' }}"
              href="{{ route('category.page', ['id' => 'khejur']) }}">Khejur</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'category.page' && request('id') == 'powder' ? 'active' : '' }}"
              href="{{ route('category.page', ['id' => 'powder']) }}">Powder</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'category.page' && request('id') == 'chocolate' ? 'active' : '' }}"
              href="{{ route('category.page', ['id' => 'chocolate']) }}">Chocolate</a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'cart-page' ? 'active' : '' }}"
              href="{{ route('cart-page') }}">Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'front-pages-contact' ? 'active' : '' }}"
              href="{{ route('pages-home') }}">Contact </a>
          </li>
        </ul>
        <!-- Menu Items: End -->

      </div>
      <div class="landing-menu-overlay d-lg-none"></div>
      <!-- Menu wrapper: End -->

      <!-- Toolbar: Start -->
      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <li>
          <a href="/login" class="btn btn-primary" target="_blank">
            <span class="tf-icons ti ti-login scaleX-n1-rtl me-md-1"></span>
            <span class="d-none d-md-block">Login/Register</span>
          </a>
        </li>
        <!-- Navbar button: End -->
        <li class="nav-item dropdown">
          <a class="nav-link cart-icon openModalButton" href="/cart" role="button">
            <i class="ti ti-shopping-cart ti-lg"></i>
            <span class="badge bg-primary cart-count">0</span> <!-- Total Cart Items -->
            <span class="cart-total-price ms-2">৳ 0.00</span> <!-- Total Cart Price -->
          </a>
        </li>

      </ul>
      <!-- Toolbar: End -->
    </div>
  </div>
</nav>
<!-- Navbar: End -->