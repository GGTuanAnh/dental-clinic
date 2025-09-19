@extends('layouts.admin')
@section('page-title','Hình ảnh')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Hình ảnh']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0 py-2">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0">Quản lý hình ảnh</h1>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary"><i class="bi bi-calendar"></i> Lịch hẹn</a>
      <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary"><i class="bi bi-people"></i> Bệnh nhân</a>
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="row g-4">
    <div class="col-12">
      <h5 class="mb-2">Banner</h5>
      <div class="card p-3">
        <div class="row g-3 align-items-center">
          @foreach($banners as $b)
            <div class="col-md-6 d-flex align-items-center gap-3">
              <div class="ratio ratio-16x9" style="max-width: 260px;">
                @if($b->image)
                  <img src="/media/banner/{{ $b->id }}" class="w-100 h-100 object-fit-cover rounded" alt="banner">
                @else
                  <img src="https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=1200&auto=format&fit=crop" class="w-100 h-100 object-fit-cover rounded" alt="placeholder">
                @endif
              </div>
              <form action="{{ route('admin.banners.upload', $b->id) }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2 w-100">
                @csrf
                <input type="file" name="image" accept="image/*" class="form-control" required>
                <button class="btn btn-primary"><i class="bi bi-upload"></i> Tải lên</button>
              </form>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="col-12">
      <h5 class="mb-2">Bác sĩ</h5>
      <div class="row g-3">
        @foreach($doctors as $d)
          <div class="col-md-4">
            <div class="card h-100 text-center p-3">
              @if($d->photo)
                <img src="/media/doctor/{{ $d->id }}" class="rounded-circle mx-auto mb-2" style="width:100px;height:100px;object-fit:cover" alt="{{ $d->name }}">
              @else
                <div class="icon-circle mx-auto mb-2"><i class="bi bi-person-fill fs-4"></i></div>
              @endif
              <h6 class="mb-1">{{ $d->name }}</h6>
              <small class="text-muted">{{ $d->specialty }}</small>
              <form action="{{ route('admin.doctors.upload', $d->id) }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center gap-2 mt-3">
                @csrf
                <input type="file" name="photo" accept="image/*" class="form-control" required>
                <button class="btn btn-primary">Tải lên</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="col-12">
      <h5 class="mb-2">Dịch vụ</h5>
      <div class="row g-3">
        @foreach($services as $s)
          <div class="col-md-4">
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
                  <input type="file" name="image" accept="image/*" class="form-control" required>
                  <button class="btn btn-primary">Tải lên</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
