<div data-page-title="Quản lý hình ảnh">
<div class="container-fluid px-0 py-2">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0">Quản lý hình ảnh</h1>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.appointments.index') }}" 
         hx-get="{{ route('admin.appointments.index') }}?partial=1"
         hx-target="#adminMainContent"
         hx-push-url="{{ route('admin.appointments.index') }}"
         hx-swap="innerHTML transition:true"
         class="btn btn-outline-secondary"><i class="bi bi-calendar"></i> Lịch hẹn</a>
      <a href="{{ route('admin.patients.index') }}" 
         hx-get="{{ route('admin.patients.index') }}?partial=1"
         hx-target="#adminMainContent"
         hx-push-url="{{ route('admin.patients.index') }}"
         hx-swap="innerHTML transition:true"
         class="btn btn-outline-secondary"><i class="bi bi-people"></i> Bệnh nhân</a>
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <h3 class="h5 mt-4 mb-3">Ảnh Bác sĩ</h3>
  <div class="row g-3 mb-4">
    @foreach($doctors as $d)
      <div class="col-md-3">
        <div class="card h-100">
          <div class="ratio ratio-1x1">
            @if($d->image)
              <img src="/media/doctor/{{ $d->id }}" class="w-100 h-100 object-fit-cover" alt="{{ $d->name }}">
            @else
              <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="{{ $d->name }}">
            @endif
          </div>
          <div class="card-body">
            <h6 class="mb-1">{{ $d->name }}</h6>
            <form action="{{ route('admin.doctors.upload',$d->id) }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mt-2">
              @csrf
              <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
              <button class="btn btn-sm btn-primary"><i class="bi bi-upload"></i></button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <h3 class="h5 mt-4 mb-3">Ảnh Dịch vụ</h3>
  <div class="row g-3 mb-4">
    @foreach($services as $s)
      <div class="col-md-3">
        <div class="card h-100">
          <div class="ratio ratio-16x9">
            @if($s->image)
              <img src="/media/service/{{ $s->id }}" class="w-100 h-100 object-fit-cover" alt="{{ $s->name }}">
            @else
              <img src="https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=1200&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="{{ $s->name }}">
            @endif
          </div>
          <div class="card-body">
            <h6 class="mb-1">{{ $s->name }}</h6>
            <form action="{{ route('admin.services.upload', $s->id) }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mt-2">
              @csrf
              <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
              <button class="btn btn-sm btn-primary"><i class="bi bi-upload"></i></button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <h3 class="h5 mt-4 mb-3">Banner</h3>
  <div class="row g-3">
    @foreach($banners as $b)
      <div class="col-md-6">
        <div class="card h-100">
          <div class="ratio ratio-21x9">
            @if($b->image)
              <img src="/media/banner/{{ $b->id }}" class="w-100 h-100 object-fit-cover" alt="Banner {{ $b->id }}">
            @else
              <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?q=80&w=1200&auto=format&fit=crop" class="w-100 h-100 object-fit-cover" alt="Banner {{ $b->id }}">
            @endif
          </div>
          <div class="card-body">
            <h6 class="mb-1">Banner #{{ $b->id }}</h6>
            <form action="{{ route('admin.banners.upload', $b->id) }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mt-2">
              @csrf
              <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
              <button class="btn btn-sm btn-primary"><i class="bi bi-upload"></i></button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
</div>
