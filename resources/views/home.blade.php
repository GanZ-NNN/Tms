
{{-- ใช้ App Layout หลักของเรา --}}
<x-app-layout>

    {{-- เนื่องจาก app.blade.php มี container อยู่แล้ว เราอาจจะไม่ต้องใช้ div ครอบอีก --}}

    <!-- Hero Banner -->
    @include('partials.hero-banner')

    <!-- Program Carousel -->
    @include('partials.programs_showmonth')

</x-app-layout>
