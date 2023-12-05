<?php

namespace App\Http\Controllers;

use App\Models\JamsById;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamsByIdController extends Controller
{
    public function setJamById(Request $request)
    {
        $id = $request->id;
        $hari = $request->hari;
        $jamId = $request->jam_id;

        for ($i = 0; $i < count($hari); $i++) {
            $data[] = [
                'karyawan_id' => $id,
                'jam_id' => $jamId[$i],
                'hari' => $hari[$i],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        $create = JamsById::insert($data);

        if ($create) {
            return redirect('/admin/karyawan')->with('success', 'Jam Kerja berhasil di Set');
        } else {
            return redirect('/admin/karyawan')->with('error', 'Jam Kerja gagal diset, cek kembali');
        }
    }

    public function updateJamById(Request $request)
    {
        $id = $request->id;
        $hari = $request->hari;
        $jamId = $request->jam_id;

        for ($i = 0; $i < count($hari); $i++) {
            $data[] = [
                'karyawan_id' => $id,
                'jam_id' => $jamId[$i],
                'hari' => $hari[$i],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::beginTransaction();
        try {
            JamsById::where('karyawan_id', $id)->delete();
            JamsById::insert($data);
            DB::commit();
            return redirect('/admin/karyawan')->with('success', 'Jam Kerja berhasil di Set');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect('/admin/karyawan')->with('error', 'Jam Kerja gagal diset, cek kembali');
        }
    }
}
