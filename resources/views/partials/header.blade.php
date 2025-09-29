<!--
    ================================================================================
    ไฟล์นี้คือส่วนหัวของเว็บไซต์ (Header Component) ที่ใช้ Blade Syntax ของ Laravel
    และดึง CSS จากไฟล์ภายนอกชื่อ style.css
    ================================================================================
-->
<head>
    <!-- ลิงก์ไปยังไฟล์ CSS ภายนอก -->
    <link rel="stylesheet" href="style.css">
</head>

<header class="header shadow-sm bg-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg header-nav d-flex align-items-center justify-content-between">

            <!-- ส่วนที่ 1: โลโก้เว็บไซต์ -->
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ asset('assets/img/KKU_SLA_Logo.svg.png') }}" 
                     alt="KKU SLA Logo" 
                     style="height: 40px; margin-right: 10px;"> <!--<span class="fw-bold fs-1">TMS</span>-->
            </a>

            <!-- ส่วนที่ 2: ปุ่มสลับเมนูสำหรับ Mobile (Hamburger Menu) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- ส่วนที่ 3: เมนูนำทางหลัก -->
            <div class="collapse navbar-collapse" id="mainNav">
                <!-- Center Menu -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                    <li class="nav-item">
                        <a href="{{ url('/') }}"
                           class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}">
                            หน้าหลัก
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('programs*') ? 'active fw-bold' : '' }}"
                           href="#" id="programDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            หลักสูตร
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="programDropdown">
                            @forelse($programs ?? [] as $program)
                                <li>
                                    <a class="dropdown-item" href="#">
                                        {{ $program->title }}
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item text-muted">ยังไม่มีหลักสูตร</span>
                                </li>
                            @endforelse
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- ส่วนที่ 4: เมนูสำหรับผู้ใช้งาน (Login/Register/Dashboard/Logout) -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- หากผู้ใช้เข้าสู่ระบบแล้ว -->
                    @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <!-- ฟอร์มสำหรับ Logout (ใช้ POST method) -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                @else
                    <!-- หากผู้ใช้ยังไม่ได้เข้าสู่ระบบ -->
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                @endauth
            </ul>

        </nav>
    </div>
</header>
