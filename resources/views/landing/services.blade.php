@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="section-title text-center mb-4">Dịch vụ & Bảng giá</h2>
  @isset($services)
  <div class="row g-4">
    @foreach($services as $s)
    <div class="col-md-4">
      <div class="card h-100">
        @if($s->image)
          <img
            src="/media/service/{{ $s->id }}?w=480&fit=cover&dpr=1&f=webp&v={{ $s->updated_at?->timestamp ?? time() }}"
            srcset="/media/service/{{ $s->id }}?w=480&fit=cover&dpr=1&f=webp&v={{ $s->updated_at?->timestamp ?? time() }} 1x,
                    /media/service/{{ $s->id }}?w=480&fit=cover&dpr=2&f=webp&v={{ $s->updated_at?->timestamp ?? time() }} 2x"
            sizes="(min-width: 768px) 33vw, 100vw"
            class="card-img-top"
            alt="{{ $s->name }}">
        @else
          <img src="https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=1200&auto=format&fit=crop" class="card-img-top" alt="{{ $s->name }}">
        @endif
        <div class="card-body">
          <h5 class="card-title mb-1">{{ $s->name }}</h5>
          <p class="text-muted mb-2">{{ $s->description }}</p>
          <div class="d-flex align-items-center justify-content-between">
            <span class="fw-bold text-primary">{{ number_format((float)$s->price) }} VND</span>
            <a href="/booking" class="btn btn-sm btn-outline-primary">Đặt lịch</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="mt-4">
    {{ $services->links() }}
  </div>
  @endisset
</div>
@endsection
