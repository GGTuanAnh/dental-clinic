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
  
  <!-- HTMX for SPA functionality -->
  <script src="https://unpkg.com/htmx.org@1.9.10"></script>
  
  <style>
    /* HTMX Loading States */
    .htmx-loading {
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .htmx-indicator {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
      background: rgba(0,0,0,0.8);
      color: white;
      padding: 1rem 2rem;
      border-radius: 8px;
      font-size: 14px;
    }

    .htmx-request .htmx-indicator {
      display: block;
    }

    /* Enhanced Page Transitions */
    #adminMainContent {
      transition: all 0.15s cubic-bezier(0.4, 0, 0.6, 1);
      transform: translateZ(0); /* Force GPU acceleration */
    }

    /* Smooth content swap animations */
    .htmx-swapping #adminMainContent {
      opacity: 0;
      transform: translateY(10px);
    }

    .htmx-settling #adminMainContent {
      opacity: 1;
      transform: translateY(0);
    }

    /* Preloader for instant feedback */
    .page-loading {
      position: relative;
    }

    .page-loading::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, var(--accent) 0%, var(--accent-strong) 100%);
      transform: translateX(-100%);
      animation: loadingBar 0.8s ease-in-out;
      z-index: 1000;
    }

    @keyframes loadingBar {
      0% { transform: translateX(-100%); }
      50% { transform: translateX(0%); }
      100% { transform: translateX(100%); }
    }

    /* Micro-animations for navigation */
    .admin-nav a {
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-nav a:active {
      transform: translateX(2px) scale(0.98);
    }

    /* Loading skeleton styles */
    .skeleton {
      background: linear-gradient(90deg, rgba(255,255,255,0.1) 25%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0.1) 75%);
      background-size: 200% 100%;
      animation: loading 1.5s infinite;
    }

    @keyframes loading {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }
  </style>
  
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
        <i class="bi bi-heart-pulse me-2"></i>
        <span>{{ $isDoctor ? 'Doctor Panel' : 'Admin Panel' }}</span>
      </div>
      
      <div class="admin-user-card">
        <div class="avatar">{{ $initials }}</div>
        <div class="meta">
          <div class="name">{{ $user?->name ?? 'Quản trị viên' }}</div>
          <div class="role">{{ $isDoctor ? 'Bác sĩ điều trị' : 'Quản trị hệ thống' }}</div>
        </div>
        <a href="{{ route('admin.password.edit') }}" class="edit" title="Cài đặt tài khoản" aria-label="Cài đặt">
          <i class="bi bi-gear-fill"></i>
        </a>
      </div>
      
      <nav class="admin-nav">
        <div class="nav-section">
          <div class="nav-label">Tổng quan</div>
          <a href="{{ route('admin.home') }}" 
             hx-get="{{ route('admin.home') }}?partial=1"
             hx-target="#adminMainContent"
             hx-push-url="{{ route('admin.home') }}"
             hx-swap="innerHTML transition:true"
             hx-trigger="click"
             hx-preload="mouseenter"
             class="{{ request()->routeIs('admin.home') ? 'active' : '' }}"
             title="Dashboard tổng quan">
             <i class="bi bi-speedometer2"></i>
             <span>Dashboard</span>
          </a>
        </div>
        
        <div class="nav-section">
          <div class="nav-label">Quản lý điều trị</div>
          <a href="{{ route('admin.appointments.index') }}" 
             hx-get="{{ route('admin.appointments.index') }}?partial=1"
             hx-target="#adminMainContent"
             hx-push-url="{{ route('admin.appointments.index') }}"
             hx-swap="innerHTML transition:true"
             hx-trigger="click"
             hx-preload="mouseenter"
             class="{{ str_contains($r->route()?->getName(),'appointments') ? 'active' : '' }}"
             title="Quản lý lịch hẹn">
             <i class="bi bi-calendar-check"></i>
             <span>Lịch hẹn</span>
          </a>

          <a href="{{ route('admin.patients.index') }}" 
             hx-get="{{ route('admin.patients.index') }}?partial=1"
             hx-target="#adminMainContent"
             hx-push-url="{{ route('admin.patients.index') }}"
             hx-swap="innerHTML transition:true"
             hx-trigger="click"
             hx-preload="mouseenter"
             class="{{ str_contains($r->route()?->getName(),'patients') ? 'active' : '' }}"
             title="Hồ sơ bệnh nhân">
             <i class="bi bi-people-fill"></i>
             <span>Bệnh nhân</span>
          </a>
        </div>

        @if($canViewReports)
        <div class="nav-section">
          <div class="nav-label">Báo cáo</div>
          <a href="{{ route('admin.reports.index') }}" 
             hx-get="{{ route('admin.reports.index') }}?partial=1"
             hx-target="#adminMainContent"
             hx-push-url="{{ route('admin.reports.index') }}"
             hx-swap="innerHTML transition:true"
             hx-trigger="click"
             hx-preload="mouseenter"
             class="{{ str_contains($r->route()?->getName(),'reports') ? 'active' : '' }}"
             title="Thống kê và báo cáo">
             <i class="bi bi-bar-chart-fill"></i>
             <span>Thống kê</span>
          </a>
        </div>
        @endif
      </nav>
      
      <div class="admin-sidebar-footer">
        <div class="fw-semibold text-uppercase tracking-wide mb-2">
          <i class="bi bi-shield-check me-1"></i>
          Hệ thống
        </div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="bi bi-server"></i>
          <span class="small">ENV: {{ strtoupper(env('APP_ENV', 'production')) }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-clock-history"></i>
          <span class="small">{{ now()->format('d/m H:i') }}</span>
        </div>
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
            <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" 
               hx-get="{{ route('admin.appointments.index', ['status' => 'pending']) }}?partial=1"
               hx-target="#adminMainContent"
               hx-push-url="{{ route('admin.appointments.index', ['status' => 'pending']) }}"
               hx-swap="innerHTML transition:true"
               hx-preload="mouseenter"
               class="quick-link" title="Xem lịch hẹn chờ xác nhận">
              <i class="bi bi-hourglass-split"></i><span>Chờ xác nhận</span>
            </a>
            <a href="{{ route('admin.appointments.index', ['from' => $today, 'to' => $today]) }}" 
               hx-get="{{ route('admin.appointments.index', ['from' => $today, 'to' => $today]) }}?partial=1"
               hx-target="#adminMainContent"
               hx-push-url="{{ route('admin.appointments.index', ['from' => $today, 'to' => $today]) }}"
               hx-swap="innerHTML transition:true"
               hx-preload="mouseenter"
               class="quick-link" title="Lịch hẹn trong ngày">
              <i class="bi bi-calendar-event"></i><span>Hôm nay</span>
            </a>
            <a href="{{ route('admin.patients.index') }}" 
               hx-get="{{ route('admin.patients.index') }}?partial=1"
               hx-target="#adminMainContent"
               hx-push-url="{{ route('admin.patients.index') }}"
               hx-swap="innerHTML transition:true"
               hx-preload="mouseenter"
               class="quick-link" title="Danh sách bệnh nhân">
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
      <main class="admin-main flex-grow-1" id="adminMainContent" hx-history-elt>
        @hasSection('breadcrumbs')
          <div class="mb-2">@yield('breadcrumbs')</div>
        @endif
        @yield('content')
      </main>
      <footer class="footer-admin">&copy; {{ date('Y') }} Nha Khoa An Việt • Admin</footer>
    </div>
  </div>
  
  <!-- HTMX Loading Indicator -->
  <div class="htmx-indicator">
    <div class="spinner-border text-light me-2" role="status" style="width: 1rem; height: 1rem;"></div>
    Đang tải...
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/admin.js?v=1"></script>
  
  <!-- HTMX Configuration -->
  <script>
    // Enhanced HTMX Configuration for smooth transitions
    htmx.config.defaultSwapStyle = 'innerHTML';
    htmx.config.defaultSwapDelay = 50;  // Faster swap
    htmx.config.defaultSettleDelay = 150; // Smoother settle
    htmx.config.timeout = 5000; // 5 second timeout
    htmx.config.historyCacheSize = 20; // Better back/forward
    
    // Admin UI State Management
    document.addEventListener('DOMContentLoaded', function() {
      // Preload critical CSS for better performance
      const link = document.createElement('link');
      link.rel = 'prefetch';
      link.href = '/assets/css/admin-theme.css';
      document.head.appendChild(link);
      
      // Initialize page transition system
      initializePageTransitions();
      initializeSidebarFunctionality();
      initializeKeyboardShortcuts();
    });
    
    // Enhanced page transition system
    function initializePageTransitions() {
      const mainContent = document.getElementById('adminMainContent');
      
      // Add smooth transition classes
      mainContent.style.willChange = 'transform, opacity';
      
      // Preload next pages on hover for instant navigation
      document.querySelectorAll('.admin-nav a[hx-get]').forEach(link => {
        link.addEventListener('mouseenter', function() {
          if (!this.dataset.preloaded) {
            htmx.trigger(this, 'mouseenter');
            this.dataset.preloaded = 'true';
          }
        });
      });
    }
    
    // Enhanced sidebar functionality
    function initializeSidebarFunctionality() {
      const sidebar = document.getElementById('adminSidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');
      
      // Load saved sidebar state
      const savedSidebarState = localStorage.getItem('admin-sidebar-collapsed');
      if (savedSidebarState === 'true') {
        sidebar.classList.add('collapsed');
        updateToggleIcon(true);
      }
      
      // Smooth sidebar toggle
      sidebarToggle.addEventListener('click', function(e) {
        e.preventDefault();
        toggleSidebar();
      });
      
      // Mobile handling
      if (window.innerWidth <= 768) {
        setupMobileSidebar();
      }
      
      // Handle window resize with debouncing
      let resizeTimeout;
      window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
          if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-open');
          } else {
            setupMobileSidebar();
          }
        }, 150);
      });
    }
    
    function toggleSidebar() {
      const sidebar = document.getElementById('adminSidebar');
      const isCollapsed = sidebar.classList.toggle('collapsed');
      
      // Save state with animation
      requestAnimationFrame(() => {
        localStorage.setItem('admin-sidebar-collapsed', isCollapsed);
        updateToggleIcon(isCollapsed);
        
        // Add subtle bounce effect
        sidebar.style.transform = isCollapsed ? 'scale(0.98)' : 'scale(1.01)';
        setTimeout(() => {
          sidebar.style.transform = '';
        }, 200);
      });
    }
    
    function updateToggleIcon(isCollapsed) {
      const icon = document.querySelector('#sidebarToggle i');
      if (icon) {
        icon.className = isCollapsed ? 'bi bi-arrow-right' : 'bi bi-list';
      }
    }
    
    function setupMobileSidebar() {
      const sidebar = document.getElementById('adminSidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');
      
      sidebar.classList.remove('collapsed');
      
      // Mobile overlay handling
      document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && 
            sidebar.classList.contains('mobile-open') &&
            !sidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target)) {
          sidebar.classList.remove('mobile-open');
        }
      });
    }
    
    // Keyboard shortcuts for better UX
    function initializeKeyboardShortcuts() {
      document.addEventListener('keydown', function(e) {
        // Alt + S to toggle sidebar
        if (e.altKey && e.key === 's') {
          e.preventDefault();
          toggleSidebar();
        }
        
        // Alt + D for dashboard
        if (e.altKey && e.key === 'd') {
          e.preventDefault();
          const dashboardLink = document.querySelector('a[href*="admin.home"]');
          if (dashboardLink) dashboardLink.click();
        }
        
        // Alt + P for patients
        if (e.altKey && e.key === 'p') {
          e.preventDefault();
          const patientsLink = document.querySelector('a[href*="patients"]');
          if (patientsLink) patientsLink.click();
        }
      });
    }
    
    // Enhanced HTMX Event Handlers
    document.body.addEventListener('htmx:beforeRequest', function(evt) {
      // Instant visual feedback
      const target = evt.detail.target;
      target.classList.add('page-loading');
      
      // Close mobile sidebar immediately
      const sidebar = document.getElementById('adminSidebar');
      if (window.innerWidth <= 768 && sidebar.classList.contains('mobile-open')) {
        sidebar.classList.remove('mobile-open');
      }
      
      // Add subtle loading animation to clicked link
      const triggerElement = evt.detail.elt;
      if (triggerElement && triggerElement.classList.contains('admin-nav')) {
        triggerElement.style.transform = 'translateX(4px)';
        triggerElement.style.transition = 'transform 0.1s ease';
      }
    });
    
    document.body.addEventListener('htmx:beforeSwap', function(evt) {
      // Prepare for smooth content transition
      const target = evt.detail.target;
      target.style.opacity = '0';
      target.style.transform = 'translateY(10px)';
    });
    
    document.body.addEventListener('htmx:afterSwap', function(evt) {
      // Smooth content entrance
      const target = evt.detail.target;
      
      requestAnimationFrame(() => {
        target.style.opacity = '1';
        target.style.transform = 'translateY(0)';
        target.classList.remove('page-loading');
      });
      
      // Update page title with animation
      const titleElement = target.querySelector('[data-page-title]');
      if (titleElement) {
        const newTitle = titleElement.dataset.pageTitle + ' • Nha Khoa Admin';
        document.title = newTitle;
        
        // Animate page heading update
        const pageHeading = document.querySelector('.topbar-title');
        if (pageHeading) {
          pageHeading.style.opacity = '0';
          setTimeout(() => {
            pageHeading.textContent = titleElement.dataset.pageTitle || 'Dashboard';
            pageHeading.style.opacity = '1';
          }, 75);
        }
      }
      
      // Update active navigation with smooth transition
      updateActiveNavigation();
      
      // Re-initialize components
      initializeBootstrapComponents();
      initializePageSpecificFeatures();
      
      // Scroll to top smoothly on page change
      if (window.scrollY > 0) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
    
    document.body.addEventListener('htmx:afterRequest', function(evt) {
      // Clean up loading states
      const target = evt.detail.target;
      target.classList.remove('page-loading');
      
      // Reset any navigation link transforms
      document.querySelectorAll('.admin-nav a').forEach(link => {
        link.style.transform = '';
      });
    });
    
    // Enhanced navigation active state management
    function updateActiveNavigation() {
      const currentUrl = window.location.pathname;
      const navLinks = document.querySelectorAll('.admin-nav a');
      
      navLinks.forEach(link => {
        const wasActive = link.classList.contains('active');
        link.classList.remove('active');
        
        const href = link.getAttribute('href');
        const isActive = href === currentUrl || 
                        (href !== '/admin' && currentUrl.startsWith(href));
        
        if (isActive) {
          link.classList.add('active');
          
          // Subtle animation for newly active link
          if (!wasActive) {
            link.style.transform = 'scale(1.02)';
            setTimeout(() => {
              link.style.transform = '';
            }, 200);
          }
        }
      });
    }
    
    // Page-specific feature initialization
    function initializePageSpecificFeatures() {
      // Initialize tooltips with faster show/hide
      document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el, {
          delay: { show: 300, hide: 100 },
          animation: true
        });
      });
      
      // Auto-focus search inputs
      const searchInput = document.querySelector('input[name="q"]');
      if (searchInput && !window.matchMedia('(max-width: 768px)').matches) {
        setTimeout(() => searchInput.focus(), 200);
      }
      
      // Initialize any data tables with smooth rendering
      const tables = document.querySelectorAll('.table');
      tables.forEach(table => {
        table.style.opacity = '0';
        requestAnimationFrame(() => {
          table.style.transition = 'opacity 0.3s ease';
          table.style.opacity = '1';
        });
      });
    }
    
    // Re-initialize Bootstrap components
    function initializeBootstrapComponents() {
      // Destroy existing tooltips/popovers first
      document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        const tooltip = bootstrap.Tooltip.getInstance(el);
        if (tooltip) tooltip.dispose();
      });
      
      document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
        const popover = bootstrap.Popover.getInstance(el);
        if (popover) popover.dispose();
      });
      
      // Reinitialize with improved performance
      requestAnimationFrame(() => {
        // Tooltips
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
          new bootstrap.Tooltip(el);
        });
        
        // Popovers
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
          new bootstrap.Popover(el);
        });
      });
    }
    
    // Enhanced error handling with better UX
    document.body.addEventListener('htmx:responseError', function(evt) {
      console.error('HTMX Error:', evt.detail);
      
      // Show elegant error notification
      showNotification('Có lỗi xảy ra. Đang thử tải lại...', 'warning');
      
      // Attempt graceful retry before full page fallback
      setTimeout(() => {
        const originalRequest = evt.detail.pathInfo.requestPath;
        window.location.href = originalRequest;
      }, 1500);
    });
    
    // Elegant notification system
    function showNotification(message, type = 'info') {
      const notification = document.createElement('div');
      notification.className = `alert alert-${type} position-fixed shadow-lg`;
      notification.style.cssText = `
        top: 20px; 
        right: 20px; 
        z-index: 9999; 
        min-width: 300px;
        animation: slideInRight 0.3s ease;
        border: none;
        backdrop-filter: blur(10px);
      `;
      
      notification.innerHTML = `
        <div class="d-flex align-items-center">
          <i class="bi bi-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
          ${message}
        </div>
      `;
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
      }, 3000);
    }
    
    // Add CSS for notification animations
    const style = document.createElement('style');
    style.textContent = `
      @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
      }
      @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
      }
    `;
    document.head.appendChild(style);
  </script>
  
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