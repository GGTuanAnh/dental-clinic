<div data-page-title="Dashboard">
    <div class="row g-4">
        <!-- Header với thông tin doctor -->
        <div class="col-12">
            <div class="alert alert-info border-info border-2">
                <h5 class="mb-1 text-dark">👨‍⚕️ {{ $stats['doctor_name'] ?? 'BS. Nguyễn Văn Việt' }}</h5>
                <p class="mb-0 text-dark-emphasis">Bác sĩ điều hành phòng khám - {{ $stats['appointments_assigned'] ?? 0 }} lịch hẹn được quản lý</p>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-primary border-2">
                <div class="card-body">
                    <h6 class="text-primary fw-semibold">Lịch hẹn hôm nay</h6>
                    <div class="display-6 fw-bold text-primary">{{ $stats['appointments_today'] ?? 0 }}</div>
                    <div class="small mt-2">
                        <a href="{{ route('admin.appointments.index', ['from' => now()->format('Y-m-d'), 'to' => now()->format('Y-m-d')]) }}" 
                           hx-get="{{ route('admin.appointments.index', ['from' => now()->format('Y-m-d'), 'to' => now()->format('Y-m-d')]) }}?partial=1"
                           hx-target="#adminMainContent"
                           hx-push-url="{{ route('admin.appointments.index', ['from' => now()->format('Y-m-d'), 'to' => now()->format('Y-m-d')]) }}"
                           class="text-primary text-decoration-none fw-semibold">
                           Xem chi tiết →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-warning border-2">
                <div class="card-body">
                    <h6 class="text-warning fw-semibold">Chờ xác nhận</h6>
                    <div class="display-6 fw-bold text-warning">{{ $stats['appointments_pending'] ?? 0 }}</div>
                    <div class="small mt-2">
                        <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" 
                           hx-get="{{ route('admin.appointments.index', ['status' => 'pending']) }}?partial=1"
                           hx-target="#adminMainContent"
                           hx-push-url="{{ route('admin.appointments.index', ['status' => 'pending']) }}"
                           class="text-warning text-decoration-none fw-semibold">
                           Xem chi tiết →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-success border-2">
                <div class="card-body">
                    <h6 class="text-success fw-semibold">Tổng bệnh nhân</h6>
                    <div class="display-6 fw-bold text-success">{{ $stats['patients_total'] ?? 0 }}</div>
                    <div class="small mt-2">
                        <a href="{{ route('admin.patients.index') }}" 
                           hx-get="{{ route('admin.patients.index') }}?partial=1"
                           hx-target="#adminMainContent"
                           hx-push-url="{{ route('admin.patients.index') }}"
                           class="text-success text-decoration-none fw-semibold">
                           Xem danh sách →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-info border-2">
                <div class="card-body">
                    <h6 class="text-info fw-semibold">Dịch vụ khả dụng</h6>
                    <div class="display-6 fw-bold text-info">{{ $stats['services_total'] ?? 5 }}</div>
                    <div class="small text-dark-emphasis mt-2">Chăm sóc răng miệng toàn diện</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Thao tác nhanh</h5>
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('admin.appointments.index') }}" 
                               hx-get="{{ route('admin.appointments.index') }}?partial=1"
                               hx-target="#adminMainContent"
                               hx-push-url="{{ route('admin.appointments.index') }}"
                               class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-calendar-plus fs-4 d-block mb-2"></i>
                                Quản lý lịch hẹn
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('admin.patients.index') }}" 
                               hx-get="{{ route('admin.patients.index') }}?partial=1"
                               hx-target="#adminMainContent"
                               hx-push-url="{{ route('admin.patients.index') }}"
                               class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-person-plus fs-4 d-block mb-2"></i>
                                Hồ sơ bệnh nhân
                            </a>
                        </div>
                        @if(auth()->user()?->can('view-reports'))
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('admin.reports.index') }}" 
                               hx-get="{{ route('admin.reports.index') }}?partial=1"
                               hx-target="#adminMainContent"
                               hx-push-url="{{ route('admin.reports.index') }}"
                               class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-graph-up fs-4 d-block mb-2"></i>
                                Báo cáo thống kê
                            </a>
                        </div>
                        @endif
                        @if(auth()->user()?->can('manage-images'))
                        <div class="col-md-6 col-lg-3">
                            <a href="{{ route('admin.images.index') }}" 
                               hx-get="{{ route('admin.images.index') }}?partial=1"
                               hx-target="#adminMainContent"
                               hx-push-url="{{ route('admin.images.index') }}"
                               class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-images fs-4 d-block mb-2"></i>
                                Thư viện hình ảnh
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Hoạt động gần đây</h5>
                    @if(isset($recentAppointments) && $recentAppointments->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Bệnh nhân</th>
                                        <th>Dịch vụ</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_at->format('d/m H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.patients.show', $appointment->patient_id) }}" 
                                               hx-get="{{ route('admin.patients.show', $appointment->patient_id) }}?partial=1"
                                               hx-target="#adminMainContent"
                                               hx-push-url="{{ route('admin.patients.show', $appointment->patient_id) }}"
                                               class="text-decoration-none">
                                               {{ $appointment->patient->name }}
                                            </a>
                                        </td>
                                        <td>{{ $appointment->service->name ?? 'Tổng quát' }}</td>
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
                                                @default
                                                    <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-event fs-1 text-secondary mb-3"></i>
                            <h5 class="text-dark">Không có hoạt động gần đây</h5>
                            <p class="text-secondary">Hôm nay chưa có lịch hẹn nào được thực hiện.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-dark">Thống kê tháng này</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-dark">Lịch hẹn hoàn thành</span>
                        <span class="fw-bold text-success fs-5">{{ $stats['appointments_completed'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-dark">Bệnh nhân mới</span>
                        <span class="fw-bold text-primary fs-5">{{ $stats['new_patients_this_month'] ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-dark">Doanh thu</span>
                        <span class="fw-bold text-info fs-5">{{ number_format($stats['total_revenue'] ?? 0) }}đ</span>
                    </div>
                    
                    <hr>
                    
                    @php
                        $completedCount = ($stats['appointments_completed'] ?? 0);
                        $totalCount = max(1, ($stats['appointments_total'] ?? 1));
                        $completedRate = $completedCount > 0 ? min(100, ($completedCount / $totalCount) * 100) : 0;
                        $rateFormatted = number_format($completedRate, 1);
                    @endphp
                    <div class="text-center">
                        <p class="text-dark small mb-2 fw-semibold">Hiệu suất điều trị</p>
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 data-progress="{{ $rateFormatted }}"
                                 aria-valuenow="{{ $rateFormatted }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100"></div>
                        </div>
                        <small class="text-dark fw-semibold">
                            {{ $rateFormatted }}% lịch hẹn hoàn thành
                        </small>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('[data-progress]').forEach(function(el) {
                                el.style.width = el.dataset.progress + '%';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>