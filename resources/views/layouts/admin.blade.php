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
  <div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
  <div class="brand"><i class="bi bi-speedometer2 me-1"></i> {{ auth()->check() && auth()->user()->isDoctor() ? 'Doctor Panel' : 'Admin Panel' }}</div>
      @php($r = request())
      <nav class="admin-nav flex-grow-1 py-2">
        <a href="{{ route('admin.appointments.index') }}" class="{{ str_contains($r->route()?->getName(),'appointments') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> <span>Lịch hẹn</span></a>
        <a href="{{ route('admin.patients.index') }}" class="{{ str_contains($r->route()?->getName(),'patients') ? 'active' : '' }}"><i class="bi bi-people"></i> <span>Bệnh nhân</span></a>
        <a href="{{ route('admin.images.index') }}" class="{{ str_contains($r->route()?->getName(),'images') ? 'active' : '' }}"><i class="bi bi-image"></i> <span>Hình ảnh</span></a>
        <a href="{{ route('admin.reports.index') }}" class="{{ str_contains($r->route()?->getName(),'reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> <span>Báo cáo</span></a>
      </nav>
      <div class="px-3 pb-3 small text-muted">
        <div class="fw-semibold mb-1">Hệ thống</div>
        <div>ENV: {{ env('APP_ENV') }}</div>
        <div><a class="text-decoration-none" href="{{ route('admin.password.edit') }}"><i class="bi bi-key"></i> Đổi mật khẩu</a></div>
      </div>
    </aside>
    <div class="admin-content">
      <header class="admin-topbar">
        <div class="d-flex align-items-center gap-2">
          <button class="sidebar-toggle" id="sidebarToggle" type="button"><i class="bi bi-list"></i></button>
          <h1 class="h5 mb-0 fw-semibold">@yield('page-title','Dashboard')</h1>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button id="themeToggle" type="button" class="theme-toggle-btn" aria-label="Đổi giao diện"><i class="bi bi-moon-stars" id="themeIcon"></i><span class="d-none d-sm-inline">Theme</span></button>
          <form method="post" action="{{ route('admin.logout') }}" class="m-0 p-0 d-inline">@csrf <button class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i></button></form>
          <a href="/" class="btn btn-sm btn-outline-light"><i class="bi bi-house"></i></a>
        </div>
      </header>
      <main class="p-3 p-lg-4 flex-grow-1">
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