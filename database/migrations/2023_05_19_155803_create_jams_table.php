<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jams', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jamKerja', 4);
            $table->string('nama_jamKerja', 50);
            $table->time('awal_jamMasuk');
            $table->time('set_jamMasuk');
            $table->time('akhir_jamMasuk');
            $table->time('set_jamPulang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jams');
    }
};
