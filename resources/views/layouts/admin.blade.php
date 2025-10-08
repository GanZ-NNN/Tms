<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แดชบอร์ดผู้ดูแล - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Alpine.js (สำหรับ Accordion/Tabs) -->
    <script src="//unpkg.com/alpinejs" defer></script>

    @vite(['resources/css/app.css','resources/js/app.js',])
    <style>
    /* Custom Sidebar */
    .sidebar {
        height: 100vh; /* เปลี่ยนเป็น 100vh เพื่อให้เต็มความสูงของหน้าจอ */
        background: #FFFFFFFF;
        color: #fff;
    }
    .sidebar .nav-link {
        color: #000000FF;
        display: flex;
        align-items: center;
    }
    .sidebar .nav-link i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    .sidebar .nav-link.active {
        background: #756F6FFF;
        color: #fff;
        border-radius: 0.375rem;
    }
    .navbar-dark .navbar-brand {
        font-weight: bold;
    }
    </style>

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js" defer></script>
</head>
<body>

<!-- Navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="btn btn-outline-light d-md-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">ผู้ดูแลระบบ</a>
        <div class="d-flex ms-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm" type="submit"><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</button>
            </form>
        </div>
    </div>
</nav> -->

@include('layouts.navigation')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar ">
            <div class="position-sticky p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> แดชบอร์ด
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('programs.index') ? 'active' : '' }}" href="{{ route('programs.index') }}">
                            <i class="bi bi-speedometer2"></i> ลายละเอียด
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i> ผู้ใช้งาน
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-tags"></i> หมวดหมู่
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}" href="{{ route('admin.programs.index') }}">
                            <i class="bi bi-journal-bookmark"></i> หลักสูตร & รอบอบรม
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" href="{{ route('admin.attendance.overview') }}">
                            <i class="bi bi-calendar-check"></i> การเข้าเรียน
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports.feedback.index') ? 'active' : '' }}"
                        href="{{ route('admin.reports.feedback.index', ['sessionId' => 1]) }}">
                            <i class="bi bi-file-earmark-text"></i> Feedback
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}" href="{{ route('admin.certificates.index') }}">
                            <i class="bi bi-award"></i> ใบประกาศนียบัตร
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

            <!-- *** ส่วนที่เพิ่ม/แก้ไข *** -->
            <div class="container-fluid mb-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="ปิด"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="ปิด"></button>
                    </div>
                @endif
            </div>

            @yield('content')

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- *** ส่วนที่เพิ่มเข้ามา *** -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')
</body>
</html>
