<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $services = Service::all();
        $doctors = Doctor::all();

        if ($patients->isEmpty() || $services->isEmpty()) {
            $this->command->warn('⚠️ Cần chạy PatientsSeeder và ServicesSeeder trước!');
            return;
        }

        $timeSlots = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'];
        
        $appointments = [];

        // Tạo lịch hẹn từ đầu năm 2025 đến giờ (01/01/2025 -> hôm nay)
        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::now();
        $totalDays = $startDate->diffInDays($endDate);

        $this->command->info("📅 Tạo dữ liệu từ {$startDate->format('d/m/Y')} đến {$endDate->format('d/m/Y')} ({$totalDays} ngày)");

        for ($i = 0; $i <= $totalDays; $i++) {
            $date = $startDate->copy()->addDays($i);
            
            // Bỏ qua chủ nhật
            if ($date->dayOfWeek === Carbon::SUNDAY) {
                continue;
            }

            // Mỗi ngày tạo 4-8 lịch hẹn ngẫu nhiên (nhiều hơn để có dữ liệu đủ)
            $appointmentsPerDay = rand(4, 8);
            
            for ($j = 0; $j < $appointmentsPerDay; $j++) {
                $patient = $patients->random();
                $service = $services->random();
                $doctor = $doctors->isNotEmpty() ? $doctors->random() : null;
                
                // Tạo timestamp từ date và time
                $timeSlot = $timeSlots[array_rand($timeSlots)];
                $appointmentAt = Carbon::parse($date->format('Y-m-d') . ' ' . $timeSlot);
                
                // Thời điểm tạo lịch: 1-5 ngày trước ngày hẹn
                $createdAt = $appointmentAt->copy()->subDays(rand(1, 5));
                
                // Logic xác định status:
                // 1. Nếu đã quá 1 ngày kể từ khi tạo mà chưa xác nhận -> cancelled
                // 2. Nếu đã qua ngày hẹn -> completed (80%) hoặc cancelled (20%)
                // 3. Nếu chưa tới ngày hẹn -> confirmed (70%) hoặc scheduled (30%)
                
                $now = Carbon::now();
                $daysSinceCreated = $createdAt->diffInDays($now);
                $isPastAppointment = $appointmentAt->isPast();
                
                if ($isPastAppointment) {
                    // Đã qua ngày hẹn
                    $rand = rand(1, 100);
                    if ($rand <= 75) {
                        $status = 'completed'; // 75% hoàn thành
                    } else {
                        $status = 'cancelled'; // 25% bị hủy
                    }
                } else {
                    // Chưa tới ngày hẹn
                    if ($daysSinceCreated >= 1 && rand(1, 100) <= 20) {
                        // 20% các lịch sau 1 ngày không xác nhận -> hủy
                        $status = 'cancelled';
                    } else {
                        // 80% còn lại
                        $rand = rand(1, 100);
                        if ($rand <= 70) {
                            $status = 'confirmed'; // 70% đã xác nhận
                        } else {
                            $status = 'scheduled'; // 30% chờ xác nhận
                        }
                    }
                }

                $appointment = [
                    'patient_id' => $patient->id,
                    'service_id' => $service->id,
                    'doctor_id' => $doctor?->id,
                    'appointment_at' => $appointmentAt,
                    'status' => $status,
                    'note' => $this->generateNotes($status),
                    'total_amount' => $service->price ?? rand(200000, 2000000),
                    'created_at' => $createdAt,
                    'updated_at' => $status === 'scheduled' ? $createdAt : $createdAt->copy()->addHours(rand(2, 24)),
                ];

                // Thêm thông tin thanh toán cho lịch đã hoàn thành
                if ($status === 'completed') {
                    $appointment['paid_at'] = $appointmentAt->copy()->addHours(rand(0, 2));
                    
                    // 30% có lịch tái khám
                    if (rand(1, 100) <= 30) {
                        $appointment['follow_up_at'] = $appointmentAt->copy()->addDays(rand(7, 30));
                    }
                }

                $appointments[] = $appointment;
            }
        }

        // Insert tất cả appointments
        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }

        $this->command->info('✅ Đã tạo ' . count($appointments) . ' lịch hẹn mẫu!');
        $this->command->info('   - Scheduled: ' . collect($appointments)->where('status', 'scheduled')->count());
        $this->command->info('   - Confirmed: ' . collect($appointments)->where('status', 'confirmed')->count());
        $this->command->info('   - Completed: ' . collect($appointments)->where('status', 'completed')->count());
        $this->command->info('   - Cancelled: ' . collect($appointments)->where('status', 'cancelled')->count());
    }

    private function generateNotes($status)
    {
        $notes = [
            'scheduled' => [
                'Lần đầu khám',
                'Đau răng cần khám gấp',
                'Tái khám định kỳ',
                'Khám tư vấn',
                null,
            ],
            'confirmed' => [
                'Đã xác nhận qua điện thoại',
                'Bệnh nhân đã gọi xác nhận',
                'Đã nhắc lịch hẹn',
                null,
            ],
            'completed' => [
                'Điều trị tốt, hẹn tái khám sau 1 tuần',
                'Đã hoàn thành, bệnh nhân hài lòng',
                'Cần theo dõi thêm',
                'Điều trị xong, tái khám sau 2 tuần',
                null,
            ],
            'cancelled' => [
                'Bệnh nhân hủy do bận việc',
                'Đổi lịch sang ngày khác',
                'Không liên lạc được',
                null,
            ],
        ];

        $statusNotes = $notes[$status] ?? [null];
        return $statusNotes[array_rand($statusNotes)];
    }

    private function generateCancelReason()
    {
        $reasons = [
            'Bệnh nhân hủy lịch, đã đổi sang ngày khác',
            'Không liên lạc được với bệnh nhân',
            'Bệnh nhân báo bận đột xuất',
            'Bác sĩ có việc khẩn cấp',
            'Bệnh nhân yêu cầu đổi bác sĩ',
        ];

        return $reasons[array_rand($reasons)];
    }
}
