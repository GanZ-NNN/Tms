<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- แก้ไข: ใช้ config() helper เพื่อความถูกต้อง --}}
    <title>{{ config('app.name', 'TMS') }}</title>

    <!-- Fonts (จาก Breeze) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite CSS & JS -->
    @vite([
        'resources/css/app.css',
        'resources/css/style.css',
        'resources/css/home.css',
        'resources/css/programs.css',
        'resources/js/app.js',
        'resources/js/main.js',
        'resources/js/programs.js'
    ])

    <!-- Swiper CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
</head>
<body class="font-sans antialiased"> {{-- เพิ่ม class จาก Breeze --}}
    <div class="main-wrapper min-h-screen bg-gray-100 dark:bg-gray-900"> {{-- เพิ่ม class จาก Breeze --}}
        
        @include('layouts.navigation')

        <div class="page-wrapper">
            <div class="content container">
                
                <!-- Page Heading (จาก Breeze) -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                
                <!-- Page Content (Slot จาก Breeze) -->
                <main>
                    {{ $slot }}
                </main>

            </div>
        </div>

        @include('partials.footer')
    </div>

    <!-- Swiper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

        <!-- ========== เพิ่ม 2 ส่วนนี้เข้ามา ========== -->
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Scripts per page -->
    @stack('scripts')
    <!-- ============================================= -->
    
</body>
</html>