@extends('layouts.admin.master')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Konfigurasi
                    </div>
                    <h2 class="page-title">
                        Set Jam Kerja per Karyawan
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <tr>
                            <th>NIK</th>
                            <td>{{ $karyawan->nik }}</td>
                        </tr>
                        <tr>
                            <th>Nama Karyawan</th>
                            <td>{{ $karyawan->nama_lengkap }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class='row'>
                <div class='col-6'>
                    <form action="/admin/jamKerja/{{ $karyawan->id }}/updateJamById" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $karyawan->id }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari>
                                    </th>
                                    <th>Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($updateJamKerja as $upjam)
                                    <tr>
                                        <td>{{ $upjam->hari }} <input type="hidden" name="hari[]"
                                                value="{{ $upjam->hari }}"></td>
                                        <td>
                                            <select name="kode_jamKerja[]" id="kode_jamKerja" class="form-select">
                                                <option value="">Pilih Jam Kerja</option>
                                                @foreach ($jam as $jm)
                                                    <option
                                                        {{ $jm->kode_jamKerja == $upjam->kode_jamKerja ? 'selected' : '' }}
                                                        value="{{ $jm->kode_jamKerja }}">
                                                        {{ $jm->nama_jamKerja }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
                <div class="col-6">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Kode Jam Kerja</th>
                                <th>Nama Jam Kerja</th>
                                <th>Awal Jam Masuk</th>
                                <th>Jam Masuk</th>
                                <th>Akhir Jam Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        @foreach ($jam as $jam)
                            <tbody>
                                <tr>
                                    <td>{{ $jam->kode_jamKerja }}</td>
                                    <td>{{ $jam->nama_jamKerja }}</td>
                                    <td>{{ $jam->awal_jamMasuk }}</td>
                                    <td>{{ $jam->set_jamMasuk }}</td>
                                    <td>{{ $jam->akhir_jamMasuk }}</td>
                                    <td>{{ $jam->set_jamPulang }}</td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
