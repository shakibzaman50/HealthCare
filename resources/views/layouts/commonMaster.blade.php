<!DOCTYPE html>
@php
$menuFixed = ($configData['layout'] === 'vertical') ? ($menuFixed ?? '') : (($configData['layout'] === 'front') ? '' :
$configData['headerType']);
$navbarType = ($configData['layout'] === 'vertical') ? ($configData['navbarType'] ?? '') : (($configData['layout'] ===
'front') ? 'layout-navbar-fixed': '');
$isFront = ($isFront ?? '') == true ? 'Front' : '';
$contentLayout = (isset($container) ? (($container === 'container-xxl') ? "layout-compact" : "layout-wide") : "");
@endphp

<html lang="{{ session()->get('locale') ?? app()->getLocale() }}"
  class="{{ $configData['style'] }}-style {{($contentLayout ?? '')}} {{ ($navbarType ?? '') }} {{ ($menuFixed ?? '') }} {{ $menuCollapsed ?? '' }} {{ $menuFlipped ?? '' }} {{ $menuOffcanvas ?? '' }} {{ $footerFixed ?? '' }} {{ $customizerHidden ?? '' }}"
  dir="{{ $configData['textDirection'] }}" data-theme="{{ $configData['theme'] }}"
  data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel"
  data-template="{{ $configData['layout'] . '-menu-' . $configData['themeOpt'] . '-' . $configData['styleOpt'] }}"
  data-style="{{$configData['styleOptVal']}}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') | {{ $globalSetting->site_title ?? 'Site Title' }}

  </title>
  <meta name="description"
    content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  @if(isset($globalSetting->site_fevicon) )
  <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $globalSetting->site_fevicon ) }}" />
  @endif

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.5/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.5/dist/sweetalert2.min.js"></script>

  @include('layouts/sections/styles' . $isFront)


  @include('layouts/sections/scriptsIncludes' . $isFront)

  <!-- Meta Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1126617185804090');
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=1126617185804090&ev=PageView&noscript=1" /></noscript>
  <!-- End Meta Pixel Code -->
</head>

<body>

  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  @include('layouts/sections/scripts' . $isFront)


</body>

</html>