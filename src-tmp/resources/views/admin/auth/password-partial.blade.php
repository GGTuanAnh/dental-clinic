<div data-page-title="Đổi mật khẩu">
<div class="container-fluid px-0 py-3">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h2 class="h4 mb-4">Đổi mật khẩu</h2>
          
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="post" action="{{ route('admin.password.update') }}">
            @csrf
            @method('put')
            
            <div class="mb-3">
              <label class="form-label">Mật khẩu hiện tại</label>
              <input type="password" name="current_password" class="form-control" required>
              @error('current_password')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Mật khẩu mới</label>
              <input type="password" name="password" class="form-control" required minlength="8">
            </div>

            <div class="mb-3">
              <label class="form-label">Xác nhận mật khẩu mới</label>
              <input type="password" name="password_confirmation" class="form-control" required minlength="8">
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Cập nhật</button>
              <a href="{{ route('admin.home') }}" 
                 hx-get="{{ route('admin.home') }}?partial=1"
                 hx-target="#adminMainContent"
                 hx-push-url="{{ route('admin.home') }}"
                 hx-swap="innerHTML transition:true"
                 class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Hủy</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
