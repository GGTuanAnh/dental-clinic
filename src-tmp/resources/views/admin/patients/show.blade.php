@extends('layouts.admin')
@section('page-title','Hồ sơ bệnh nhân')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Bệnh nhân','url'=>route('admin.patients.index')],
    ['label'=>'Hồ sơ']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h4 mb-1">Hồ sơ bệnh nhân</h1>
      <div class="text-muted">{{ $patient->name }} · {{ $patient->phone }}</div>
    </div>
    <div class="d-flex gap-2">
  <a href="{{ route('admin.patients.index') }}" 
     hx-get="{{ route('admin.patients.index') }}?partial=1"
     hx-target="#adminMainContent"
     hx-push-url="{{ route('admin.patients.index') }}"
     hx-swap="innerHTML transition:true"
     class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Danh sách</a>
  <a href="{{ route('admin.appointments.index', ['q' => $patient->phone]) }}" 
     hx-get="{{ route('admin.appointments.index', ['q' => $patient->phone]) }}?partial=1"
     hx-target="#adminMainContent"
     hx-push-url="{{ route('admin.appointments.index', ['q' => $patient->phone]) }}"
     hx-swap="innerHTML transition:true"
     class="btn btn-primary"><i class="bi bi-calendar"></i> Lịch hẹn</a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row g-3">
    <div class="col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Thông tin</h5>
          <ul class="list-unstyled small mb-0">
            <li><strong>Tên:</strong> {{ $patient->name }}</li>
            <li><strong>SĐT:</strong> {{ $patient->phone }}</li>
            <li><strong>Giới tính:</strong> {{ $patient->gender }}</li>
            <li><strong>Ngày sinh:</strong> {{ $patient->dob }}</li>
            <li><strong>Địa chỉ:</strong> {{ $patient->address }}</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <!-- Notes section removed as PatientNote model doesn't exist -->
      
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Lịch sử khám</h5>
          <div class="table-responsive">
            <table class="table">
              <thead class="table-light">
                <tr>
                  <th>Ngày</th>
                  <th>Dịch vụ</th>
                  <th>Bác sĩ</th>
                  <th>Trạng thái</th>
                  <th>Tiền</th>
                  <th>TT</th>
                </tr>
              </thead>
              <tbody>
                @forelse($patient->appointments as $a)
                  <tr>
                    <td class="text-nowrap">{{ $a->appointment_at?->format('d/m/Y H:i') }}</td>
                    <td>{{ $a->service->name }}</td>
                    <td>{{ $a->doctor?->name }}</td>
                    <td>{{ $a->status }}</td>
                    <td>{{ number_format($a->total_amount ?? 0,0,',','.') }} đ</td>
                    <td>@if($a->paid_at)<span class="badge bg-success">Đã TT</span>@else<span class="badge bg-warning text-dark">Chưa</span>@endif</td>
                  </tr>
                @empty
                  <tr><td colspan="6" class="text-center text-muted">Chưa có lịch hẹn</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
