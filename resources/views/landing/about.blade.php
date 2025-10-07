@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="row align-items-center g-4">
    <div class="col-lg-6">
  <img src="https://images.unsplash.com/photo-1581594693700-89e55fcd7867?q=80&w=1600&auto=format&fit=crop" class="img-fluid rounded-4 shadow" alt="Phòng khám">
    </div>
    <div class="col-lg-6">
      <h2 class="section-title mb-3">Về Nha Khoa An Việt</h2>
      <p class="text-muted">Với hơn 10 năm kinh nghiệm, chúng tôi cam kết mang tới trải nghiệm chăm sóc răng miệng chất lượng cao, an toàn và tận tâm.</p>
      <ul class="list-unstyled mt-3">
        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Bác sĩ chuyên môn sâu</li>
        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Thiết bị chuẩn quốc tế</li>
        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Quy trình chuẩn hoá</li>
      </ul>
      <a href="/services" class="btn btn-primary mt-2">Xem dịch vụ</a>
    </div>
  </div>
  
  @if(isset($team) && $team->count())
  <hr class="my-5">
  <h3 class="section-title mb-4" data-aos="fade-up">Đội ngũ bác sĩ</h3>
  @foreach($team as $d)
    <div class="card mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index*100 }}">
      <div class="card-body p-4">
        <div class="row g-3 align-items-center">
          <div class="col-md-3 text-center">
            @if($d->photo)
              <img
                src="/media/doctor/{{ $d->id }}?w=120&h=120&fit=cover&dpr=1&f=webp&v={{ $d->updated_at?->timestamp ?? time() }}"
                srcset="/media/doctor/{{ $d->id }}?w=120&h=120&fit=cover&dpr=1&f=webp&v={{ $d->updated_at?->timestamp ?? time() }} 1x, /media/doctor/{{ $d->id }}?w=120&h=120&fit=cover&dpr=2&f=webp&v={{ $d->updated_at?->timestamp ?? time() }} 2x"
                class="rounded-circle mb-2"
                style="width:120px;height:120px;object-fit:cover"
                alt="{{ $d->name }}">
            @else
              <div class="icon-circle mx-auto mb-2"><i class="bi bi-person-fill fs-4"></i></div>
            @endif
            <div class="mt-1">
              <a href="/booking" class="btn btn-sm btn-primary"><i class="bi bi-calendar-check me-1"></i> Đặt lịch với bác sĩ</a>
            </div>
          </div>
          <div class="col-md-9">
            <h5 class="mb-1">{{ $d->name }}</h5>
            <div class="text-muted mb-2">{{ $d->specialty }}</div>

            <div class="mb-3">
              <h6 class="mb-1">Giới thiệu</h6>
              <p class="mb-0 text-muted">{{ $d->bio ?? 'Bác sĩ tận tâm, nhiều kinh nghiệm trong lĩnh vực nha khoa.' }}</p>
            </div>

            <div class="mb-3">
              <h6 class="mb-1">Chứng chỉ & Thành tích</h6>
              <ul class="text-muted small mb-0">
                <li>Chứng chỉ chỉnh nha quốc tế (ví dụ)</li>
                <li>Thành viên hội nha khoa (ví dụ)</li>
                <li>1000+ ca điều trị thành công (ví dụ)</li>
              </ul>
            </div>

            <div>
              <h6 class="mb-1">Ca điển hình</h6>
              <div class="d-flex gap-2 flex-wrap">
                <a href="https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=1200&auto=format&fit=crop" class="glightbox" data-gallery="doc-{{ $d->id }}" aria-label="Ảnh trước điều trị">
                  <img src="https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=400&auto=format&fit=crop" class="rounded" style="width:120px;height:80px;object-fit:cover" alt="Trước">
                </a>
                <a href="https://images.unsplash.com/photo-1606811971618-4486d14f3f53?q=80&w=1200&auto=format&fit=crop" class="glightbox" data-gallery="doc-{{ $d->id }}" aria-label="Ảnh sau điều trị">
                  <img src="https://images.unsplash.com/photo-1606811971618-4486d14f3f53?q=80&w=400&auto=format&fit=crop" class="rounded" style="width:120px;height:80px;object-fit:cover" alt="Sau">
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  @endforeach
  @endif
</div>
@endsection
