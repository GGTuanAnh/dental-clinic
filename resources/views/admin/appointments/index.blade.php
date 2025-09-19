@extends('layouts.admin')
@section('page-title','Lịch hẹn')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Lịch hẹn']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0">
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h2 class="h4 mb-0 fw-semibold">Quản lý lịch hẹn</h2>
    <div class="d-flex gap-2">
      <a href="/" class="btn btn-sm btn-outline-light"><i class="bi bi-house"></i> Site</a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form method="get" class="row g-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label">Tìm bệnh nhân</label>
          <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Tên hoặc SĐT">
        </div>
        <div class="col-md-2">
          <label class="form-label">Trạng thái</label>
          <select name="status" class="form-select">
            <option value="">Tất cả</option>
            @foreach(['pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','completed'=>'Hoàn tất','cancelled'=>'Đã hủy'] as $k=>$v)
              <option value="{{ $k }}" @selected(request('status')===$k)>{{ $v }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Bác sĩ</label>
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
          <label class="form-label">Từ</label>
          <input type="date" name="from" value="{{ request('from') }}" class="form-control">
        </div>
        <div class="col-md-1">
          <label class="form-label">Đến</label>
          <input type="date" name="to" value="{{ request('to') }}" class="form-control">
        </div>
        <div class="col-md-1">
          <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i></button>
        </div>
      </form>
    </div>
  </div>

  <div class="table-responsive shadow-sm">
    <table class="table align-middle">
      <thead class="table-light">
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
          <td class="text-nowrap">
            {{ $a->appointment_at?->format('d/m/Y H:i') }}
          </td>
          <td>
            <div class="fw-semibold">{{ $a->patient->name }}</div>
            <div class="text-muted small">{{ $a->patient->phone }}</div>
          </td>
          <td>{{ $a->service->name }}</td>
          <td>{{ $a->doctor?->name ?? '-' }}</td>
          <td>
            @php
              $badges=['pending'=>'secondary','confirmed'=>'primary','completed'=>'success','cancelled'=>'danger'];
            @endphp
            <span class="badge bg-{{ $badges[$a->status] ?? 'secondary' }}">{{ $a->status }}</span>
          </td>
          <td>
            <div>{{ number_format($a->total_amount ?? 0,0,',','.') }} đ</div>
          </td>
          <td>
            @if($a->paid_at)
              <span class="badge bg-success">Đã TT</span>
              <div class="small text-muted">{{ $a->paid_at->format('d/m H:i') }}</div>
            @else
              <span class="badge bg-warning text-dark">Chưa TT</span>
            @endif
          </td>
          <td class="text-nowrap">{{ $a->follow_up_at?->format('d/m/Y') ?? '-' }}</td>
          <td class="small" style="max-width:240px">{{ \Illuminate\Support\Str::limit($a->note, 80) }}</td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-{{ $a->id }}">
              <i class="bi bi-pencil"></i>
            </button>
          </td>
        </tr>
        <tr class="collapse" id="edit-{{ $a->id }}">
          <td colspan="10">
            <form method="post" action="{{ route('admin.appointments.update', $a->id) }}" class="border rounded p-3 bg-light">
              @csrf
              <div class="row g-2">
                <div class="col-md-2">
                  <label class="form-label">Trạng thái</label>
                  <select name="status" class="form-select form-select-sm">
                    @foreach(['pending','confirmed','completed','cancelled'] as $st)
                      <option value="{{ $st }}" @selected($a->status===$st)>{{ $st }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Bác sĩ</label>
                  <select name="doctor_id" class="form-select form-select-sm">
                    <option value="">-- Chưa chọn --</option>
                    @foreach($doctors as $d)
                      <option value="{{ $d->id }}" @selected($a->doctor_id==$d->id)>{{ $d->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Tổng tiền (đ)</label>
                  <input type="number" min="0" name="total_amount" value="{{ $a->total_amount }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                  <label class="form-label">Thanh toán</label>
                  <select name="paid" class="form-select form-select-sm">
                    <option value="0" @selected(!$a->paid_at)>Chưa</option>
                    <option value="1" @selected(!!$a->paid_at)>Đã thanh toán</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Tái khám</label>
                  <input type="date" name="follow_up_at" value="{{ $a->follow_up_at?->format('Y-m-d') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-12">
                  <label class="form-label">Ghi chú</label>
                  <textarea name="note" rows="2" class="form-control">{{ $a->note }}</textarea>
                </div>
                <div class="col-md-12 text-end">
                  <button class="btn btn-sm btn-primary"><i class="bi bi-save"></i> Lưu</button>
                </div>
              </div>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="10" class="text-center text-muted py-5">Không có lịch hẹn</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $appointments->links() }}
  </div>
</div>
@endsection
