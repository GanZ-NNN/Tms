<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg header-nav d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="navbar-brand">TMS</a>

            <!-- Center Menu -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">หน้าหลัก</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="programDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        หลักสูตร
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="programDropdown">
                        @foreach($programs ?? [] as $program)
                            <li><a class="dropdown-item" href="{{ route('programs.show', $program->id) }}">{{ $program->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Auth links -->
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                @auth
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">เข้าสู่ระบบ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">สมัครสมาชิก</a>
                    </li>
                @endauth
            </ul>
        </nav>
    </div>
</header>
