<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Penggajian - Penerima Gaji">
    <title>@yield('title', 'Penerima Gaji - Sistem Penggajian')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4a90d9;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 5px;
            margin: 2px 10px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: #fff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-3px);
        }
        .stat-card {
            padding: 20px;
            border-radius: 10px;
            color: #fff;
        }
        .stat-card.blue { background: linear-gradient(135deg, #4a90d9 0%, #357abd 100%); }
        .stat-card.green { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
        .stat-card.orange { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); }
        .stat-card.red { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
        .stat-card i {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #343a40;
            color: #fff;
            border: none;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #357abd;
            border-color: #357abd;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .page-header {
            background: #fff;
            padding: 20px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .badge-status.aktif { background-color: #d4edda; color: #155724; }
        .badge-status.tidak_aktif { background-color: #f8d7da; color: #721c24; }
        .badge-status.pending { background-color: #fff3cd; color: #856404; }
        .badge-status.dibayar { background-color: #d4edda; color: #155724; }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
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
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                        <i class="bi bi-people"></i> Karyawan
                    </a>
                    <a class="nav-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}" href="{{ route('payrolls.index') }}">
                        <i class="bi bi-cash"></i> Penggajian
                    </a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-file-earmark-text"></i> Laporan
                    </a>
                    <div class="dropdown-divider my-2"></div>
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear"></i> Pengaturan
                    </a>
                    <a class="nav-link" href="#">
                        <i class="bi bi-box-arrow-left"></i> Logout
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
                                    <i class="bi bi-person-circle"></i> Admin
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Logout</a></li>
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
