@extends('layouts.admin_auth')

@section('title','Đăng nhập')
@section('content')
<div class="auth-card">
  <h1 class="h4 mb-3 fw-semibold text-center">Đăng nhập quản trị</h1>
  @if($errors->any())
    <div class="alert alert-danger py-2 small mb-3">{{ $errors->first() }}</div>
  @endif
  <form method="post" action="{{ route('admin.login.post') }}" class="vstack gap-3">
    @csrf
    <div>
      <label class="form-label small mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
    </div>
    <div>
      <label class="form-label small mb-1">Mật khẩu</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
      <label class="form-check-label small" for="remember">Ghi nhớ đăng nhập</label>
    </div>
    <button class="btn btn-primary w-100 py-2"><i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập</button>
  </form>
</div>
@endsection
