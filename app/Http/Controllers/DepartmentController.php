<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $department = Department::paginate(10);
        return view('dashboard.admin.department.index', compact('department'));
    }

    public function store(Request $request)
    {
        $create = Department::create($request->all());
        if ($create) {
            return redirect('/admin/department')->with('success', 'Department berhasil di Tambah');
        } else {
            return redirect('/admin/department')->with('error', 'Department gagal ditambah, cek kembali');
        }
    }
    public function update(Request $request, $id)
    {
        $update = Department::find($id);
        $update->update($request->all());
        if ($update) {
            return redirect('/admin/department')->with('success', 'Department berhasil di Update');
        } else {
            return redirect('/admin/department')->with('error', 'Department gagal diupdate, cek kembali');
        }
    }
    public function destroy($id)
    {
        $delete = Department::find($id);
        $delete->delete();
        if ($delete) {
            return redirect('/admin/department')->with('success', 'Department berhasil di Hapus');
        } else {
            return redirect('/admin/department')->with('error', 'Department gagal dihapus, cek kembali');
        }
    }
}
