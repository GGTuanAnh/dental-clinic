<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Support\AuditLogger;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('admin.auth.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $user = $request->user();
        if(! Hash::check($request->input('current_password'), $user->password)){
            return back()->withErrors(['current_password'=>'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->force_password_reset = false;
        $user->password_changed_at = now();
        $user->save();
        AuditLogger::log('password.changed', $user, []);
        Auth::logoutOtherDevices($request->input('password'));

        return redirect()->route('admin.home')->with('status','Đổi mật khẩu thành công');
    }
}