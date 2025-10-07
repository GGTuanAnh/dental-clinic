<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Support\AuditLogger;

class PasswordController extends BaseAdminController
{
    public function edit()
    {
        return $this->renderView('admin.auth.password', [], 'Đổi mật khẩu');
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
        $user->save();
        AuditLogger::log('password.changed', $user, []);
        Auth::logoutOtherDevices($request->input('password'));

        return redirect()->route('admin.home')->with('status','Đổi mật khẩu thành công');
    }
}