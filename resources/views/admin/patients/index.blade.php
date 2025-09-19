@extends('layouts.admin')
@section('page-title','Bệnh nhân')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Bệnh nhân']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0">
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h2 class="h4 mb-0 fw-semibold">Bệnh nhân</h2>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-light"><i class="bi bi-calendar"></i> Lịch hẹn</a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="get" class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label">Tìm kiếm</label>
          <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Tên hoặc SĐT">
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Tìm</button>
        </div>
      </form>
    </div>
  </div>

  <div class="table-responsive mt-3 shadow-sm">
    <table class="table align-middle">
      <thead class="table-light">
        <tr>
          <th>Tên</th>
          <th>SĐT</th>
          <th>Giới tính</th>
          <th>Ngày sinh</th>
          <th>Địa chỉ</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($patients as $p)
        <tr>
          <td>{{ $p->name }}</td>
          <td>{{ $p->phone }}</td>
          <td>{{ $p->gender }}</td>
          <td>{{ $p->dob }}</td>
          <td class="text-truncate" style="max-width:280px">{{ $p->address }}</td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.patients.show',$p->id) }}"><i class="bi bi-person"></i></a>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-5">Không có dữ liệu</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $patients->links() }}</div>
</div>
@endsection
