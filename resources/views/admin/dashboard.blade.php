@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <x-breadcrumbs :items="[['label'=>'Dashboard']]" />
@endsection

@section('content')
<div class="row g-4">
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Appointments Today</h6>
                <div class="display-6 fw-bold">{{ $stats['appointments_today'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Pending Appointments</h6>
                <div class="display-6 fw-bold">{{ $stats['appointments_pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Patients</h6>
                <div class="display-6 fw-bold">{{ $stats['patients_total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Doctors</h6>
                <div class="display-6 fw-bold">{{ $stats['doctors_total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100 mt-4">
            <div class="card-body">
                <h6 class="text-muted">Services</h6>
                <div class="display-6 fw-bold">{{ $stats['services_total'] }}</div>
            </div>
        </div>
    </div>
</div>
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3 text-muted">Lịch hẹn 7 ngày gần nhất</h6>
                <canvas id="appointmentsChart" data-chart-url="{{ route('admin.home') }}?chart=1" height="140"></canvas>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
    const chartEl = document.getElementById('appointmentsChart');
    const chartUrl = chartEl.getAttribute('data-chart-url');
    fetch(chartUrl,{headers:{'Accept':'application/json'}})
     .then(r=>r.json())
     .then(data=>{
            if(!data.labels) return;
            new Chart(document.getElementById('appointmentsChart').getContext('2d'),{
                type:'line',
                data:{labels:data.labels,datasets:[{label:'Số lịch hẹn',data:data.counts, tension:.3, borderColor:'#3b82f6',backgroundColor:'rgba(59,130,246,.15)',fill:true}]},
                options:{
                    plugins:{legend:{display:false}},
                    scales:{y:{beginAtZero:true, ticks:{precision:0}}}
                }
            });
     });
    </script>
    @endpush
@endsection