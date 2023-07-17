<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $hariIni = date('Y-m-d');
        $rekapAbsensi = Absensi::selectRaw('COUNT(karyawan_id) as jmlHadir,
        SUM(IF(jam_masuk > "07:00",1,0)) as jmlTelat')
            ->where('tgl_absensi', $hariIni)
            ->first();
        $rekapIzin_Sakit = Izin::selectRaw("SUM(IF(status='i',1,0)) as jmlIzin,SUM(IF(status='s',1,0)) as jmlSakit")
            ->where('tgl_izin', $hariIni)
            ->where('status_approved', 1)
            ->first();
        return view('dashboard.admin.dashboard', compact('rekapAbsensi', 'rekapIzin_Sakit'));
    }


    public function login()
    {

        return view('auth.admin.login');
    }


    public function proses_login_admin(Request $request)
    {

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin/dashboard');
        } else {
            return redirect()->route('login.admin')->with('error', 'Email atau Password Salah');
        }
    }
    public function logout()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect()->route('login.admin');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
