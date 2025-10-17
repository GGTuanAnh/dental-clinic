@extends('layouts.admin')
@section('page-title','Ảnh bác sĩ')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Hình ảnh','url'=>route('admin.images.index')],
    ['label'=>'Bác sĩ']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0 py-2">
  <h2 class="h5 mb-3 fw-semibold">Cập nhật ảnh bác sĩ</h2>
  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="row g-4">
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

  <div class="mt-4">{{ $doctors->links() }}</div>
</div>
@endsection
