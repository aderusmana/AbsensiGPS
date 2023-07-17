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
                    <form action="/admin/jamKerja/{{ $karyawan->id }}/setJamById" method="post">
                        @csrf
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
                                <tr>
                                    <td>Senin <input type="hidden" name="hari[]" value="Senin"></td>
                                    <td>
                                        <select name="jam_id[]" id="jam_id" class="form-control">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jam as $jm)
                                                <option value="{{ $jm->id }}">{{ $jm->nama_jamKerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Selasa <input type="hidden" name="hari[]" value="Selasa"></td>
                                    <td>
                                        <select name="jam_id[]" id="jam_id" class="form-control">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jam as $jm)
                                                <option value="{{ $jm->id }}">{{ $jm->nama_jamKerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rabu <input type="hidden" name="hari[]" value="Rabu"></td>
                                    <td>
                                        <select name="jam_id[]" id="jam_id" class="form-control">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jam as $jm)
                                                <option value="{{ $jm->id }}">{{ $jm->nama_jamKerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kamis <input type="hidden" name="hari[]" value="Kamis"></td>
                                    <td>
                                        <select name="jam_id[]" id="jam_id" class="form-control">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jam as $jm)
                                                <option value="{{ $jm->id }}">{{ $jm->nama_jamKerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jum'at <input type="hidden" name="hari[]" value="Jumat"></td>
                                    <td>
                                        <select name="jam_id[]" id="jam_id" class="form-control">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jam as $jm)
                                                <option value="{{ $jm->id }}">{{ $jm->nama_jamKerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sabtu <input type="hidden" name="hari[]" value="Sabtu"></td>
                                    <td>
                                        <select name="jam_id[]" id="jam_id" class="form-control">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jam as $jm)
                                                <option value="{{ $jm->id }}">{{ $jm->nama_jamKerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
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
