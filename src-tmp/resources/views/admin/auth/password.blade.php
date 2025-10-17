@extends('layouts.admin')
@section('title','Đổi mật khẩu')
@section('page-title','Đổi mật khẩu')
@section('breadcrumbs')
  <x-breadcrumbs :items="[['label'=>'Đổi mật khẩu']]" />
@endsection
@section('content')
<div class="row">
  <div class="col-md-6 col-lg-5 col-xl-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3">Đổi mật khẩu</h5>
        @if(session('status'))
          <div class="alert alert-success py-2">{{ session('status') }}</div>
        @endif
        <form method="post" action="{{ route('admin.password.update') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Mật khẩu mới</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Nhập lại mật khẩu mới</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Cập nhật</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection