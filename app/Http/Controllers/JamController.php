<?php

namespace App\Http\Controllers;

use App\Models\Jam;
use App\Models\JamsById;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class JamController extends Controller
{
    public function index()
    {
        $jam = Jam::all();
        return view('dashboard.admin.konfigurasi.setJamKerja', compact('jam'));
    }

    public function store(Request $request)
    {
        $create = Jam::create($request->all());
        if ($create) {
            return redirect('/admin/jamKerja')->with('success', 'Jam Kerja berhasil di Tambah');
        } else {
            return redirect('/admin/jamKerja')->with('error', 'Jam Kerja gagal ditambah, cek kembali');
        }
    }

    public function update(Request $request, $id)
    {
        $update = Jam::find($id);
        $update->update($request->all());
        if ($update) {
            return redirect('/admin/jamKerja')->with('success', 'Jam Kerja berhasil di Update');
        } else {
            return redirect('/admin/jamKerja')->with('error', 'Jam Kerja gagal diupdate, cek kembali');
        }
    }

    public function destroy($id)
    {
        $delete = Jam::find($id);
        $delete->delete();
        if ($delete) {
            return redirect('/admin/jamKerja')->with('success', 'Jam Kerja berhasil di Hapus');
        } else {
            return redirect('/admin/jamKerja')->with('error', 'Jam Kerja gagal dihapus cek kembali');
        }
    }

    public function set($id)
    {
        $karyawan = Karyawan::find($id);
        $jam = Jam::all();
        $cekJamKerja = JamsById::where('karyawan_id', $id)->count();
        if ($cekJamKerja > 0) {
            $updateJamKerja = JamsById::where('karyawan_id', $id)->get();
            return view('dashboard.admin.konfigurasi.editJamKerjaById', compact('karyawan', 'jam', 'updateJamKerja'));
        } else {
            return view('dashboard.admin.konfigurasi.setJamKerjaById', compact('karyawan', 'jam'));
        }
    }
}
