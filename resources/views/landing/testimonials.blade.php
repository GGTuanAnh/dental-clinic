@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="section-title text-center mb-4">Khách hàng nói gì?</h2>
  <div class="row g-4">
    @php
      $reviews = [
        ['name' => 'Minh Anh', 'text' => 'Dịch vụ rất tốt, bác sĩ tận tâm và nhẹ nhàng.', 'stars' => 5],
        ['name' => 'Quốc Huy', 'text' => 'Không gian sạch sẽ, đặt lịch nhanh chóng.', 'stars' => 4],
        ['name' => 'Lan Phương', 'text' => 'Invisalign đeo thoải mái, tái khám đúng hẹn.', 'stars' => 5],
      ];
    @endphp
    @foreach($reviews as $i => $r)
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $i*100 }}">
      <div class="card h-100 p-3">
        <div class="d-flex align-items-center mb-2">
          <div class="icon-circle me-2"><i class="bi bi-chat-heart"></i></div>
          <strong>{{ $r['name'] }}</strong>
        </div>
        <p class="text-muted">"{{ $r['text'] }}"</p>
        <div class="text-warning">
          @for($s=0;$s<5;$s++)
            <i class="bi {{ $s < $r['stars'] ? 'bi-star-fill' : 'bi-star' }}"></i>
          @endfor
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
