<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Dental Clinic</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Simplified Admin Theme -->
    <link href="{{ asset('assets/css/admin-theme-simple.css') }}" rel="stylesheet">
    
    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    
    @stack('styles')
</head>
<body hx-boost="true">
    
    <div class="admin-shell">
        
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="admin-sidebar">
            
            <!-- Brand -->
            <div class="brand">
                <i class="fas fa-tooth"></i>
                <span>Dental Clinic</span>
            </div>
            
            <!-- User Card -->
            <div class="admin-user-card">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="meta">
                    <div class="name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="role">Quản trị viên</div>
                </div>
                <a href="#" class="edit">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="admin-nav">
                
                <div class="nav-section">
                    <div class="nav-label">Tổng quan</div>
                    <a href="{{ route('admin.dashboard') }}" 
                       hx-get="{{ route('admin.dashboard') }}" 
                       hx-target="#main-content" 
                       hx-push-url="true">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-label">Quản lý</div>
                    
                    <a href="{{ route('admin.patients.index') }}" 
                       hx-get="{{ route('admin.patients.index') }}" 
                       hx-target="#main-content" 
                       hx-push-url="true">
                        <i class="fas fa-users"></i>
                        <span>Bệnh nhân</span>
                    </a>
                    
                    <a href="#" class="nav-link disabled">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Lịch hẹn</span>
                    </a>
                    
                    <a href="#" class="nav-link disabled">
                        <i class="fas fa-notes-medical"></i>
                        <span>Hồ sơ điều trị</span>
                    </a>
                    
                    <a href="#" class="nav-link disabled">
                        <i class="fas fa-receipt"></i>
                        <span>Hóa đơn</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-label">Hệ thống</div>
                    
                    <a href="#" class="nav-link disabled">
                        <i class="fas fa-user-md"></i>
                        <span>Bác sĩ</span>
                    </a>
                    
                    <a href="#" class="nav-link disabled">
                        <i class="fas fa-cogs"></i>
                        <span>Cài đặt</span>
                    </a>
                    
                    <a href="#" class="nav-link disabled">
                        <i class="fas fa-chart-bar"></i>
                        <span>Báo cáo</span>
                    </a>
                </div>
                
            </nav>
            
            <!-- Footer -->
            <div class="admin-sidebar-footer">
                <div class="text-center">
                    <small class="text-muted">
                        Dental Clinic v1.0<br>
                        © 2024 - Admin Panel
                    </small>
                </div>
            </div>
            
        </aside>
        
        <!-- Main Content Area -->
        <main class="admin-content">
            
            <!-- Top Bar -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <button type="button" class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-heading">
                        <h1>@yield('page-title', 'Dashboard')</h1>
                        <p>@yield('page-description', 'Tổng quan hệ thống quản lý phòng khám')</p>
                    </div>
                </div>
                
                <div class="topbar-right">
                    <div class="quick-links">
                        <a href="{{ route('admin.patients.create') }}" class="quick-link">
                            <i class="fas fa-plus me-1"></i>
                            Thêm bệnh nhân
                        </a>
                    </div>
                    
                    <div class="topbar-actions">
                        <a href="#" class="btn">
                            <i class="fas fa-bell"></i>
                        </a>
                        <a href="#" class="btn">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <section class="admin-main" id="main-content">
                @yield('content')
            </section>
            
        </main>
        
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Simplified Admin Scripts -->
    <script src="{{ asset('assets/js/admin-simple.js') }}"></script>
    
    @stack('scripts')
</body>
</html>