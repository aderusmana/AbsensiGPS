<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    public function create(Request $request)
    {

        $users = User::paginate(4);
        if (!empty($request->name)) {
            $users->where('name', 'like', '%' . $request->name . '%');
        }

        return view('dashboard.admin.user.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|unique:users,password',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $name = $request->name;
        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $name . "." . $request->file('photo')->getClientOriginalExtension();
        } else {
            $photo = "";
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $photo
        ]);

        if ($user) {
            if ($request->hasFile('photo')) {
                $folderPath = "public/uploads/users/";
                $request->file('photo')->storeAs($folderPath, $photo);
            }
            return redirect('/admin/users')->with('success', 'Data User berhasil di tambah');
        } else {
            return redirect('/admin/users')->with('error', "Data User gagal ditambah, cek kembali");
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $users = User::find($id);

        if (!$users) {
            return redirect('/admin/users')->with('error', 'User not found');
        }

        // Get the user's name and old photo
        $name = $request->name;
        $oldPhoto = $request->old_photo;

        // Check if a new photo is being uploaded
        if ($request->hasFile('photo')) {
            $photo = $name . "." . $request->file('photo')->getClientOriginalExtension();

            // Store the new photo
            $request->file('photo')->storeAs('public/uploads/users', $photo);

            // Delete the old photo if it exists
            if ($oldPhoto) {
                $folderPathOld = "public/uploads/users/" . $oldPhoto;
                Storage::delete($folderPathOld);
            }
        } else {
            // No new photo is being uploaded, use the existing photo if it exists
            $photo = $oldPhoto;
        }

        // Update the user's data
        $password = $request->password ? Hash::make($request->password) : $users->password;
        $email = $request->email ? $request->email : $users->email;
        $data = [
            'name' => $request->name,
            'email' => $email,
            'password' => $password,
            'photo' => $photo,
        ];
        $users->update($data);

        return redirect('/admin/users')->with('success', 'User data updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userToDelete = User::findOrFail($id);
        $loggedInUser = Auth::user();

        if ($userToDelete->id === $loggedInUser->id) {
            return redirect('/admin/users')->with('error', 'Data User yang sedang Login tidak dapat dihapus.');
        }

        $folderPath = "public/uploads/users/" . $userToDelete->photo;

        if ($folderPath != null) {
            Storage::delete($folderPath);
        }

        $userToDelete->delete();

        if ($userToDelete->wasDeleted()) {
            return redirect('/admin/users')->with('success', 'Data User berhasil dihapus.');
        } else {
            return redirect('/admin/users')->with('error', 'Data User gagal dihapus, cek kembali.');
        }
    }
}
