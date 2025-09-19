@extends('layouts.admin')
@section('page-title','Lịch hẹn')
@section('page-description')
  Điều phối lịch khám, cập nhật ghi chú và trạng thái thanh toán cho từng ca điều trị.
@endsection
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Lịch hẹn']
  ]" />
@endsection
@section('content')
@php
  $collection = $appointments->getCollection();
  $pagePending = $collection->where('status','pending')->count();
  $pageCompleted = $collection->where('status','completed')->count();
  $statusLabels = ['pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','completed'=>'Hoàn tất','cancelled'=>'Đã hủy'];
  $hasFilters = collect(['q','status','doctor_id','service_id','from','to'])->contains(function($key){
    return filled(request($key));
  });
@endphp

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card summary-card mb-4">
  <div class="card-body">
    <div class="summary-strip">
      <div class="summary-pill">
        <span class="label">Tổng lịch hẹn</span>
        <span class="value">{{ $appointments->total() }}</span>
        <span class="note">Bao gồm tất cả kết quả theo bộ lọc hiện tại.</span>
      </div>
      <div class="summary-pill page-count">
        <span class="label">Đang hiển thị</span>
        <span class="value">{{ $appointments->count() }}</span>
        <span class="note">Trang {{ $appointments->currentPage() }} / {{ $appointments->lastPage() }}</span>
      </div>
      <div class="summary-pill pending">
        <span class="label">Chờ xác nhận</span>
        <span class="value">{{ $pagePending }}</span>
        <span class="note">Hoàn tất trong trang: {{ $pageCompleted }}</span>
      </div>
    </div>
    <div class="d-flex flex-column align-items-end gap-1 text-muted small ms-auto">
      <div>Hiển thị từ #{{ $appointments->firstItem() ?? 0 }} đến #{{ $appointments->lastItem() ?? 0 }}</div>
      @if($hasFilters)
        <div class="text-info"><i class="bi bi-funnel me-1"></i>Bộ lọc đang áp dụng</div>
      @endif
    </div>
  </div>
</div>

<div class="card filter-card mb-4">
  <div class="card-body">
    <form method="get" class="row g-3 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Tìm kiếm</label>
        <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Tên bệnh nhân hoặc số điện thoại">
      </div>
      <div class="col-md-2">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
          <option value="">Tất cả</option>
          @foreach($statusLabels as $key => $label)
            <option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Bác sĩ phụ trách</label>
        <select name="doctor_id" class="form-select">
          <option value="">Tất cả</option>
          @foreach($doctors as $d)
            <option value="{{ $d->id }}" @selected(request('doctor_id')==$d->id)>{{ $d->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Dịch vụ</label>
        <select name="service_id" class="form-select">
          <option value="">Tất cả</option>
          @foreach($services as $s)
            <option value="{{ $s->id }}" @selected(request('service_id')==$s->id)>{{ $s->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-1">
        <label class="form-label">Từ ngày</label>
        <input type="date" name="from" value="{{ request('from') }}" class="form-control">
      </div>
      <div class="col-md-1">
        <label class="form-label">Đến ngày</label>
        <input type="date" name="to" value="{{ request('to') }}" class="form-control">
      </div>
      <div class="col-md-12 d-flex justify-content-end gap-2">
        @if($hasFilters)
          <a href="{{ route('admin.appointments.index') }}" class="btn btn-ghost"><i class="bi bi-x-circle"></i><span class="d-none d-sm-inline ms-1">Bỏ lọc</span></a>
        @endif
        <button class="btn btn-primary px-4"><i class="bi bi-funnel me-1"></i>Lọc kết quả</button>
      </div>
    </form>
  </div>
</div>

<div class="table-responsive">
  <table class="table align-middle">
    <thead>
      <tr>
        <th>Thời gian</th>
        <th>Bệnh nhân</th>
        <th>Dịch vụ</th>
        <th>Bác sĩ</th>
        <th>Trạng thái</th>
        <th>Tiền</th>
        <th>Thanh toán</th>
        <th>Hẹn tái khám</th>
        <th>Ghi chú</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($appointments as $a)
      <tr>
        <td class="text-nowrap fw-semibold">{{ $a->appointment_at?->format('d/m/Y H:i') }}</td>
        <td>
          <div class="fw-semibold">{{ $a->patient->name }}</div>
          <div class="text-muted small">{{ $a->patient->phone }}</div>
        </td>
        <td>{{ $a->service->name }}</td>
        <td>{{ $a->doctor?->name ?? '-' }}</td>
        <td><span class="status-chip {{ $a->status }}">{{ $statusLabels[$a->status] ?? $a->status }}</span></td>
        <td>
          <div class="fw-semibold">{{ number_format($a->total_amount ?? 0,0,',','.') }} đ</div>
        </td>
        <td>
          @if($a->paid_at)
            <span class="badge bg-success">Đã TT</span>
            <div class="small text-muted">{{ $a->paid_at->format('d/m H:i') }}</div>
          @else
            <span class="badge bg-warning">Chưa TT</span>
          @endif
        </td>
        <td class="text-nowrap">{{ $a->follow_up_at?->format('d/m/Y') ?? '-' }}</td>
        <td class="small note-truncate">{{ \Illuminate\Support\Str::of($a->note)->trim() }}</td>
        <td class="text-end">
          <button class="btn btn-ghost" data-bs-toggle="collapse" data-bs-target="#edit-{{ $a->id }}" aria-expanded="false" aria-controls="edit-{{ $a->id }}">
            <i class="bi bi-pencil"></i>
          </button>
        </td>
      </tr>
      <tr class="collapse" id="edit-{{ $a->id }}">
        <td colspan="10">
          <form method="post" action="{{ route('admin.appointments.update', $a->id) }}" class="inline-editor">
            @csrf
            <div class="row g-3">
              <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                  @foreach(array_keys($statusLabels) as $st)
                    <option value="{{ $st }}" @selected($a->status===$st)>{{ $statusLabels[$st] ?? $st }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Bác sĩ</label>
                <select name="doctor_id" class="form-select">
                  <option value="">-- Chưa chọn --</option>
                  @foreach($doctors as $d)
                    <option value="{{ $d->id }}" @selected($a->doctor_id==$d->id)>{{ $d->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Tổng tiền (đ)</label>
                <input type="number" min="0" name="total_amount" value="{{ $a->total_amount }}" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label">Thanh toán</label>
                <select name="paid" class="form-select">
                  <option value="0" @selected(!$a->paid_at)>Chưa</option>
                  <option value="1" @selected(!!$a->paid_at)>Đã thanh toán</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Tái khám</label>
                <input type="date" name="follow_up_at" value="{{ $a->follow_up_at?->format('Y-m-d') }}" class="form-control">
              </div>
              <div class="col-md-9">
                <label class="form-label">Ghi chú</label>
                <textarea name="note" rows="2" class="form-control">{{ $a->note }}</textarea>
              </div>
              <div class="col-12 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-ghost" data-bs-toggle="collapse" data-bs-target="#edit-{{ $a->id }}"><i class="bi bi-x-lg"></i><span class="d-none d-sm-inline ms-1">Đóng</span></button>
                <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Cập nhật</button>
              </div>
            </div>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="10" class="text-center text-muted py-5">Không có lịch hẹn phù hợp.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-3">
  {{ $appointments->links() }}
</div>
@endsection
