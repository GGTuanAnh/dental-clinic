@extends('layouts.admin')
@section('page-title','Báo cáo')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Báo cáo']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0">Báo cáo</h1>
    <div class="d-flex gap-2">
      <a href="/admin/appointments" class="btn btn-outline-secondary"><i class="bi bi-calendar"></i> Lịch hẹn</a>
      <a href="/admin/patients" class="btn btn-outline-secondary"><i class="bi bi-people"></i> Bệnh nhân</a>
    </div>
  </div>

  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <form method="get" class="row g-2 align-items-end">
        <div class="col-md-2">
          <label class="form-label">Từ ngày</label>
          <input type="date" name="from" value="{{ $from }}" class="form-control">
        </div>
        <div class="col-md-2">
          <label class="form-label">Đến ngày</label>
          <input type="date" name="to" value="{{ $to }}" class="form-control">
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Lọc</button>
        </div>
        <div class="col-md-2 ms-auto text-end">
          <a class="btn btn-success w-100" href="{{ route('admin.reports.index', array_filter(['from'=>$from,'to'=>$to,'export'=>1])) }}"><i class="bi bi-filetype-csv"></i> Xuất CSV</a>
        </div>
      </form>
    </div>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <div class="text-muted small">Doanh thu (đã thanh toán)</div>
          <div class="display-6 fw-bold text-success">{{ number_format($revenue,0,',','.') }} đ</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <div class="text-muted small">Lịch hẹn hoàn tất</div>
          <div class="display-6 fw-bold">{{ $completedCount }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <div class="text-muted small">Tổng lịch hẹn</div>
          <div class="display-6 fw-bold">{{ $appointmentsCount }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Top dịch vụ theo doanh thu</h5>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Dịch vụ</th>
              <th class="text-end">Số ca</th>
              <th class="text-end">Doanh thu</th>
            </tr>
          </thead>
          <tbody>
            @forelse($breakdown as $b)
              <tr>
                <td>{{ optional($b->service)->name ?? 'N/A' }}</td>
                <td class="text-end">{{ $b->cnt }}</td>
                <td class="text-end">{{ number_format($b->sum,0,',','.') }} đ</td>
              </tr>
            @empty
              <tr><td colspan="3" class="text-center text-muted py-4">Không có dữ liệu</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
