@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="section-title text-center mb-4">Trước & Sau</h2>
  <div class="row g-4">
    @php
      $pairs = [
        ['before' => 'https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=1200&auto=format&fit=crop', 'after' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f53?q=80&w=1200&auto=format&fit=crop'],
        ['before' => 'https://images.unsplash.com/photo-1556742393-d75f468bfcb0?q=80&w=1200&auto=format&fit=crop', 'after' => 'https://images.unsplash.com/photo-1527613426441-4da17471b66d?q=80&w=1200&auto=format&fit=crop'],
        ['before' => 'https://images.unsplash.com/photo-1598257006542-85853129b3e3?q=80&w=1200&auto=format&fit=crop', 'after' => 'https://images.unsplash.com/photo-1597348930068-5f2b07e25c23?q=80&w=1200&auto=format&fit=crop'],
      ];
    @endphp
    @foreach($pairs as $idx => $p)
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $idx*100 }}">
      <div class="card h-100 overflow-hidden">
        <a href="{{ $p['after'] }}" class="glightbox" data-gallery="ba-{{ $idx }}" data-title="Sau điều trị">
          <img src="{{ $p['after'] }}" class="card-img-top" alt="Sau điều trị {{ $idx+1 }}" loading="lazy">
        </a>
        <div class="card-body">
          <div class="d-flex gap-2">
            <a href="{{ $p['before'] }}" class="btn btn-sm btn-outline-secondary glightbox" data-gallery="ba-{{ $idx }}" data-title="Trước điều trị">Trước</a>
            <a href="{{ $p['after'] }}" class="btn btn-sm btn-primary glightbox" data-gallery="ba-{{ $idx }}" data-title="Sau điều trị">Sau</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
