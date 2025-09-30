<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();
        $user = request()->user();

        // Since we have only one doctor/admin (BS. Nguyễn Văn Việt), always show unified dashboard
        $doctorId = 1; // Our single doctor ID
        
        if(request()->wantsJson() && request()->boolean('doctorDashboard')){
            $range = (int) request()->integer('range', 7);
            if(!in_array($range,[7,30,90])) $range = 7;
            // Bump cache version when payload structure changes
            $cacheKey = "doctor_dash:v2:{$doctorId}:{$range}";
            $payload = Cache::remember($cacheKey, 60, function() use ($doctorId,$range,$today){
                $metrics = [
                    'today' => Appointment::whereDate('appointment_at',$today)->where('doctor_id',$doctorId)->count(),
                    'confirmed' => Appointment::where('status','confirmed')->where('doctor_id',$doctorId)->count(),
                    'completed' => Appointment::where('status','completed')->where('doctor_id',$doctorId)->count(),
                    'revenue' => (float) Appointment::where('status','completed')->where('doctor_id',$doctorId)->sum('total_amount'),
                ];
                $metrics['completion_rate'] = $metrics['confirmed'] > 0
                    ? round(($metrics['completed'] / $metrics['confirmed']) * 100, 1)
                    : 0.0;
                // Avg revenue per appointment (completed only)
                $metrics['avg_revenue_per_appointment'] = $metrics['completed'] > 0
                    ? round($metrics['revenue'] / $metrics['completed'], 2)
                    : 0.00;
                // Average lead time (hours) between created_at and appointment_at for this range
                $leadQuery = Appointment::where('doctor_id',$doctorId)
                    ->whereBetween('appointment_at',[now()->subDays($range-1)->startOfDay(), now()->endOfDay()])
                    ->whereNotNull('appointment_at')
                    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, appointment_at)) as avg_hours')
                    ->value('avg_hours');
                $metrics['avg_lead_time_hours'] = $leadQuery ? round($leadQuery,1) : 0.0;
                $lineLabels=[];$lineCounts=[]; $revLabels=[]; $revAmounts=[];
                for($i=$range-1;$i>=0;$i--){
                    $d= now()->subDays($i)->startOfDay();
                    $label = $range>30 ? $d->format('d/m') : $d->format('d/m');
                    $lineLabels[]=$label;
                    $lineCounts[]= Appointment::whereBetween('appointment_at',[$d,$d->copy()->endOfDay()])->where('doctor_id',$doctorId)->count();
                    $revLabels[]=$label;
                    $revAmounts[]= (float) Appointment::whereBetween('appointment_at',[$d,$d->copy()->endOfDay()])->where('doctor_id',$doctorId)->sum('total_amount');
                }
                // Revenue drop alert logic (compare today vs avg previous 7 days excluding today)
                $todayRevenue = (float) Appointment::whereBetween('appointment_at',[$today,$today->copy()->endOfDay()])
                    ->where('status','completed')->where('doctor_id',$doctorId)->sum('total_amount');
                $prev7Start = now()->subDays(7)->startOfDay();
                $prev7End = now()->subDay()->endOfDay();
                $prev7Revenue = (float) Appointment::whereBetween('appointment_at',[$prev7Start,$prev7End])
                    ->where('status','completed')->where('doctor_id',$doctorId)->sum('total_amount');
                $avgPrev7PerDay = $prev7Revenue > 0 ? $prev7Revenue / 7 : 0;
                $metrics['revenue_drop_percent'] = $avgPrev7PerDay > 0
                    ? round((($todayRevenue - $avgPrev7PerDay)/$avgPrev7PerDay)*100,1)
                    : 0.0;
                $statusBreakdown = [
                    'pending' => Appointment::where('status','pending')->where('doctor_id',$doctorId)->count(),
                    'confirmed' => $metrics['confirmed'],
                    'completed' => $metrics['completed'],
                    'cancelled' => Appointment::where('status','cancelled')->where('doctor_id',$doctorId)->count(),
                ];
                return [
                    'metrics'=>$metrics,
                    'line'=>['labels'=>$lineLabels,'counts'=>$lineCounts],
                    'status'=>$statusBreakdown,
                    'revenue'=>['labels'=>$revLabels,'amounts'=>$revAmounts],
                    'range'=>$range,
                ];
            });
            return response()->json($payload);
        }
        
        // General stats for admin overview
        $stats = [
            'appointments_today' => Appointment::whereDate('created_at', $today)->count(),
            'appointments_pending' => Appointment::where('status','pending')->count(),
            'patients_total' => Patient::count(),
            'doctors_total' => Doctor::count(),
            'services_total' => Service::count(),
            // Show unified doctor stats
            'doctor_name' => 'BS. Nguyễn Văn Việt',
            'appointments_assigned' => Appointment::where('doctor_id', 1)->count(),
        ];
        
        // Always show unified admin/doctor dashboard since we have only one person
        return view('admin.dashboard', compact('stats'));
    }
}