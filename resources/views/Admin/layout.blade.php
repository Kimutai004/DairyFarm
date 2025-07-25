<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dairy Farm Management System')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #667eea;
            --primary-dark: #5a67d8;
            --secondary-color: #764ba2;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --danger-color: #f56565;
            --info-color: #4299e1;
            --dark-color: #2d3748;
            --light-color: #f7fafc;
            --sidebar-width: 280px;
            --border-radius: 16px;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            color: #2d3748;
            overflow-x: hidden;
        }
        
        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            min-height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: var(--shadow-xl);
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            z-index: -1;
        }
        
        .sidebar .logo {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            margin-bottom: 1rem;
        }
        
        .sidebar .logo .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: var(--shadow-lg);
            transform: rotate(-5deg);
        }
        
        .sidebar .logo .logo-icon:hover {
            transform: rotate(0deg) scale(1.05);
        }
        
        .sidebar .logo h4 {
            color: var(--dark-color);
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.025em;
        }
        
        .sidebar .logo .logo-subtitle {
            color: #718096;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.25rem;
        }
        
        .sidebar-nav {
            padding: 0 1rem;
        }
        
        .sidebar-nav .nav-section {
            margin-bottom: 2rem;
        }
        
        .sidebar-nav .nav-section-title {
            color: #a0aec0;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.75rem;
            padding: 0 0.75rem;
        }
        
        .sidebar-nav .nav-link {
            color: #4a5568;
            padding: 0.875rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 0.25rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            opacity: 0;
            z-index: -1;
            border-radius: 12px;
        }
        
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: white;
            transform: translateX(8px);
            box-shadow: var(--shadow-lg);
        }
        
        .sidebar-nav .nav-link:hover::before,
        .sidebar-nav .nav-link.active::before {
            opacity: 1;
        }
        
        .sidebar-nav .nav-link i {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }
        
        .sidebar-nav .nav-link .badge {
            margin-left: auto;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: rgba(247, 250, 252, 0.8);
            backdrop-filter: blur(20px);
        }
        
        .topbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 1.5rem 2rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .topbar .page-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .topbar .page-title h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark-color);
        }
        
        .topbar .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            font-size: 0.875rem;
        }
        
        .topbar .breadcrumb-item + .breadcrumb-item::before {
            content: '›';
            color: #cbd5e0;
        }
        
        .topbar .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .topbar .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            box-shadow: var(--shadow-md);
        }

        .user-info {
            text-align: left;
        }

        .user-info .fw-bold {
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger-color);
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .search-container .form-control {
            background: rgba(248, 249, 250, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .search-container .form-control:focus {
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-xl);
            border-radius: 12px;
            padding: 0.5rem 0;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 0.5rem;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(74, 144, 226, 0.1), rgba(142, 68, 173, 0.1));
            transform: translateX(5px);
        }

        .dropdown-header {
            padding: 1rem 1.5rem 0.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        
        .content-wrapper {
            padding: 2rem;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 1.5rem 2rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--success-color) 0%, #38b2ac 100%);
            color: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }
        
        .stats-card.warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #f6ad55 100%);
        }
        
        .stats-card.danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #fc8181 100%);
        }
        
        .stats-card.info {
            background: linear-gradient(135deg, var(--info-color) 0%, #63b3ed 100%);
        }
        
        .stats-card .stats-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 3rem;
            opacity: 0.3;
        }
        
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border: none;
            box-shadow: var(--shadow-md);
            letter-spacing: 0.025em;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #38b2ac 100%);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #f6ad55 100%);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #fc8181 100%);
        }
        
        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .table th {
            background: linear-gradient(135deg, var(--dark-color) 0%, #4a5568 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            border-color: #e2e8f0;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .alert {
            border: none;
            border-radius: 12px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 0.875rem 1rem;
            font-weight: 500;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .dropdown-item {
            border-radius: 8px;
            margin: 0.25rem;
            padding: 0.75rem 1rem;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }
        
        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Floating Elements */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1050;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-wrapper {
                padding: 1rem;
            }
            
            .topbar {
                padding: 1rem;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .stats-card {
                padding: 1.5rem;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-color) 100%);
        }
        
        /* Notification Dot */
        .notification-dot {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 12px;
            height: 12px;
            background: var(--danger-color);
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-cow fa-2x text-white"></i>
            </div>
            <h4>DairyFarm Pro</h4>
            <div class="logo-subtitle">Management System</div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Overview</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    Dashboard
                    <span class="badge bg-success ms-auto">Live</span>
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Management</div>
                <a href="{{ route('admin.employees.index') }}" class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Employees
                </a>
                
                <a href="{{ route('admin.cattle.index') }}" class="nav-link {{ request()->routeIs('admin.cattle.*') ? 'active' : '' }}">
                    <i class="fas fa-cow"></i>
                    Cattle Management
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Production</div>
                <a href="{{ route('admin.milk-production.index') }}" class="nav-link {{ request()->routeIs('admin.milk-production.*') ? 'active' : '' }}">
                    <i class="fas fa-glass-whiskey"></i>
                    Milk Production
                </a>
                
                <a href="{{ route('admin.feed-records.index') }}" class="nav-link {{ request()->routeIs('admin.feed-records.*') ? 'active' : '' }}">
                    <i class="fas fa-seedling"></i>
                    Feed Management
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Health & Care</div>
                <a href="{{ route('admin.vaccines.index') }}" class="nav-link {{ request()->routeIs('admin.vaccines.*') ? 'active' : '' }}">
                    <i class="fas fa-syringe"></i>
                    Vaccines
                </a>
                
                <a href="{{ route('admin.health-records.index') }}" class="nav-link {{ request()->routeIs('admin.health-records.*') ? 'active' : '' }}">
                    <i class="fas fa-heartbeat"></i>
                    Health Records
                </a>
                
                <a href="{{ route('admin.breeding-records.index') }}" class="nav-link {{ request()->routeIs('admin.breeding-records.*') ? 'active' : '' }}">
                    <i class="fas fa-heart"></i>
                    Breeding Records
                </a>
            </div>
            
            <div class="nav-section">
                <div class="nav-section-title">Business</div>
                <a href="{{ route('admin.sales.index') }}" class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    Sales & Revenue
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    Reports & Analytics
                </a>
            </div>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="page-title">
                <button class="btn btn-link d-md-none p-0 me-3" id="sidebar-toggle">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <div>
                    <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item active">@yield('page-title', 'Dashboard')</li>
                        </ol>
                    </nav>
                </div>
            </div>
            
            <div class="user-menu">
                <!-- Search Bar -->
                <div class="search-container d-none d-lg-block me-3">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 bg-light" placeholder="Search..." style="border-radius: 25px 0 0 25px;">
                        <button class="btn btn-light border-0" style="border-radius: 0 25px 25px 0;">
                            <i class="fas fa-search text-muted"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Notifications -->
                <div class="dropdown me-3">
                    <button class="btn btn-link position-relative p-2" data-bs-toggle="dropdown">
                        <i class="fas fa-bell fa-lg text-muted"></i>
                        <span class="notification-dot"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                        <div class="dropdown-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Notifications</h6>
                            <span class="badge bg-primary">3</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item d-flex align-items-center py-3" href="#">
                            <div class="me-3">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-cow text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">New cattle registered</div>
                                <small class="text-muted">Holstein cow #C001 added</small>
                            </div>
                        </a>
                        <a class="dropdown-item d-flex align-items-center py-3" href="#">
                            <div class="me-3">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-syringe text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">Vaccination due</div>
                                <small class="text-muted">5 cattle need vaccination</small>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center fw-bold" href="#">View All Notifications</a>
                    </div>
                </div>
                
                <!-- User Profile -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="user-avatar me-3">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="user-info d-none d-lg-block">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fas fa-user me-3"></i>
                                <div>
                                    <div>My Profile</div>
                                    <small class="text-muted">Account settings</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fas fa-cog me-3"></i>
                                <div>
                                    <div>Settings</div>
                                    <small class="text-muted">Preferences</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="fas fa-question-circle me-3"></i>
                                <div>
                                    <div>Help Center</div>
                                    <small class="text-muted">Get support</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item d-flex align-items-center text-danger" href="#" 
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt me-3"></i>
                                    <div>
                                        <div>Sign Out</div>
                                        <small class="text-muted">Come back soon!</small>
                                    </div>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhanced sidebar and UI functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const body = document.body;

            // Sidebar toggle functionality
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    body.classList.toggle('sidebar-open');
                });
            }

            // Close sidebar on overlay click (mobile)
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768 && 
                    sidebar && 
                    !sidebar.contains(e.target) && 
                    sidebarToggle && 
                    !sidebarToggle.contains(e.target) && 
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    body.classList.remove('sidebar-open');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768 && sidebar) {
                    sidebar.classList.remove('show');
                    body.classList.remove('sidebar-open');
                }
            });

            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    try {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    } catch (e) {
                        // Fallback if Bootstrap alert fails
                        alert.style.display = 'none';
                    }
                });
            }, 5000);

            // Add loading state to buttons
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.type === 'submit') {
                        this.classList.add('loading');
                        setTimeout(() => {
                            this.classList.remove('loading');
                        }, 2000);
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
