<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Penggajian - Penerima Gaji">
    <title>@yield('title', 'Penerima Gaji - Sistem Penggajian')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
    @yield('styles')
</head>
<body class="payroll-layout">
    @php
        $authUser = auth()->user();
        $isAdmin = $authUser?->role === 'admin';
    @endphp
    <div class="payroll-shell container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="text-center py-4 border-bottom border-secondary">
                    <h4 class="text-white mb-0">
                        <i class="bi bi-cash-stack"></i> Penerima Gaji
                    </h4>
                    <small class="text-white-50">Sistem Penggajian</small>
                </div>
                <nav class="nav flex-column py-3">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    @if($isAdmin)
                        <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                            <i class="bi bi-people"></i> Karyawan
                        </a>
                        <a class="nav-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}" href="{{ route('payrolls.index') }}">
                            <i class="bi bi-cash"></i> Penggajian
                        </a>
                    @endif
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="bi bi-gear"></i> Pengaturan Akun
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-auto p-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light px-4 py-3">
                    <div class="container-fluid px-0">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="d-flex align-items-center ms-auto">
                            <div class="dropdown">
                                <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle"></i> {{ $authUser?->name ?? 'Pengguna' }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <span class="dropdown-item-text text-muted small">
                                            {{ $isAdmin ? 'Administrator' : 'Karyawan' }}
                                        </span>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                    @if($isAdmin)
                                        <li><a class="dropdown-item" href="{{ route('security.edit') }}">Keamanan</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Content -->
                <main class="px-4 py-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
