<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        if (Auth::guard('karyawan')->attempt(['nik' => $request->nik, 'password' => $request->password])) {
            return redirect('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'NIK atau Password Salah');
        }
    }

    public function logout()
    {
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
            return redirect('/');
        }
    }
}
