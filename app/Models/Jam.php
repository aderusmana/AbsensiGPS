<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    use HasFactory;
    protected $fillable = ['kode_jamKerja', 'nama_jamKerja', 'awal_jamMasuk', 'set_jamMasuk', 'akhir_jamMasuk', 'set_jamPulang'];
}
