<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function userLoginView()
    {
        return view('admin.auth.login');
    }

    public function userLoginProccess(Request $request)
    {
        $credentials = $request->validate([
            'email'          => 'required|email',
            'password'       => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if ((int) auth()->user()->account_status === (int) 1) {
                $request->session()->regenerate();
                return redirect()->route('user.dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->withErrors(['You account is not activated!']);
            }
        }
        return redirect()->back()->withErrors(['The provided credentials do not match our records.']);
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
}
