@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="section-title text-center mb-4">Câu hỏi thường gặp</h2>
  <div class="accordion" id="faqAcc" data-aos="fade-up">
    @php
      $faqs = [
        ['q' => 'Đặt lịch như thế nào?', 'a' => 'Bạn có thể đặt lịch trực tuyến trên website hoặc gọi trực tiếp hotline.'],
        ['q' => 'Thời gian làm việc của phòng khám?', 'a' => 'T2–CN: 8:00–20:00 (nghỉ trưa 12:00–13:30).'],
        ['q' => 'Phương thức thanh toán?', 'a' => 'Tiền mặt, thẻ, chuyển khoản. Hỗ trợ trả góp cho một số dịch vụ.'],
        ['q' => 'Chính sách bảo hành?', 'a' => 'Bảo hành theo từng dịch vụ. Chi tiết sẽ được tư vấn trước khi điều trị.'],
      ];
    @endphp
    @foreach($faqs as $i => $f)
    <div class="accordion-item">
      <h2 class="accordion-header" id="hq{{ $i }}">
        <button class="accordion-button {{ $i>0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#ha{{ $i }}">{{ $f['q'] }}</button>
      </h2>
      <div id="ha{{ $i }}" class="accordion-collapse collapse {{ $i==0 ? 'show' : '' }}" data-bs-parent="#faqAcc">
        <div class="accordion-body">{{ $f['a'] }}</div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
