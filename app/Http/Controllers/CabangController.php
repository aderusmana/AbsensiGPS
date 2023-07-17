<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $cabang = Cabang::all();
        return view('dashboard.admin.cabang.index', compact('cabang'));
    }

    public function store(Request $request)
    {
        $create = Cabang::create($request->all());
        if ($create) {
            if ($create) {
                return redirect('/admin/cabang')->with('success', 'Cabang berhasil di Tambah');
            } else {
                return redirect('/admin/cabang')->with('error', 'Cabang gagal ditambah, cek kembali');
            }
        }
    }
    public function update(Request $request, $id)
    {
        $update = Cabang::find($id);
        $update->update($request->all());
        if ($update) {
            return redirect('/admin/cabang')->with('success', 'Cabang berhasil di Update');
        } else {
            return redirect('/admin/cabang')->with('error', 'Cabang gagal diupdate, cek kembali');
        }
    }
    public function destroy($id)
    {
        $delete = Cabang::find($id);
        $delete->delete();
        if ($delete) {
            return redirect('/admin/cabang')->with('success', 'Cabang berhasil di Hapus');
        } else {
            return redirect('/admin/cabang')->with('error', 'Cabang gagal dihapus, cek kembali');
        }
    }
}
