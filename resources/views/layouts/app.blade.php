<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nha Khoa An Việt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/css/app.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
  <style>
    /* Page transition overlay */
    .transition-fade{opacity:1;transition:opacity .3s ease}
    html.is-animating .transition-fade{opacity:0.2}
    .scroll-top{position:fixed;right:16px;bottom:16px;z-index:1030;display:none}
    .scroll-top.show{display:block}
    .navbar.scrolled{box-shadow:0 10px 20px rgba(2,8,23,.08)}
  </style>
</head>
<body class="d-flex flex-column min-vh-100">
  <nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container py-2">
      <a class="navbar-brand fw-bold" href="{{ url('/') }}">
        <i class="bi bi-heart-fill text-primary"></i> Nha Khoa An Việt
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Trang chủ</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">Giới thiệu</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Dịch vụ</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/pricing') }}">Bảng giá</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/gallery') }}">Hình ảnh</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/faq') }}">Hỏi đáp</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/testimonials') }}">Đánh giá</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Liên hệ</a></li>
          <li class="nav-item"><a class="btn btn-primary px-3" href="{{ url('/booking') }}"><i class="bi bi-calendar-check me-1"></i> Đặt lịch</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main id="swup" class="py-4 flex-grow-1 transition-fade" data-swup="">
    @yield('content')
  </main>

  <footer class="footer mt-auto">
    <div class="container py-5">
      <div class="row g-4">
        <div class="col-md-6">
          <h5 class="mb-3">Nha Khoa An Việt</h5>
          <p class="mb-0">Chăm sóc nụ cười của bạn với đội ngũ bác sĩ tận tâm và công nghệ hiện đại.</p>
        </div>
        <div class="col-md-3">
          <h6 class="mb-3">Liên kết</h6>
          <ul class="list-unstyled small">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="/services">Dịch vụ</a></li>
            <li><a href="/pricing">Bảng giá</a></li>
            <li><a href="/gallery">Hình ảnh</a></li>
            <li><a href="/faq">Hỏi đáp</a></li>
            <li><a href="/testimonials">Đánh giá</a></li>
            <li><a href="/booking">Đặt lịch</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6 class="mb-3">Liên hệ</h6>
          <ul class="list-unstyled small">
            <li><i class="bi bi-telephone"></i> 0909 123 456</li>
            <li><i class="bi bi-geo-alt"></i> 123 Đường ABC, Q1, TP.HCM</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center py-3 border-top border-secondary-subtle">
      © 2025 Nha Khoa An Việt
    </div>
  </footer>

  <button id="scrollTopBtn" class="btn btn-primary rounded-circle scroll-top"><i class="bi bi-arrow-up"></i></button>

  <!-- Mobile Sticky Action Bar (shows on small screens) -->
  <div class="action-bar" role="navigation" aria-label="Thao tác nhanh trên di động">
    <a href="/services" class="ab-item" data-bs-toggle="tooltip" title="Dịch vụ">
      <i class="bi bi-grid"></i>
      <span class="small">Dịch vụ</span>
    </a>
    <a href="/pricing" class="ab-item" data-bs-toggle="tooltip" title="Bảng giá">
      <i class="bi bi-cash-stack"></i>
      <span class="small">Bảng giá</span>
    </a>
    <a href="tel:0909123456" class="ab-item" data-bs-toggle="tooltip" title="Gọi ngay">
      <i class="bi bi-telephone-outbound"></i>
      <span class="small">Gọi ngay</span>
    </a>
    <a href="/booking" class="ab-item" data-bs-toggle="tooltip" title="Đặt lịch">
      <i class="bi bi-calendar2-check"></i>
      <span class="small">Đặt lịch</span>
    </a>
    <a href="https://www.facebook.com/nha.khoa.an.viet" target="_blank" rel="noopener" class="ab-item" data-bs-toggle="tooltip" title="Facebook">
      <i class="bi bi-facebook"></i>
      <span class="small">Facebook</span>
    </a>
  </div>

  <!-- Floating Quick Action Menu -->
  <div class="floating-menu floating-right" aria-label="Hỗ trợ nhanh">
    <a href="tel:0909123456" class="fm-btn" style="background:#16a34a" aria-label="Gọi ngay" data-bs-toggle="tooltip" title="Gọi ngay">
      <i class="bi bi-telephone-outbound"></i>
    </a>
    <a href="/booking" class="fm-btn fm-book" aria-label="Đặt lịch" data-bs-toggle="tooltip" title="Đặt lịch">
      <i class="bi bi-calendar2-check" aria-hidden="true"></i>
    </a>

    <a href="https://www.facebook.com/nha.khoa.an.viet" class="fm-btn fm-facebook" target="_blank" rel="noopener" aria-label="Facebook" data-bs-toggle="tooltip" title="Facebook">
      <span class="fm-badge online" aria-hidden="true"></span>
      <img src="https://cdn.simpleicons.org/facebook/ffffff" alt="Facebook logo" width="24" height="24" loading="lazy" />
    </a>

  <a href="https://zalo.me/03294975465" class="fm-btn fm-zalo" target="_blank" rel="noopener" aria-label="Zalo" data-bs-toggle="tooltip" title="Zalo">
      <span class="fm-badge online" aria-hidden="true"></span>
      <img src="https://cdn.simpleicons.org/zalo/ffffff" alt="Zalo logo" width="24" height="24" loading="lazy" onerror="this.style.display='none';this.parentElement.classList.add('no-logo')" />
      <span class="visually-hidden">Zalo</span>
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="https://unpkg.com/swup@4"></script>
  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
  <script>
    // Init AOS (scroll animations) - keep effects on scroll
    function initAOS(){
      AOS.init({
        duration:700,
        once:false,        // re-animate when elements re-enter viewport
        mirror:true,       // animate out while scrolling past
        offset:80,
        easing:'ease-out-cubic'
      });
      // Refresh after initial paint to ensure positions are accurate
      setTimeout(()=>{ try{ AOS.refreshHard(); }catch(e){} }, 120);
      // Debounced refresh on resize (bind once)
      if(!window.__aosResizeBound){
        window.__aosResizeBound = true;
        let __aosTO;
        window.addEventListener('resize', ()=>{
          clearTimeout(__aosTO);
          __aosTO = setTimeout(()=>{ try{ AOS.refreshHard(); }catch(e){} }, 150);
        });
      }
    }
    // Navbar shadow on scroll
    function initNavbar(){
      const nav=document.querySelector('.navbar');
      const handler=()=>{ if(window.scrollY>10) nav.classList.add('scrolled'); else nav.classList.remove('scrolled'); };
      handler(); window.addEventListener('scroll',handler);
    }
    // Scroll-to-top button
    function initScrollTop(){
      const btn=document.getElementById('scrollTopBtn');
      const toggle=()=>{ if(window.scrollY>300) btn.classList.add('show'); else btn.classList.remove('show'); };
      window.addEventListener('scroll',toggle); toggle();
      btn.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));
    }
    // Swup page transitions
    const swup = new Swup({
      linkSelector: 'a[href^="/"]:not([data-no-swup])',
      animationScope: '#swup'
    });
    function initTooltips(){
      const triggers=[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      triggers.forEach(el=>{ try{ new bootstrap.Tooltip(el);}catch(e){} });
    }
    function initFloatingMenuFX(){
      const menu=document.querySelector('.floating-menu');
      if(!menu) return;
      // Entrance
      menu.classList.remove('fm-animate');
      // next frame to restart animation
      requestAnimationFrame(()=>{ requestAnimationFrame(()=>menu.classList.add('fm-animate')); });
      // Booking attention pulse every ~15s
      const book=document.querySelector('.fm-btn.fm-book');
      if(book){
        if(window.__fmAttnTimer) clearInterval(window.__fmAttnTimer);
        window.__fmAttnTimer=setInterval(()=>{
          if(window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
          book.classList.add('fm-attn');
          setTimeout(()=>book.classList.remove('fm-attn'), 1200);
        }, 15000);
      }
    }
    function initLightbox(){
      try{ if(window.__glb) { window.__glb.destroy(); } }catch(e){}
      try{ window.__glb = GLightbox({ selector: '.glightbox', touchNavigation:true, loop:true, plyr:{css:false,js:false} }); }catch(e){}
    }
    function initDesktopCTA(){
      const bar = document.querySelector('.desktop-cta');
      if(!bar) return;
      const onScroll = ()=>{
        const y = window.scrollY || document.documentElement.scrollTop;
        if(y>600) bar.classList.add('show'); else bar.classList.remove('show');
      };
      onScroll();
      window.addEventListener('scroll', onScroll, {passive:true});
    }
    function initPage(){initAOS();initNavbar();initScrollTop();initTooltips();initFloatingMenuFX();initLightbox();initDesktopCTA();}
  document.addEventListener('swup:contentReplaced', ()=>{ initPage(); try{ AOS.refreshHard(); }catch(e){} });
    window.addEventListener('DOMContentLoaded', initPage);
    // Touch feedback for floating menu
    (function(){
      function bindFloatingMenu(){
        const menu=document.querySelector('.floating-menu');
        if(!menu) return;
        menu.querySelectorAll('.fm-btn').forEach(btn=>{
          btn.addEventListener('touchstart', ()=>btn.classList.add('pressed'), {passive:true});
          const rm=()=>btn.classList.remove('pressed');
          btn.addEventListener('touchend', rm);
          btn.addEventListener('touchcancel', rm);
        });
      }
      document.addEventListener('swup:contentReplaced', bindFloatingMenu);
      window.addEventListener('DOMContentLoaded', bindFloatingMenu);
    })();
  </script>

  <!-- Desktop Sticky CTA Bar (hidden on small screens) -->
  <div class="desktop-cta" aria-label="Gọi và đặt lịch nhanh">
    <div class="container d-flex align-items-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-3">
        <i class="bi bi-shield-check text-success fs-4"></i>
        <div class="small text-muted">Ưu đãi tháng này: <strong>Miễn phí khám & tư vấn</strong></div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="tel:0909123456" class="btn btn-success"><i class="bi bi-telephone-outbound me-1"></i> Gọi ngay</a>
        <a href="/booking" class="btn btn-primary"><i class="bi bi-calendar2-check me-1"></i> Đặt lịch</a>
      </div>
    </div>
  </div>
</body>
</html>
