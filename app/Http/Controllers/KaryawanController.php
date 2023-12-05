<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Department;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $data = Karyawan::with('department', 'cabang');

        if (!empty($request->nama_lengkap)) {
            $data->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if (!empty($request->department_id)) {
            $data->where('department_id',  $request->department_id);
        }
        if (!empty($request->cabang_id)) {
            $data->where('cabang_id',  $request->cabang_id);
        }

        $karyawan = $data->paginate(8);
        $department = Department::all();
        $cabang = Cabang::all();
        return view('dashboard.admin.karyawan.index', compact('karyawan', 'department', 'cabang'));
    }

    public function store(Request $request)
    {

        $nik = $request->nik;
        if ($request->hasFile('avatar')) {
            $avatar = $nik . "." . $request->file('avatar')->getClientOriginalExtension();
        } else {
            $avatar = "";
        }
        $createData = Karyawan::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'department_id' => $request->department_id,
            'cabang_id' => $request->cabang_id,
            'no_telp' => $request->no_telp,
            'avatar' => $avatar,
            'password' => Hash::make($request->password)

        ]);

        if ($createData) {
            if ($request->hasFile('avatar')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('avatar')->storeAs($folderPath, $avatar);
            }
            return redirect('/admin/karyawan')->with('success', 'Data Karyawan berhasil di tambah');
        } else {
            return redirect('/admin/karyawan')->with('error', "Data Karyawan gagal ditambah, cek kembali");
        }
    }

    public function update(Request $request, $id)
    {

        $karyawan = Karyawan::find($id);
        $nik = $request->nik;
        $oldAvatar = $request->old_avatar;
        if ($request->hasFile('avatar')) {
            $avatar = $nik . "." . $request->file('avatar')->getClientOriginalExtension();
        } else {
            $avatar = $oldAvatar;
        }
        $password = $request->password ? Hash::make($request->password) : $karyawan->password;
            $data = [
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'department_id' => $request->department_id,
                'cabang_id' => $request->cabang_id,
                'no_telp' => $request->no_telp,
                'password' => $password,
                'avatar' => $avatar,
            ];

        $updateData = Karyawan::findOrFail($id);
        $updateData->update($data);

        if ($updateData) {
            if ($request->hasFile('avatar')) {
                $folderPath = "public/uploads/karyawan/";
                $folderPathOld = "public/uploads/karyawan/" . $oldAvatar;
                Storage::delete($folderPathOld);
                $request->file('avatar')->storeAs($folderPath, $avatar);
            }
            return redirect('/admin/karyawan')->with('success', 'Data Karyawan berhasil di update');
        } else {
            return redirect('/admin/karyawan')->with('error', "Data Karyawan gagal diupdate, cek kembali");
        }
    }

    public function destroy($id)
    {
        $data = Karyawan::findOrFail($id);
        $folderPath = "public/uploads/karyawan/" . $data->avatar;
        if ($folderPath != null) {
            Storage::delete($folderPath);
        }
        $data->delete();
        if ($data) {
            return redirect('/admin/karyawan')->with('success', 'Data Karyawan berhasil di Hapus');
        } else {
            return redirect('/admin/karyawan')->with('error', "Data Karyawan gagal dihapus, cek kembali");
        }
    }
}
