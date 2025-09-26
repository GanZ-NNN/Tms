<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TMS')</title>

    <!-- Vite CSS & JS -->
    @vite([
        'resources/css/style.css',
        'resources/css/home.css',
        'resources/css/programs.css',
        'resources/js/main.js',
        'resources/js/programs.js'
    ])

    <!-- Swiper CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
</head>
<body>
    <div class="main-wrapper">
        @include('partials.header')

        <div class="page-wrapper">
            <div class="content container">
                @yield('content')
            </div>
        </div>

        @include('partials.footer')
    </div>

    <!-- Swiper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
</body>
</html>
