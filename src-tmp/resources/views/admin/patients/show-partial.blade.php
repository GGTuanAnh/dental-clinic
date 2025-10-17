<div data-page-title="Chi tiết bệnh nhân: {{ $patient->name }}">
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
           class="btn btn-outline-secondary">
           <i class="bi bi-arrow-left"></i> Danh sách
        </a>
        <a href="{{ route('admin.appointments.index', ['q' => $patient->phone]) }}" 
           hx-get="{{ route('admin.appointments.index', ['q' => $patient->phone]) }}?partial=1"
           hx-target="#adminMainContent"
           hx-push-url="{{ route('admin.appointments.index', ['q' => $patient->phone]) }}"
           class="btn btn-primary">
           <i class="bi bi-calendar"></i> Lịch hẹn
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
      <div class="col-lg-4">
        <div class="card shadow-sm h-100">
          <div class="card-body text-center">
            <!-- Avatar Section -->
            <div class="mb-4">
              @if($patient->avatar)
                <img src="{{ $patient->avatar }}" 
                     alt="{{ $patient->name }}"
                     class="rounded-circle shadow-sm mb-3"
                     style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #f8f9fa;"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}&background=random&size=150'">
              @else
                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm mb-3"
                     style="width: 150px; height: 150px; font-size: 48px; font-weight: 600; border: 4px solid #f8f9fa;">
                  {{ strtoupper(mb_substr($patient->name, 0, 1)) }}
                </div>
              @endif
              <h4 class="mb-1">{{ $patient->name }}</h4>
              <p class="text-muted mb-0">
                <i class="bi bi-telephone"></i> {{ $patient->phone }}
              </p>
            </div>
            
            <!-- Info Section -->
            <div class="text-start">
              <h6 class="border-bottom pb-2 mb-3">Thông tin cá nhân</h6>
              <ul class="list-unstyled small mb-0">
              <li class="mb-2"><strong>Giới tính:</strong> 
                @if($patient->gender === 'male')
                  <span class="badge bg-info text-dark"><i class="bi bi-gender-male me-1"></i>Nam</span>
                @elseif($patient->gender === 'female') 
                  <span class="badge bg-danger"><i class="bi bi-gender-female me-1"></i>Nữ</span>
                @else
                  <span class="badge bg-secondary">Khác</span>
                @endif
              </li>
              <li class="mb-2"><strong>Ngày sinh:</strong> 
                {{ $patient->dob ? $patient->dob->format('d/m/Y') : 'Chưa cập nhật' }}
              </li>
              <li class="mb-2"><strong>Địa chỉ:</strong> {{ $patient->full_address }}</li>
              <li class="mb-2"><strong>Ngày tạo hồ sơ:</strong> {{ $patient->created_at->format('d/m/Y H:i') }}</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <!-- Patient notes section removed -->
        
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Lịch sử điều trị</h5>
            @if($patient->appointments->isNotEmpty())
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>Ngày hẹn</th>
                      <th>Dịch vụ</th>
                      <th>Bác sĩ</th>
                      <th>Trạng thái</th>
                      <th>Thành tiền</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($patient->appointments->sortByDesc('appointment_at') as $appointment)
                      <tr>
                        <td>{{ $appointment->appointment_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $appointment->service->name ?? 'Dịch vụ tổng quát' }}</td>
                        <td>{{ $appointment->doctor->name ?? 'BS. Nguyễn Văn Việt' }}</td>
                        <td>
                          @switch($appointment->status)
                            @case('pending')
                              <span class="badge bg-warning">Chờ xác nhận</span>
                              @break
                            @case('confirmed')
                              <span class="badge bg-info">Đã xác nhận</span>
                              @break
                            @case('completed')
                              <span class="badge bg-success">Hoàn thành</span>
                              @break
                            @case('cancelled')
                              <span class="badge bg-danger">Đã hủy</span>
                              @break
                            @default
                              <span class="badge bg-secondary">{{ $appointment->status }}</span>
                          @endswitch
                        </td>
                        <td>
                          @if($appointment->total_amount)
                            <span class="fw-semibold">{{ number_format($appointment->total_amount) }}đ</span>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              <div class="mt-3 p-3 bg-light rounded">
                <div class="row text-center">
                  <div class="col-md-3">
                    <div class="fw-semibold text-primary">{{ $patient->appointments->count() }}</div>
                    <div class="small text-muted">Tổng lượt khám</div>
                  </div>
                  <div class="col-md-3">
                    <div class="fw-semibold text-success">{{ $patient->completed_appointments_count }}</div>
                    <div class="small text-muted">Đã hoàn thành</div>
                  </div>
                  <div class="col-md-3">
                    <div class="fw-semibold text-info">{{ $patient->appointments->where('status', 'confirmed')->count() }}</div>
                    <div class="small text-muted">Đã xác nhận</div>
                  </div>
                  <div class="col-md-3">
                    <div class="fw-semibold text-warning">{{ $patient->appointments->where('status', 'pending')->count() }}</div>
                    <div class="small text-muted">Chờ xác nhận</div>
                  </div>
                </div>
              </div>
            @else
              <div class="text-center py-4">
                <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                <h5>Chưa có lịch hẹn</h5>
                <p class="text-muted mb-3">Bệnh nhân chưa có lịch sử điều trị nào.</p>
                <a href="{{ route('admin.appointments.index') }}" 
                   hx-get="{{ route('admin.appointments.index') }}?partial=1"
                   hx-target="#adminMainContent"
                   hx-push-url="{{ route('admin.appointments.index') }}"
                   class="btn btn-primary">
                   <i class="bi bi-plus-circle"></i> Đặt lịch hẹn
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>