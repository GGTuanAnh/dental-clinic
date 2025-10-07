<div data-page-title="Hồ sơ bệnh nhân">
  <div class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
      <h2 class="h4 mb-0 fw-semibold">Bệnh nhân</h2>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.appointments.index') }}" 
           hx-get="{{ route('admin.appointments.index') }}?partial=1"
           hx-target="#adminMainContent"
           hx-push-url="{{ route('admin.appointments.index') }}"
           class="btn btn-sm btn-outline-light">
           <i class="bi bi-calendar"></i> Lịch hẹn
        </a>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <form method="get" 
              hx-get="{{ route('admin.patients.index') }}"
              hx-target="#adminMainContent"
              hx-push-url="true"
              hx-include="[name='q']"
              class="row g-2 align-items-end">
          <input type="hidden" name="partial" value="1">
          <div class="col-md-4">
            <label class="form-label">Tìm kiếm</label>
            <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Tên hoặc SĐT"
                   hx-trigger="keyup delay:500ms changed">
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Tìm</button>
          </div>
        </form>
      </div>
    </div>

    @if($patients->isNotEmpty())
      <div class="card shadow-sm mt-3">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Tên bệnh nhân</th>
                  <th>Ngày sinh</th>
                  <th>Giới tính</th>
                  <th>Số điện thoại</th>
                  <th>Địa chỉ</th>
                  <th>Ngày tạo</th>
                  <th class="text-center">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @foreach($patients as $patient)
                  <tr>
                    <td class="fw-semibold">#{{ $patient->id }}</td>
                    <td>
                      <a href="{{ route('admin.patients.show', $patient->id) }}" 
                         hx-get="{{ route('admin.patients.show', $patient->id) }}?partial=1"
                         hx-target="#adminMainContent"
                         hx-push-url="{{ route('admin.patients.show', $patient->id) }}"
                         class="text-decoration-none fw-semibold">
                        {{ $patient->name }}
                      </a>
                    </td>
                    <td>{{ $patient->dob ? $patient->dob->format('d/m/Y') : '-' }}</td>
                    <td>
                      @if($patient->gender === 'male')
                        <span class="badge bg-primary">Nam</span>
                      @elseif($patient->gender === 'female') 
                        <span class="badge bg-pink">Nữ</span>
                      @else
                        <span class="badge bg-secondary">Khác</span>
                      @endif
                    </td>
                    <td>
                      @if($patient->phone)
                        <a href="tel:{{ $patient->phone }}" class="text-decoration-none">
                          {{ $patient->phone }}
                        </a>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>{{ $patient->full_address }}</td>
                    <td class="text-muted">{{ $patient->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                      <a href="{{ route('admin.patients.show', $patient->id) }}" 
                         hx-get="{{ route('admin.patients.show', $patient->id) }}?partial=1"
                         hx-target="#adminMainContent"
                         hx-push-url="{{ route('admin.patients.show', $patient->id) }}"
                         class="btn btn-sm btn-outline-primary" 
                         title="Xem chi tiết">
                        <i class="bi bi-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      @if($patients->hasPages())
        <div class="mt-4 d-flex justify-content-center">
          <div hx-target="#adminMainContent" hx-push-url="true">
            {{ $patients->withQueryString()->links() }}
          </div>
        </div>
      @endif
    @else
      <div class="card shadow-sm mt-3">
        <div class="card-body text-center py-5">
          <i class="bi bi-person-x fs-1 text-muted mb-3"></i>
          <h4>Không tìm thấy bệnh nhân</h4>
          <p class="text-muted mb-0">
            @if(request('q'))
              Không có bệnh nhân nào phù hợp với từ khóa "{{ request('q') }}"
            @else
              Chưa có bệnh nhân nào trong hệ thống
            @endif
          </p>
        </div>
      </div>
    @endif
  </div>
</div>