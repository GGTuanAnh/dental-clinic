@extends('layouts.app')

@section('content')
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6" data-aos="fade-right">
        <h1 class="display-5 mb-3">Nha Khoa An Việt – Nụ cười tự tin bắt đầu từ đây</h1>
        <p class="mb-4">Chăm sóc răng miệng toàn diện với đội ngũ bác sĩ giàu kinh nghiệm và công nghệ hiện đại.</p>
        <a href="{{ url('/booking') }}" class="btn btn-primary btn-lg me-2"><i class="bi bi-calendar-event me-1"></i> Đặt lịch ngay</a>
        <a href="{{ url('/services') }}" class="btn btn-outline-primary btn-lg">Xem dịch vụ</a>
      </div>
      <div class="col-lg-6 text-center" data-aos="fade-left">
        @if(isset($banner) && $banner && $banner->image)
          <img
            src="/media/banner/{{ $banner->id }}?w=900&fit=cover&dpr=1&f=webp&v={{ $banner->updated_at?->timestamp ?? time() }}"
            srcset="/media/banner/{{ $banner->id }}?w=600&fit=cover&dpr=1&f=webp&v={{ $banner->updated_at?->timestamp ?? time() }} 600w,
                    /media/banner/{{ $banner->id }}?w=900&fit=cover&dpr=1&f=webp&v={{ $banner->updated_at?->timestamp ?? time() }} 900w,
                    /media/banner/{{ $banner->id }}?w=1200&fit=cover&dpr=1&f=webp&v={{ $banner->updated_at?->timestamp ?? time() }} 1200w"
            sizes="(min-width: 992px) 50vw, 100vw"
            alt="Banner"
            class="img-fluid rounded-4 shadow">
        @else
          <img src="https://images.unsplash.com/photo-1588771930291-88d8d421a27e?q=80&w=1600&auto=format&fit=crop" alt="Phòng khám nha khoa" class="img-fluid rounded-4 shadow">
        @endif
      </div>
    </div>
  </div>
</section>

<!-- Trustbar: social proof badges -->
<div class="py-2" style="background:#f8fafc">
  <div class="container">
    <div class="trustbar" data-aos="fade-up">
      <div class="trust-item"><span class="stars">★★★★★</span> <span>4.9/5 từ 500+ đánh giá</span></div>
      <span class="dot d-none d-md-inline-block"></span>
      <div class="trust-item"><i class="bi bi-shield-check text-success"></i> <span>Bảo hành rõ ràng</span></div>
      <span class="dot d-none d-md-inline-block"></span>
      <div class="trust-item"><i class="bi bi-clock-history text-primary"></i> <span>Lịch linh hoạt, hẹn nhanh</span></div>
    </div>
  </div>
  </div>

<section class="py-4 py-md-5 bg-light">
  <div class="container">
    <div class="row g-3 g-md-4">
      <div class="col-6 col-md-3" data-aos="zoom-in-up" data-aos-delay="0">
        <a href="{{ url('/pricing') }}" class="text-decoration-none text-reset d-block h-100">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-3 p-md-4">
              <div class="icon-circle mb-2"><i class="bi bi-currency-dollar fs-4"></i></div>
              <div class="fw-semibold">Bảng giá</div>
              <div class="text-muted small">Rõ ràng, minh bạch chi phí</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3" data-aos="zoom-in-up" data-aos-delay="100">
        <a href="{{ url('/gallery') }}" class="text-decoration-none text-reset d-block h-100">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-3 p-md-4">
              <div class="icon-circle mb-2"><i class="bi bi-images fs-4"></i></div>
              <div class="fw-semibold">Hình ảnh</div>
              <div class="text-muted small">Trước & Sau điều trị</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3" data-aos="zoom-in-up" data-aos-delay="200">
        <a href="{{ url('/faq') }}" class="text-decoration-none text-reset d-block h-100">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-3 p-md-4">
              <div class="icon-circle mb-2"><i class="bi bi-question-circle fs-4"></i></div>
              <div class="fw-semibold">Hỏi đáp</div>
              <div class="text-muted small">Giải đáp thắc mắc thường gặp</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3" data-aos="zoom-in-up" data-aos-delay="300">
        <a href="{{ url('/testimonials') }}" class="text-decoration-none text-reset d-block h-100">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center p-3 p-md-4">
              <div class="icon-circle mb-2"><i class="bi bi-star-fill fs-4"></i></div>
              <div class="fw-semibold">Đánh giá</div>
              <div class="text-muted small">Khách hàng nói gì về chúng tôi</div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  </section>

