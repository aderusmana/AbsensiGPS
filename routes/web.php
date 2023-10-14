<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JamsByIdController;
use App\Http\Controllers\JamController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware('guest:karyawan')->group(function () {
    Route::post('/proseslogin', [AuthController::class, 'proses_login']);
    Route::get('/', [AuthController::class, 'login'])->name('login');
});
Route::middleware('auth:karyawan')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
    // absensi
    Route::get('/absensi/create', [AbsensiController::class, 'create']);
    Route::post('/absensi/store', [AbsensiController::class, 'store']);
    // edit profile
    Route::get('/editprofile', [AbsensiController::class, 'edit']);
    Route::post('/absensi/{id}/updateprofile', [AbsensiController::class, 'update']);
    // history
    Route::get('/absensi/history', [AbsensiController::class, 'history']);
    Route::post('/absensi/getHistory', [AbsensiController::class, 'getHistory']);

    // lokasi
    Route::get('/absensi/lokasi', [AbsensiController::class, 'lokasi']);
    // izin
    Route::get('/absensi/izin', [IzinController::class, 'izin']);
    Route::post('/absensi/storeIzin', [IzinController::class, 'storeIzin']);
    Route::post('/admin/cekIzin', [IzinController::class, 'cekizin']);
});



Route::middleware('guest:user')->group(function () {
    Route::post('/admin/proseslogin', [UserController::class, 'proses_login_admin']);
    Route::get('/admin/login', [UserController::class, 'login'])->name('login.admin');
});

Route::middleware('auth:user')->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'index']);
    Route::get('/admin/logout', [UserController::class, 'logout']);
    Route::get('/admin/karyawan', [KaryawanController::class, 'index']);
    Route::post('/admin/karyawan/store', [KaryawanController::class, 'store']);
    Route::put('/admin/karyawan/{id}/update', [KaryawanController::class, 'update']);
    Route::delete('/admin/karyawan/{id}/delete', [KaryawanController::class, 'destroy']);

    Route::get('/admin/department', [DepartmentController::class, 'index']);
    Route::post('/admin/department', [DepartmentController::class, 'store']);
    Route::put('/admin/department/{id}/update', [DepartmentController::class, 'update']);
    Route::delete('/admin/department/{id}', [DepartmentController::class, 'destroy']);

    Route::get('/admin/monitoring', [AbsensiController::class, 'monitoring']);
    Route::post('/admin/getAbsensi', [AbsensiController::class, 'getAbsensi']);
    Route::post('/admin/getMap', [AbsensiController::class, 'getMap']);

    Route::get('/admin/laporanAbsensi', [AbsensiController::class, 'laporanAbsensi']);
    Route::get('/admin/rekapAbsensi', [AbsensiController::class, 'rekapAbsensi']);
    Route::post('/admin/cetakLaporan', [AbsensiController::class, 'cetakLaporan']);
    Route::post('/admin/cetakRekap', [AbsensiController::class, 'cetakRekap']);

    Route::get('/admin/lokasi', [LokasiController::class, 'setLokasi']);
    Route::post('/admin/updateLokasiKantor', [LokasiController::class, 'updateLokasiKantor']);

    Route::get('/admin/dataIzinSakit', [IzinController::class, 'dataIzinSakit']);
    Route::put('/admin/izinSakit/{id}/update', [IzinController::class, 'updateIzinSakit']);
    Route::post('/admin/izinSakit/{id}/batalkan', [IzinController::class, 'batalkanIzinSakit']);

    Route::get('/admin/cabang', [CabangController::class, 'index']);
    Route::post('/admin/cabang', [CabangController::class, 'store']);
    Route::put('/admin/cabang/{id}/update', [CabangController::class, 'update']);
    Route::delete('/admin/cabang/{id}', [CabangController::class, 'destroy']);

    Route::get('/admin/jamKerja', [JamController::class, 'index']);
    Route::post('/admin/jamKerja', [JamController::class, 'store']);
    Route::put('/admin/jamKerja/{id}/update', [JamController::class, 'update']);
    Route::delete('/admin/jamKerja/{id}', [JamController::class, 'destroy']);
    Route::get('/admin/jamKerja/{id}/set', [JamController::class, 'set']);


    Route::post('/admin/jamKerja/{id}/setJamById', [JamsByIdController::class, 'setJamById']);
    Route::put('/admin/jamKerja/{id}/updateJamById', [JamsByIdController::class, 'updateJamById']);

    Route::get('/admin/users' ,[UserController::class, 'create'])->name('admin.users');
    Route::post('/admin/users/',[UserController::class, 'store'])->name('admin.store');
    Route::put('/admin/users/update/{id}',[UserController::class, 'update'])->name('admin.update');
    Route::delete('/admin/users/{id}',[UserController::class, 'destroy'])->name('admin.delete');
});
