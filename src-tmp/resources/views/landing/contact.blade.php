@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="section-title mb-4 text-center">Liên hệ</h2>
  <div class="row g-4">
    <div class="col-md-5">
      <div class="card h-100 p-3">
        <h5 class="mb-3">Thông tin</h5>
        <p class="mb-2"><i class="bi bi-telephone text-primary me-2"></i> 0398 545 666 - 0965 387 122</p>
        <p class="mb-2"><i class="bi bi-envelope text-primary me-2"></i> Nha Khoa An Việt</p>
        <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>xóm 7c, Kim Sơn, Ninh Bình, Việt Nam</p>
        <a class="btn btn-primary mt-2" href="/booking"><i class="bi bi-calendar-check me-1"></i> Đặt lịch</a>
      </div>
    </div>
    <div class="col-md-7">
      <div class="ratio ratio-16x9">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7041.365833990364!2d106.06969124899474!3d19.98029266093309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31366b006245af15%3A0x31b06b085b048bae!2sNha%20Khoa%20An%20Vi%E1%BB%87t!5e0!3m2!1svi!2sus!4v1757955300386!5m2!1svi!2sus" class="rounded-4 border-0" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ Nha Khoa An Việt"></iframe>
      </div>
    </div>
  </div>
</div>
@endsection
