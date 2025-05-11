<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"
        

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Custom css  --}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }} " type="text/css">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        <!-- Use the full version of jQuery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>

        <!-- Popper.js (if required, typically for Bootstrap tooltips, popovers, etc.) -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <!-- jQuery Mask Plugin -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/4.0.0-alpha.18/lib.min.js" integrity="sha512-1orufxZLQCVB39X/Lf07G2UGVMcroAPgdrl2bWJ0uFe0PvrjFUR4667gV+k2lD9W1WQtY+VFSi28RzjzwG5RnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Your custom scripts -->

    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </body>
</html>
