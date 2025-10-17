@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="section-title text-center mb-4">Bảng giá chi tiết</h2>
  <div class="table-responsive" data-aos="fade-up">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Dịch vụ</th>
          <th>Mô tả</th>
          <th class="text-end">Giá (VND)</th>
        </tr>
      </thead>
      <tbody class="text-muted">
        <tr>
          <td>Khám & Tư vấn</td>
          <td>Khám tổng quát, chụp hình, tư vấn lộ trình</td>
          <td class="text-end">0</td>
        </tr>
        <tr>
          <td>Tẩy trắng răng</td>
          <td>Whitening công nghệ mới, an toàn</td>
          <td class="text-end">1.200.000 – 2.500.000</td>
        </tr>
        <tr>
          <td>Niềng răng Invisalign</td>
          <td>i7 / Lite / Full tuỳ mức độ</td>
          <td class="text-end">45.000.000 – 130.000.000+</td>
        </tr>
        <tr>
          <td>Trồng răng Implant</td>
          <td>Implant tiêu chuẩn, bảo hành dài hạn</td>
          <td class="text-end">15.000.000 – 28.000.000 / trụ</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="alert alert-success mt-3" data-aos="fade-up">Giá có thể thay đổi theo tình trạng lâm sàng. Vui lòng đặt lịch để được báo giá chính xác.</div>

  <div class="text-center mt-4" data-aos="zoom-in">
    <a href="/booking" class="btn btn-primary btn-lg">Đặt lịch tư vấn miễn phí</a>
  </div>
</div>
@endsection
