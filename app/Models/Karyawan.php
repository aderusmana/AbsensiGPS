<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jabatan',
        'department_id',
        'cabang_id',
        'no_telp',
        'avatar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    public function izin()
    {
        return $this->hasMany(Izin::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
