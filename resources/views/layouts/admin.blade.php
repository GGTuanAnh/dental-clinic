<!DOCTYPE html>
<html lang="vi" data-theme="admin">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin Panel') • Nha Khoa Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/css/app.css" rel="stylesheet"> {{-- reuse base utilities if needed --}}
  <link href="/assets/css/admin.css?v=1" rel="stylesheet">
  <link href="/assets/css/admin-theme.css?v=1" rel="stylesheet">
  @stack('head')
</head>
<body @if(auth()->check() && auth()->user()->isDoctor()) data-doctor-endpoint="{{ route('admin.home') }}?doctorDashboard=1" @endif>
  @php
    $user = auth()->user();
    $isDoctor = $user && method_exists($user, 'isDoctor') ? $user->isDoctor() : false;
    $initials = collect(preg_split('/\s+/', trim($user?->name ?? '')))
      ->filter()
      ->map(function($part){ return mb_strtoupper(mb_substr($part,0,1)); })
      ->take(2)
      ->implode('');
    if(blank($initials)){
      $initials = $isDoctor ? 'DR' : 'AD';
    }
    $r = request();
    $today = now()->format('Y-m-d');
    $canManageImages = $user?->can('manage-images');
    $canViewReports = $user?->can('view-reports');
  @endphp
  <div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="brand">
        <i class="bi bi-activity me-2"></i>
        <span>{{ $isDoctor ? 'Doctor Workspace' : 'Admin Workspace' }}</span>
      </div>
      <div class="admin-user-card">
        <div class="avatar">{{ $initials }}</div>
        <div class="meta">
          <div class="name">{{ $user?->name ?? 'Quản trị viên' }}</div>
          <div class="role">{{ $isDoctor ? 'Bác sĩ phụ trách' : 'Quản trị viên hệ thống' }}</div>
        </div>
        <a href="{{ route('admin.password.edit') }}" class="edit" title="Đổi mật khẩu" aria-label="Đổi mật khẩu"><i class="bi bi-gear"></i></a>
      </div>
      <nav class="admin-nav flex-grow-1 py-3">
        <div class="nav-section">
          <div class="nav-label">Quản lý điều trị</div>
          <a href="{{ route('admin.appointments.index') }}" class="{{ str_contains($r->route()?->getName(),'appointments') ? 'active' : '' }}"><i class="bi bi-calendar-week"></i><span>Lịch hẹn</span></a>
          <a href="{{ route('admin.patients.index') }}" class="{{ str_contains($r->route()?->getName(),'patients') ? 'active' : '' }}"><i class="bi bi-person-vcard"></i><span>Hồ sơ bệnh nhân</span></a>
        </div>
        @if($canManageImages)
        <div class="nav-section">
          <div class="nav-label">Nội dung & tư liệu</div>
          <a href="{{ route('admin.images.index') }}" class="{{ str_contains($r->route()?->getName(),'images') ? 'active' : '' }}"><i class="bi bi-collection"></i><span>Thư viện hình ảnh</span></a>
        </div>
        @endif
        @if($canViewReports)
        <div class="nav-section">
          <div class="nav-label">Phân tích</div>
          <a href="{{ route('admin.reports.index') }}" class="{{ str_contains($r->route()?->getName(),'reports') ? 'active' : '' }}"><i class="bi bi-graph-up-arrow"></i><span>Báo cáo</span></a>
        </div>
        @endif
      </nav>
      <div class="admin-sidebar-footer small">
        <div class="fw-semibold text-uppercase tracking-wide">Hệ thống</div>
        <div class="d-flex align-items-center gap-2 mt-1"><i class="bi bi-hdd-network"></i><span>ENV: {{ env('APP_ENV') }}</span></div>
        <div class="d-flex align-items-center gap-2 mt-1 text-wrap"><i class="bi bi-clock-history"></i><span>Cập nhật {{ now()->format('d/m/Y H:i') }}</span></div>
      </div>
    </aside>
    <div class="admin-content">
      <header class="admin-topbar">
        <div class="topbar-left">
          <button class="sidebar-toggle" id="sidebarToggle" type="button" aria-label="Mở menu"><i class="bi bi-list"></i></button>
          <div class="page-heading">
            <h1 class="topbar-title">@yield('page-title','Dashboard')</h1>
            @hasSection('page-description')
              <p class="topbar-subtitle">@yield('page-description')</p>
            @else
              <p class="topbar-subtitle">{{ $isDoctor ? 'Theo dõi lịch điều trị và hỗ trợ bệnh nhân nhanh chóng.' : 'Điều hành phòng khám với các công cụ tập trung một nơi.' }}</p>
            @endif
          </div>
        </div>
        <div class="topbar-right">
          <div class="quick-links d-none d-lg-flex">
            <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="quick-link" title="Xem lịch hẹn chờ xác nhận">
              <i class="bi bi-hourglass-split"></i><span>Chờ xác nhận</span>
            </a>
            <a href="{{ route('admin.appointments.index', ['from' => $today, 'to' => $today]) }}" class="quick-link" title="Lịch hẹn trong ngày">
              <i class="bi bi-calendar-event"></i><span>Hôm nay</span>
            </a>
            <a href="{{ route('admin.patients.index') }}" class="quick-link" title="Danh sách bệnh nhân">
              <i class="bi bi-people"></i><span>Bệnh nhân</span>
            </a>
          </div>
          <div class="topbar-actions">
            <button id="themeToggle" type="button" class="theme-toggle-btn" aria-label="Đổi giao diện"><i class="bi bi-moon-stars" id="themeIcon"></i><span class="d-none d-xl-inline">Giao diện</span></button>
            <form method="post" action="{{ route('admin.logout') }}" class="m-0 p-0 d-inline">@csrf <button class="btn btn-ghost"><i class="bi bi-box-arrow-right"></i><span class="d-none d-xl-inline">Đăng xuất</span></button></form>
            <a href="/" class="btn btn-ghost" title="Về trang chủ"><i class="bi bi-house"></i></a>
          </div>
        </div>
      </header>
      <main class="admin-main flex-grow-1">
        @hasSection('breadcrumbs')
          <div class="mb-2">@yield('breadcrumbs')</div>
        @endif
        @yield('content')
      </main>
      <footer class="footer-admin">&copy; {{ date('Y') }} Nha Khoa An Việt • Admin</footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/admin.js?v=1"></script>
  <script>
    (function(){
      const root=document.documentElement;
      const saved=localStorage.getItem('admin-theme');
      if(saved){ root.setAttribute('data-theme-mode', saved); }
      function updateIcon(){
        const mode=root.getAttribute('data-theme-mode')||'dark';
        const icon=document.getElementById('themeIcon');
        if(icon){ icon.className='bi ' + (mode==='light'?'bi-sun':'bi-moon-stars'); }
      }
      updateIcon();
      const btn=document.getElementById('themeToggle');
      if(btn){
        btn.addEventListener('click', ()=>{
          const cur=root.getAttribute('data-theme-mode')==='light'?'light':'dark';
          const next= cur==='light' ? 'dark' : 'light';
          root.setAttribute('data-theme-mode', next);
          localStorage.setItem('admin-theme', next);
          updateIcon();
        });
      }
    })();
  </script>
  @stack('scripts')
</body>
</html>