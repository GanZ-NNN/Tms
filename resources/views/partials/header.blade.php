<header class="header shadow-sm bg-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg header-nav d-flex align-items-center justify-content-between">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="navbar-brand fw-bold">TMS</a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Menu -->
            <div class="collapse navbar-collapse" id="mainNav">
                <!-- Center Menu -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center ">
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
                                <li><span class="dropdown-item text-muted">ยังไม่มีหลักสูตร</span></li>
                            @endforelse
                        </ul>
                    </li>
                </ul>

                <!-- Auth Links -->
                <ul class="navbar-nav ms-auto">
    @auth
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link nav-link">Logout</button>
            </form>
        </li>
    @else
        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
    @endauth
</ul>
            </div>
        </nav>
    </div>
</header>
