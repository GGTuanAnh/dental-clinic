<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportAdminController extends BaseAdminController
{
    public function index(Request $request)
    {
        $from = $request->string('from')->toString();
        $to = $request->string('to')->toString();

        // Revenue: sum of total_amount where paid_at within range
        $revQuery = Appointment::query()->whereNotNull('paid_at');
        if ($from) $revQuery->whereDate('paid_at', '>=', $from);
        if ($to) $revQuery->whereDate('paid_at', '<=', $to);
        $revenue = (float)$revQuery->sum('total_amount');

        // Completed count in appointment date range
        $completedQuery = Appointment::query()->where('status','completed');
        if ($from) $completedQuery->whereDate('appointment_at','>=',$from);
        if ($to) $completedQuery->whereDate('appointment_at','<=',$to);
        $completedCount = (int)$completedQuery->count();

        // Total appointments in appointment date range
        $apptQuery = Appointment::query();
        if ($from) $apptQuery->whereDate('appointment_at','>=',$from);
        if ($to) $apptQuery->whereDate('appointment_at','<=',$to);
        $appointmentsCount = (int)$apptQuery->count();

        // Service breakdown by paid revenue
        $breakdownQuery = Appointment::query()
            ->selectRaw('service_id, COUNT(*) as cnt, COALESCE(SUM(total_amount),0) as sum')
            ->whereNotNull('paid_at');
        if ($from) $breakdownQuery->whereDate('paid_at','>=',$from);
        if ($to) $breakdownQuery->whereDate('paid_at','<=',$to);
        $breakdown = $breakdownQuery->groupBy('service_id')->with('service')->orderByDesc('sum')->limit(10)->get();

        if ($request->boolean('export')) {
            return $this->exportCsv($from, $to);
        }

    return $this->renderView('admin.reports.index', compact('revenue','completedCount','appointmentsCount','breakdown','from','to'), 'Báo cáo');
    }

    protected function exportCsv(?string $from, ?string $to): StreamedResponse
    {
        $filename = 'appointments_paid.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function() use ($from, $to) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['ID','Ngày khám','Bệnh nhân','Dịch vụ','Bác sĩ','Trạng thái','Tổng tiền','Đã TT lúc','Tái khám']);
            $q = Appointment::with(['patient','service','doctor'])->whereNotNull('paid_at');
            if ($from) $q->whereDate('paid_at','>=',$from);
            if ($to) $q->whereDate('paid_at','<=',$to);
            $q->orderBy('paid_at');
            $q->chunk(200, function($rows) use ($out){
                foreach($rows as $a){
                    fputcsv($out, [
                        $a->id,
                        optional($a->appointment_at)->format('Y-m-d H:i'),
                        optional($a->patient)->name,
                        optional($a->service)->name,
                        optional($a->doctor)->name,
                        $a->status,
                        $a->total_amount,
                        optional($a->paid_at)->format('Y-m-d H:i'),
                        optional($a->follow_up_at)->format('Y-m-d'),
                    ]);
                }
            });
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
