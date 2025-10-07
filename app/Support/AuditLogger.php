<?php
namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function log(string $action, $model = null, array $meta = []): void
    {
        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => $model ? get_class($model) : null,
                'model_id' => $model?->id,
                'meta' => $meta ?: null,
                'ip_address' => request()?->ip(),
            ]);
        } catch(\Throwable $e) {
            // swallow to not break main flow
        }
    }
}