<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>@yield('title', 'TMS')</title>
<link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

<!-- CSS & JS ผ่าน Vite -->
@vite(['resources/css/style.css', 'resources/js/main.js'])

<!-- Optional JS/CSS for alerts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">

<!-- Additional CSS per page -->
@stack('styles')
