@extends('layouts.admin')
@section('page-title','Ảnh dịch vụ')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Hình ảnh','url'=>route('admin.images.index')],
    ['label'=>'Dịch vụ']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0 py-2">
  <h2 class="h5 mb-3 fw-semibold">Cập nhật ảnh dịch vụ</h2>
  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="row g-4">
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

  <div class="mt-4">{{ $services->links() }}</div>
</div>
@endsection
