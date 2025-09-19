@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <x-breadcrumbs :items="[['label'=>'Dashboard']]" />
@endsection

@section('page-description')
    Bảng điều khiển tổng quan giúp theo dõi lịch hẹn, bệnh nhân và hiệu suất phòng khám.
@endsection

@section('content')
@php
    $todayCount = $stats['appointments_today'] ?? 0;
    $pendingCount = $stats['appointments_pending'] ?? 0;
    $patientsTotal = $stats['patients_total'] ?? 0;
    $doctorsTotal = $stats['doctors_total'] ?? 0;
    $servicesTotal = $stats['services_total'] ?? 0;
    $pendingRate = $todayCount > 0 ? min(100, round(($pendingCount / max($todayCount,1)) * 100)) : null;
@endphp
<div class="stat-grid">
    <div class="stat-card" data-variant="blue">
        <div class="stat-icon"><i class="bi bi-calendar2-check"></i></div>
        <div class="stat-content">
            <div class="stat-label">Lịch hẹn hôm nay</div>
            <div class="stat-value">{{ $todayCount }}</div>
            <div class="stat-note">Giữ lịch trình trong tầm kiểm soát và hạn chế bỏ sót bệnh nhân.</div>
        </div>
    </div>
    <div class="stat-card" data-variant="amber">
        <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-content">
            <div class="stat-label">Đang chờ xử lý</div>
            <div class="stat-value">{{ $pendingCount }}</div>
            <div class="stat-note">
                {{ $pendingRate !== null ? '≈ '.$pendingRate.'% lịch hôm nay' : 'Theo dõi và xác nhận sớm các lịch hẹn mới.' }}
            </div>
        </div>
    </div>
    <div class="stat-card" data-variant="teal">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div class="stat-content">
            <div class="stat-label">Hồ sơ bệnh nhân</div>
            <div class="stat-value">{{ $patientsTotal }}</div>
            <div class="stat-note">Tập trung hồ sơ và lịch sử điều trị để tư vấn nhanh chóng.</div>
        </div>
    </div>
    <div class="stat-card" data-variant="violet">
        <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
        <div class="stat-content">
            <div class="stat-label">Bác sĩ phụ trách</div>
            <div class="stat-value">{{ $doctorsTotal }}</div>
            <div class="stat-note">Phân bổ nhân sự hợp lý giúp tối ưu trải nghiệm bệnh nhân.</div>
        </div>
    </div>
    <div class="stat-card" data-variant="slate">
        <div class="stat-icon"><i class="bi bi-bag-heart"></i></div>
        <div class="stat-content">
            <div class="stat-label">Dịch vụ hiện có</div>
            <div class="stat-value">{{ $servicesTotal }}</div>
            <div class="stat-note">Danh mục dịch vụ đa dạng cho từng nhu cầu điều trị.</div>
        </div>
    </div>
</div>

<div class="card quick-actions-card">
    <div class="card-body">
        <div class="intro">
            <h6>Thao tác nhanh</h6>
            <p>Đi thẳng tới các công việc thường dùng để bác sĩ và điều phối xử lý tức thì.</p>
        </div>
        <div class="quick-actions-list">
            <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="quick-action">
                <i class="bi bi-clipboard2-pulse"></i>
                <strong>Lịch chờ xác nhận</strong>
                <span>Xem chi tiết các ca chưa được duyệt.</span>
            </a>
            <a href="{{ route('admin.appointments.index', ['from' => now()->toDateString(), 'to' => now()->toDateString()]) }}" class="quick-action">
                <i class="bi bi-calendar-day"></i>
                <strong>Lịch khám hôm nay</strong>
                <span>Kiểm tra các khung giờ đang diễn ra.</span>
            </a>
            <a href="{{ route('admin.patients.index') }}" class="quick-action">
                <i class="bi bi-person-lines-fill"></i>
                <strong>Danh sách bệnh nhân</strong>
                <span>Truy cập hồ sơ và ghi chú điều trị.</span>
            </a>
            @can('view-reports')
            <a href="{{ route('admin.reports.index') }}" class="quick-action">
                <i class="bi bi-graph-up-arrow"></i>
                <strong>Xem báo cáo</strong>
                <span>Theo dõi doanh thu và hiệu suất dịch vụ.</span>
            </a>
            @endcan
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card analytics-card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span>Lịch hẹn 7 ngày gần nhất</span>
                <span class="text-muted small">Cập nhật theo thời gian thực</span>
            </div>
            <div class="card-body">
                <canvas id="appointmentsChart" data-chart-url="{{ route('admin.home') }}?chart=1" height="150"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header">Ghi chú vận hành</div>
            <div class="card-body d-flex flex-column gap-3">
                <div class="d-flex gap-3 align-items-center">
                    <div class="stat-icon" style="--stat-accent:#38bdf8;--stat-accent-soft:rgba(56,189,248,0.25);width:2.6rem;height:2.6rem;font-size:1.2rem;"><i class="bi bi-bell"></i></div>
                    <div>
                        <div class="fw-semibold">Ưu tiên phản hồi lịch chờ</div>
                        <div class="text-muted small">Giúp bệnh nhân nhận thông tin kịp thời và tăng tỉ lệ đến khám.</div>
                    </div>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <div class="stat-icon" style="--stat-accent:#a855f7;--stat-accent-soft:rgba(168,85,247,0.25);width:2.6rem;height:2.6rem;font-size:1.2rem;"><i class="bi bi-chat-dots"></i></div>
                    <div>
                        <div class="fw-semibold">Cập nhật ghi chú điều trị</div>
                        <div class="text-muted small">Đảm bảo thông tin giữa các bác sĩ được liên thông và rõ ràng.</div>
                    </div>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <div class="stat-icon" style="--stat-accent:#22c55e;--stat-accent-soft:rgba(34,197,94,0.25);width:2.6rem;height:2.6rem;font-size:1.2rem;"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="fw-semibold">Theo dõi tiến độ thanh toán</div>
                        <div class="text-muted small">Đối soát nhanh các ca đã hoàn tất để tối ưu dòng tiền.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  const chartEl = document.getElementById('appointmentsChart');
  if(chartEl){
    const chartUrl = chartEl.getAttribute('data-chart-url');
    fetch(chartUrl,{headers:{'Accept':'application/json'}})
      .then(r=>r.json())
      .then(data=>{
        if(!data.labels) return;
        const ctx = chartEl.getContext('2d');
        new Chart(ctx,{
          type:'line',
          data:{
            labels:data.labels,
            datasets:[{
              label:'Số lịch hẹn',
              data:data.counts,
              tension:.35,
              borderColor:'#60a5fa',
              borderWidth:2.5,
              pointRadius:3.5,
              pointBackgroundColor:'#2563eb',
              backgroundColor:'rgba(96,165,250,0.2)',
              fill:true
            }]
          },
          options:{
            plugins:{
              legend:{display:false},
              tooltip:{
                backgroundColor:'rgba(15,23,42,0.92)',
                padding:12,
                cornerRadius:12,
                titleFont:{weight:'600'},
                bodyFont:{weight:'500'}
              }
            },
            scales:{
              y:{
                beginAtZero:true,
                ticks:{precision:0,color:'#94a3b8'},
                grid:{color:'rgba(148,163,184,0.15)',drawBorder:false}
              },
              x:{
                ticks:{color:'#94a3b8'},
                grid:{display:false,drawBorder:false}
              }
            }
          }
        });
      });
  }
</script>
@endpush
@endsection