<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-4" data-aos="fade-up">Tại sao chọn chúng tôi</h2>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
        <div class="card h-100 p-3 feature">
          <div class="icon-circle mb-3"><i class="bi bi-patch-check-fill fs-4"></i></div>
          <h5>Đội ngũ chuyên môn cao</h5>
          <p>Bác sĩ nhiều năm kinh nghiệm, tận tâm và chuyên nghiệp.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 p-3 feature">
          <div class="icon-circle mb-3"><i class="bi bi-cpu-fill fs-4"></i></div>
          <h5>Trang thiết bị hiện đại</h5>
          <p>Ứng dụng công nghệ tiên tiến, đảm bảo an toàn và hiệu quả.</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 p-3 feature">
          <div class="icon-circle mb-3"><i class="bi bi-emoji-smile-fill fs-4"></i></div>
          <h5>Chăm sóc tận tình</h5>
          <p>Trải nghiệm nhẹ nhàng, thân thiện, minh bạch chi phí.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Results strip: Before/After + simple process -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7" data-aos="fade-right">
        <div class="ba__wrap position-relative">
          <img src="https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=1600&auto=format&fit=crop" class="ba__img" alt="Trước điều trị">
          <img src="https://images.unsplash.com/photo-1606811971618-4486d14f3f53?q=80&w=1600&auto=format&fit=crop" class="ba__img ba__after" alt="Sau điều trị">
          <div class="ba__divider" aria-hidden="true"></div>
          <input type="range" min="0" max="100" value="50" class="ba__range" aria-label="So sánh trước sau" oninput="(function(el){const v=el.value;el.parentElement.querySelector('.ba__after').style.clipPath=`inset(0 0 0 ${100-v}% )`;el.parentElement.querySelector('.ba__divider').style.left=v+'%';})(this)">
        </div>
      </div>
      <div class="col-lg-5" data-aos="fade-left">
        <h3 class="mb-3">Kết quả rõ ràng chỉ sau vài buổi</h3>
        <ul class="list-unstyled m-0">
          <li class="d-flex align-items-start mb-2"><i class="bi bi-1-circle text-primary me-2"></i><span>Khám & chẩn đoán bằng hình ảnh</span></li>
          <li class="d-flex align-items-start mb-2"><i class="bi bi-2-circle text-primary me-2"></i><span>Lập kế hoạch điều trị minh bạch</span></li>
          <li class="d-flex align-items-start mb-2"><i class="bi bi-3-circle text-primary me-2"></i><span>Điều trị nhẹ nhàng, ít đau</span></li>
          <li class="d-flex align-items-start"><i class="bi bi-4-circle text-primary me-2"></i><span>Theo dõi & bảo hành sau điều trị</span></li>
        </ul>
        <a href="{{ url('/gallery') }}" class="btn btn-outline-primary mt-3">Xem thêm ca thực tế</a>
      </div>
    </div>
  </div>
  </section>

<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-4" data-aos="fade-up">Dịch vụ nổi bật</h2>
    <div class="row g-4">
      @if(isset($hotServices) && $hotServices->count())
        @foreach($hotServices as $svc)
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index*100 }}">
          <div class="card h-100">
            @if($svc->image)
              <img
                src="/media/service/{{ $svc->id }}?w=400&fit=cover&dpr=1&f=webp&v={{ $svc->updated_at?->timestamp ?? time() }}"
                srcset="/media/service/{{ $svc->id }}?w=400&fit=cover&dpr=1&f=webp&v={{ $svc->updated_at?->timestamp ?? time() }} 1x,
                        /media/service/{{ $svc->id }}?w=400&fit=cover&dpr=2&f=webp&v={{ $svc->updated_at?->timestamp ?? time() }} 2x"
                sizes="(min-width: 768px) 33vw, 100vw"
                class="card-img-top"
                alt="{{ $svc->name }}">
            @else
              <img src="https://images.unsplash.com/photo-1606811971618-4486d14f3f53?q=80&w=1200&auto=format&fit=crop" class="card-img-top" alt="{{ $svc->name }}">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $svc->name }}</h5>
              <p class="card-text text-muted">{{ $svc->description }}</p>
            </div>
          </div>
        </div>
        @endforeach
      @else
        <div class="col-12 text-center text-muted">Đang cập nhật dịch vụ...</div>
      @endif
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-4" data-aos="fade-up">Đội ngũ bác sĩ</h2>
    <div class="row g-4">
      @if(isset($team) && $team->count())
        @foreach($team as $d)
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index*100 }}">
          <div class="card h-100 text-center p-3">
            @if($d->photo)
              <img
                src="/media/doctor/{{ $d->id }}?w=100&h=100&fit=cover&dpr=1&f=webp&v={{ $d->updated_at?->timestamp ?? time() }}"
                srcset="/media/doctor/{{ $d->id }}?w=100&h=100&fit=cover&dpr=1&f=webp&v={{ $d->updated_at?->timestamp ?? time() }} 1x,
                        /media/doctor/{{ $d->id }}?w=100&h=100&fit=cover&dpr=2&f=webp&v={{ $d->updated_at?->timestamp ?? time() }} 2x"
                class="rounded-circle mx-auto mb-2"
                style="width:100px;height:100px;object-fit:cover"
                alt="{{ $d->name }}">
            @else
              <img src="https://images.unsplash.com/photo-1527613426441-4da17471b66d?q=80&w=400&auto=format&fit=crop" class="rounded-circle mx-auto mb-2" style="width:100px;height:100px;object-fit:cover" alt="{{ $d->name }}">
            @endif
            <h6 class="mb-0">{{ $d->name }}</h6>
            <small class="text-muted">{{ $d->specialty }}</small>
            <p class="mt-2 text-muted">{{ $d->bio }}</p>
          </div>
        </div>
        @endforeach
      @else
        <div class="col-12 text-center text-muted">Đang cập nhật đội ngũ...</div>
      @endif
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container" data-aos="fade-up">
    <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm d-flex flex-column flex-md-row align-items-center justify-content-between">
      <div>
        <h4 class="mb-1">Sẵn sàng cho nụ cười mới?</h4>
        <p class="text-muted mb-0">Đặt lịch ngay hôm nay để được tư vấn miễn phí. <span class="badge text-bg-success ms-1"><i class="bi bi-gift-fill me-1"></i>Ưu đãi tháng này</span></p>
      </div>
      <a href="{{ url('/booking') }}" class="btn btn-primary btn-lg mt-3 mt-md-0">Đặt lịch</a>
    </div>
  </div>
</section>
@endsection
