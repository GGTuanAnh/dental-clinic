@extends('layouts.admin')
@section('title','Bác sĩ - Dashboard')
@section('page-title','Tổng quan bác sĩ')
@section('breadcrumbs')
  <x-breadcrumbs :items="[['label'=>'Dashboard bác sĩ']]" />
@endsection
@section('content')
<div class="row g-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-blue">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Hôm nay</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mApptToday">0</div>
          <i class="bi bi-calendar2-week fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-green">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Đã xác nhận</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mConfirmed">0</div>
          <i class="bi bi-check2-circle fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-orange">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Hoàn tất</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mCompleted">0</div>
          <i class="bi bi-clipboard2-check fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-pink">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Doanh thu (ước)</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mRevenue">0</div>
          <i class="bi bi-cash-stack fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-purple">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Tỉ lệ hoàn tất</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mCompletionRate">0%</div>
          <i class="bi bi-graph-up-arrow fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-cyan">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Doanh thu TB / lịch</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mAvgRevenue">0</div>
          <i class="bi bi-currency-exchange fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-teal">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Lead time TB (h)</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mLeadTime">0</div>
          <i class="bi bi-hourglass-split fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100 shadow-sm border-0 stat-card gradient-red" id="revenueDropCard" style="display:none">
      <div class="card-body py-3">
        <div class="small text-uppercase fw-semibold text-muted">Chênh lệch doanh thu</div>
        <div class="d-flex align-items-end justify-content-between">
          <div class="display-6 fw-bold" id="mRevenueDrop">0%</div>
          <i class="bi bi-arrow-down-circle fs-2 opacity-50"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 g-4">
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="mb-0">Lịch hẹn <span id="rangeLabel">7 ngày</span></h6>
          <select id="rangeSelect" class="form-select form-select-sm" style="width:auto">
            <option value="7">7 ngày</option>
            <option value="30">30 ngày</option>
            <option value="90">90 ngày</option>
          </select>
        </div>
        <canvas id="chartLineAppt" height="160"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <h6 class="mb-3">Trạng thái</h6>
        <canvas id="chartStatus" height="180"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <h6 class="mb-3">Doanh thu 7 ngày</h6>
        <canvas id="chartRevenue" height="180"></canvas>
      </div>
    </div>
  </div>
</div>

@push('head')
<style>
.stat-card{position:relative;overflow:hidden;color:#fff}
.stat-card .card-body{color:#fff}
.gradient-blue{background:linear-gradient(135deg,#2563eb,#1d4ed8);} 
.gradient-green{background:linear-gradient(135deg,#059669,#047857);} 
.gradient-orange{background:linear-gradient(135deg,#ea580c,#c2410c);} 
.gradient-pink{background:linear-gradient(135deg,#db2777,#be185d);} 
.gradient-purple{background:linear-gradient(135deg,#7e22ce,#6d28d9);} 
.gradient-cyan{background:linear-gradient(135deg,#0891b2,#0e7490);} 
.gradient-teal{background:linear-gradient(135deg,#0d9488,#0f766e);} 
.gradient-red{background:linear-gradient(135deg,#dc2626,#b91c1c);} 
.stat-card i{color:rgba(255,255,255,.55)}
/* Light theme overrides for stat cards - ensure readability */
[data-theme-mode='light'] .stat-card{color:#fff}
[data-theme-mode='light'] .stat-card .card-body{color:#fff}
[data-theme-mode='light'] .stat-card i{color:rgba(255,255,255,.55)}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
let lineChart,statusChart,revChart;
function loadDoctorDash(range=7){
  const base = document.body.getAttribute('data-doctor-endpoint');
  const url = base + '&range=' + range;
  fetch(url,{headers:{'Accept':'application/json'}}).then(r=>r.json()).then(d=>{
    document.getElementById('mApptToday').textContent=d.metrics.today||0;
    document.getElementById('mConfirmed').textContent=d.metrics.confirmed||0;
    document.getElementById('mCompleted').textContent=d.metrics.completed||0;
    document.getElementById('mRevenue').textContent=d.metrics.revenue||0;
  document.getElementById('rangeLabel').textContent = d.range + ' ngày';
    document.getElementById('mCompletionRate').textContent = (d.metrics.completion_rate||0) + '%';
    document.getElementById('mAvgRevenue').textContent = d.metrics.avg_revenue_per_appointment||0;
    document.getElementById('mLeadTime').textContent = d.metrics.avg_lead_time_hours||0;
    const drop = d.metrics.revenue_drop_percent||0;
    const dropCard = document.getElementById('revenueDropCard');
    document.getElementById('mRevenueDrop').textContent = drop + '%';
    // Show card only if drop < -20% (tùy chỉnh ngưỡng)
    if(drop < -20){
      dropCard.style.display='block';
    } else {
      dropCard.style.display='none';
    }
    // Destroy old charts if exist
    lineChart && lineChart.destroy();
    statusChart && statusChart.destroy();
    revChart && revChart.destroy();
    lineChart = new Chart(document.getElementById('chartLineAppt'),{type:'line',data:{labels:d.line.labels,datasets:[{label:'Lịch hẹn',data:d.line.counts,borderColor:'#60a5fa',backgroundColor:'rgba(96,165,250,.25)',tension:.35,fill:true}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});
    statusChart = new Chart(document.getElementById('chartStatus'),{type:'doughnut',data:{labels:Object.keys(d.status),datasets:[{data:Object.values(d.status),backgroundColor:['#1d4ed8','#059669','#ea580c','#6b7280']}]},options:{plugins:{legend:{position:'bottom'}}}});
    revChart = new Chart(document.getElementById('chartRevenue'),{type:'bar',data:{labels:d.revenue.labels,datasets:[{label:'Doanh thu',data:d.revenue.amounts,backgroundColor:'#fbbf24'}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});
  });
}
document.getElementById('rangeSelect').addEventListener('change',e=>loadDoctorDash(e.target.value));
loadDoctorDash(7);
</script>
@endpush
@endsection