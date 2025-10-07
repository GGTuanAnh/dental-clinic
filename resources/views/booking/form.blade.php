@extends('layouts.app')

@section('content')
<div class="container mt-5">
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-calendar-check me-1"></i> Đặt lịch khám</div>
    <div class="card-body">
      <form method="POST" action="{{ route('booking.store') }}" class="row g-3">
        @csrf
        <!-- Honeypot: bots will fill this; hidden from users -->
        <input type="text" name="company" class="d-none" tabindex="-1" autocomplete="off">
        <div class="col-md-6">
          <label class="form-label">Họ tên</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Số điện thoại</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Dịch vụ</label>
          <select name="service_id" class="form-select" required>
            @foreach($services as $s)
              <option value="{{ $s->id }}" @selected(old('service_id')==$s->id)>{{ $s->name }} - {{ number_format($s->price) }} VND</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Ngày giờ hẹn</label>
          <input type="datetime-local" name="appointment_at" class="form-control" value="{{ old('appointment_at') }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Ghi chú</label>
          <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary"><i class="bi bi-send me-1"></i> Xác nhận đặt lịch</button>
          <a class="btn btn-outline-secondary" href="/">Về trang chủ</a>
        </div>
      </form>
      <p class="text-muted small mt-3">Lưu ý: Thời gian hiển thị theo múi giờ máy của bạn. Chúng tôi sẽ liên hệ xác nhận.</p>
    </div>
  </div>
</div>
@endsection
