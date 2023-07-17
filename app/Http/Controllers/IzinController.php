<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IzinController extends Controller
{
    public function izin()
    {
        $karyawanId = Auth::guard('karyawan')->user()->id;
        $izin = Izin::with('karyawan')->where('karyawan_id', $karyawanId)->get();
        return view('absensi.izin', compact('izin'));
    }


    public function storeIzin(Request $request)
    {
        $karyawanId = Auth::guard('karyawan')->user()->id;
        $nik = Auth::guard('karyawan')->user()->nik;
        $tglIzin = $request->tgl_izin;
        $status  = $request->status;
        $keterangan = $request->keterangan;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }


        $data = [
            'karyawan_id' => $karyawanId,
            'tgl_izin' => $tglIzin,
            'status' => $status,
            'keterangan' => $keterangan,
            'foto' => $foto,
        ];
        $simpan = Izin::create($data);
        if ($simpan) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/bukti/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect('absensi/izin')->with('success', 'Berhasil Mengajukan Izin/ Sakit');
        } else {
            return redirect('absensi/izin')->with('error', "Gagal Mengajukan Izin/ Sakit, cek kembali");
        }
    }

    public function dataIzinSakit(Request $request)

    {
        $is = Izin::query();
        $is->select('izins.id', 'tgl_izin', 'izins.karyawan_id', 'nama_lengkap', 'jabatan', 'status', 'keterangan', 'status_approved', 'foto');
        $is->join('karyawans', 'izins.karyawan_id', '=', 'karyawans.id');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $is->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }
        if (!empty($request->nama_lengkap)) {
            $is->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if ($request->status_approved == "0" || $request->status_approved == "1" || $request->status_approved == "2") {
            $is->where('status_approved', $request->status_approved);
        }
        $izinsakit = $is->orderBy('tgl_izin', 'desc')->paginate(1);
        $izinsakit->appends($request->all());


        return view('dashboard.admin.izin.dataIzinSakit', compact('izinsakit'));
    }

    public function updateIzinSakit(Request $request, $id)
    {
        $statusApproved = $request->status_approved;
        $update = Izin::findOrFail($id);
        $update->update([
            'status_approved' => $statusApproved
        ]);

        if ($update) {
            return Redirect::back()->with('success', 'Data Izin / Sakit berhasil di update');
        } else {
            return Redirect::back()->with('error', "Data Izin / Sakit gagal diupdate, cek kembali");
        }
    }
    public function batalkanIzinSakit($id)
    {
        $update = Izin::findOrFail($id);
        $update->update([
            'status_approved' => 0
        ]);

        if ($update) {
            return Redirect::back()->with('success', 'Persetujuan Izin / Sakit berhasil di batalkan');
        } else {
            return Redirect::back()->with('error', "Persetujuan Izin / Sakit gagal dibatalkan, cek kembali");
        }
    }

    public function cekizin(Request $request)
    {
        $tglIzin = $request->tgl_izin;
        $karyawanId = Auth::guard('karyawan')->user()->id;

        $cek = Izin::where('karyawan_id', $karyawanId)->where('tgl_izin', $tglIzin)->count();
        return $cek;
    }
}
