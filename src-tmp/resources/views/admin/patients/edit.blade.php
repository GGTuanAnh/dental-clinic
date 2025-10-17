@extends('layouts.admin')
@section('page-title','Chỉnh sửa bệnh nhân')
@section('breadcrumbs')
  <x-breadcrumbs :items="[
    ['label'=>'Dashboard','url'=>route('admin.home'),'icon'=>'speedometer2'],
    ['label'=>'Bệnh nhân','url'=>route('admin.patients.index')],
    ['label'=>'Chỉnh sửa']
  ]" />
@endsection
@section('content')
<div class="container-fluid px-0">
  <div class="mb-4 d-flex justify-content-between align-items-center">
    <h1 class="h4">Chỉnh sửa bệnh nhân</h1>
    <a href="{{ route('admin.patients.show', $patient->id) }}" class="btn btn-outline-secondary">Quay lại</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.patients.update', $patient->id) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
          <label class="form-label">Tên</label>
          <input name="name" value="{{ old('name', $patient->name) }}" class="form-control" required />
          @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">SĐT</label>
            <input name="phone" value="{{ old('phone', $patient->phone) }}" class="form-control" />
            @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-select">
              <option value="">--</option>
              <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Nam</option>
              <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
            </select>
            @error('gender')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="dob" value="{{ old('dob', $patient->dob?->format('Y-m-d')) }}" class="form-control" />
            @error('dob')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3 mt-3">
          <label class="form-label">Địa chỉ</label>
          <textarea name="address" class="form-control" rows="3">{{ old('address', $patient->address) }}</textarea>
          @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end">
          <button class="btn btn-primary">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
