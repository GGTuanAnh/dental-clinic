<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePasswordReset
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->force_password_reset) {
            if (! $request->routeIs('admin.password.*') && ! $request->routeIs('admin.logout')) {
                return redirect()->route('admin.password.edit')
                    ->with('warning', 'Vui lòng đổi mật khẩu mặc định trước khi tiếp tục sử dụng hệ thống.');
            }
        }

        return $next($request);
    }
}
