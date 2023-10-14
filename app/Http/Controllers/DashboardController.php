<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {


        $hariIni = date('Y-m-d');
        $bulanIni = date('m') * 1;
        $tahunIni = date('Y');
        $karyawanId = Auth::guard('karyawan')->user()->id;
        $absensiHariIni = Absensi::where('karyawan_id', $karyawanId)->where('tgl_absensi', $hariIni)->first();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $absensiBulanIni = Absensi::whereRaw('MONTH(tgl_absensi)="' . $bulanIni . '"')
            ->where('karyawan_id', $karyawanId)
            ->join('jams', 'absensis.jam_id', '=', 'jams.id')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahunIni . '"')->orderBy('tgl_absensi')->get();

        $rekapAbsensi = Absensi::selectRaw('COUNT(karyawan_id) as jmlHadir,
        SUM(IF(absensis.jam_masuk > akhir_jamMasuk,1,0)) as jmlTerlambat')
            ->join('jams', 'absensis.jam_id', '=', 'jams.id')
            ->where('karyawan_id', $karyawanId)
            ->whereRaw('MONTH(tgl_absensi)="' . $bulanIni . '"')
            ->whereRaw('YEAR(tgl_absensi)="' . $tahunIni . '"')
            ->first();

        $leaderboard = Absensi::with('karyawan')
            ->where('tgl_absensi', $hariIni)
            ->orderBy('jam_masuk')->get();

        $rekapIzin_Sakit = Izin::selectRaw("SUM(IF(status='i',1,0)) as jmlIzin,SUM(IF(status='s',1,0)) as jmlSakit")
            ->where('karyawan_id', $karyawanId)
            ->whereRaw('MONTH(tgl_izin)="' . $bulanIni . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahunIni . '"')
            ->where('status_approved', 1)
            ->first();




        return view('dashboard.dashboard', compact(
            'absensiHariIni',
            'absensiBulanIni',
            "bulanIni",
            "namaBulan",
            "tahunIni",
            'rekapAbsensi',
            'leaderboard',
            'rekapIzin_Sakit'
        ));
    }
}
