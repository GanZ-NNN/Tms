<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TMS')</title>

    @vite(['resources/css/style.css', 'resources/js/main.js'])
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
</body>
</html>
