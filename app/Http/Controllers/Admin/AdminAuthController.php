<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if(Auth::check()){
            return redirect()->route('admin.home');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user && $user->force_password_reset) {
                return redirect()->route('admin.password.edit')
                    ->with('warning', 'Đây là lần đăng nhập đầu tiên. Vui lòng đổi mật khẩu mặc định.');
            }

            return redirect()->intended(route('admin.home'));
        }
        return back()->withErrors(['email'=>'Thông tin đăng nhập không đúng'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}