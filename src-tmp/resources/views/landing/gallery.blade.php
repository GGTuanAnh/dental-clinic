@extends('layouts.app')

@section('content')
<div class="container py-5">
  <!-- Header -->
  <div class="text-center mb-5" data-aos="fade-up">
    <h1 class="display-5 fw-bold mb-3">Thư viện hình ảnh</h1>
    <p class="lead text-muted">Khám phá cơ sở vật chất, dịch vụ và kết quả điều trị của chúng tôi</p>
  </div>

  <!-- Featured Images -->
  @if($featured->count() > 0)
  <section class="mb-5">
    <h3 class="h4 mb-4" data-aos="fade-right">✨ Nổi bật</h3>
    <div class="row g-4">
      @foreach($featured->take(6) as $idx => $image)
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $idx*50 }}">
        <div class="card h-100 overflow-hidden shadow-sm">
          <a href="{{ $image->image_url }}" class="glightbox" 
             data-gallery="featured" 
             data-title="{{ $image->title }}"
             data-description="{{ $image->description }}">
            <img src="{{ $image->image_url }}" 
                 class="card-img-top" 
                 alt="{{ $image->title }}"
                 style="height: 250px; object-fit: cover;"
                 loading="lazy">
          </a>
          <div class="card-body">
            <h5 class="card-title h6 mb-2">{{ $image->title }}</h5>
            @if($image->description)
              <p class="card-text small text-muted mb-0">{{ $image->description }}</p>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  @endif

  <!-- Categories Tabs -->
  <section class="mb-5">
    <ul class="nav nav-pills mb-4 justify-content-center" id="galleryTabs" role="tablist" data-aos="fade-up">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button">
          <i class="bi bi-grid"></i> Tất cả
        </button>
      </li>
      @if(isset($byCategory['clinic']) && $byCategory['clinic']->count() > 0)
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="clinic-tab" data-bs-toggle="pill" data-bs-target="#clinic" type="button">
          <i class="bi bi-building"></i> Phòng khám
        </button>
      </li>
      @endif
      @if(isset($byCategory['treatment']) && $byCategory['treatment']->count() > 0)
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="treatment-tab" data-bs-toggle="pill" data-bs-target="#treatment" type="button">
          <i class="bi bi-heart-pulse"></i> Điều trị
        </button>
      </li>
      @endif
      @if(isset($byCategory['before_after']) && $byCategory['before_after']->count() > 0)
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="ba-tab" data-bs-toggle="pill" data-bs-target="#ba" type="button">
          <i class="bi bi-arrow-left-right"></i> Trước/Sau
        </button>
      </li>
      @endif
      @if(isset($byCategory['team']) && $byCategory['team']->count() > 0)
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="team-tab" data-bs-toggle="pill" data-bs-target="#team" type="button">
          <i class="bi bi-people"></i> Đội ngũ
        </button>
      </li>
      @endif
      @if(isset($byCategory['equipment']) && $byCategory['equipment']->count() > 0)
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="equipment-tab" data-bs-toggle="pill" data-bs-target="#equipment" type="button">
          <i class="bi bi-gear"></i> Thiết bị
        </button>
      </li>
      @endif
    </ul>

    <div class="tab-content" id="galleryTabContent">
      <!-- All Images -->
      <div class="tab-pane fade show active" id="all" role="tabpanel">
        <div class="row g-3">
          @foreach($images as $idx => $image)
          <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $idx*20 }}">
            <a href="{{ $image->image_url }}" class="d-block glightbox" 
               data-gallery="all" 
               data-title="{{ $image->title }}"
               data-description="{{ $image->description }}">
              <div class="ratio ratio-1x1">
                <img src="{{ $image->image_url }}" 
                     class="rounded shadow-sm object-fit-cover w-100 h-100" 
                     alt="{{ $image->title }}"
                     loading="lazy">
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Clinic -->
      @if(isset($byCategory['clinic']))
      <div class="tab-pane fade" id="clinic" role="tabpanel">
        <div class="row g-3">
          @foreach($byCategory['clinic'] as $idx => $image)
          <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ $idx*20 }}">
            <a href="{{ $image->image_url }}" class="d-block glightbox" 
               data-gallery="clinic" 
               data-title="{{ $image->title }}">
              <div class="ratio ratio-4x3">
                <img src="{{ $image->image_url }}" 
                     class="rounded shadow-sm object-fit-cover" 
                     alt="{{ $image->title }}">
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Treatment -->
      @if(isset($byCategory['treatment']))
      <div class="tab-pane fade" id="treatment" role="tabpanel">
        <div class="row g-3">
          @foreach($byCategory['treatment'] as $idx => $image)
          <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ $idx*20 }}">
            <a href="{{ $image->image_url }}" class="d-block glightbox" 
               data-gallery="treatment" 
               data-title="{{ $image->title }}">
              <div class="ratio ratio-4x3">
                <img src="{{ $image->image_url }}" 
                     class="rounded shadow-sm object-fit-cover" 
                     alt="{{ $image->title }}">
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Before/After -->
      @if(isset($byCategory['before_after']))
      <div class="tab-pane fade" id="ba" role="tabpanel">
        <div class="row g-4">
          @foreach($byCategory['before_after'] as $idx => $image)
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $idx*50 }}">
            <div class="card h-100">
              <a href="{{ $image->image_url }}" class="glightbox" 
                 data-gallery="ba" 
                 data-title="{{ $image->title }}">
                <img src="{{ $image->image_url }}" 
                     class="card-img-top" 
                     alt="{{ $image->title }}"
                     style="height: 300px; object-fit: cover;">
              </a>
              <div class="card-body">
                <h5 class="card-title">{{ $image->title }}</h5>
                @if($image->description)
                  <p class="card-text text-muted">{{ $image->description }}</p>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Team -->
      @if(isset($byCategory['team']))
      <div class="tab-pane fade" id="team" role="tabpanel">
        <div class="row g-3">
          @foreach($byCategory['team'] as $idx => $image)
          <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ $idx*20 }}">
            <a href="{{ $image->image_url }}" class="d-block glightbox" 
               data-gallery="team" 
               data-title="{{ $image->title }}">
              <div class="ratio ratio-4x3">
                <img src="{{ $image->image_url }}" 
                     class="rounded shadow-sm object-fit-cover" 
                     alt="{{ $image->title }}">
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Equipment -->
      @if(isset($byCategory['equipment']))
      <div class="tab-pane fade" id="equipment" role="tabpanel">
        <div class="row g-3">
          @foreach($byCategory['equipment'] as $idx => $image)
          <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ $idx*20 }}">
            <a href="{{ $image->image_url }}" class="d-block glightbox" 
               data-gallery="equipment" 
               data-title="{{ $image->title }}">
              <div class="ratio ratio-4x3">
                <img src="{{ $image->image_url }}" 
                     class="rounded shadow-sm object-fit-cover" 
                     alt="{{ $image->title }}">
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @endif
    </div>
  </section>

  <!-- CTA Section -->
  <section class="text-center py-5 bg-light rounded" data-aos="fade-up">
    <h3 class="h4 mb-3">Bạn muốn có nụ cười đẹp như thế này?</h3>
    <p class="text-muted mb-4">Đặt lịch hẹn ngay hôm nay để được tư vấn miễn phí!</p>
    <a href="{{ url('/booking') }}" class="btn btn-primary btn-lg">
      <i class="bi bi-calendar-event me-2"></i>Đặt lịch ngay
    </a>
  </section>
</div>
@endsection
