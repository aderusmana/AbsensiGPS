@extends('layouts.admin.master')


@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Monitoring
                    </div>
                    <h2 class="page-title">
                        Monitoring Absensi
                    </h2>
                </div>

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <form action="/admin/karyawan" method="GET">
                        <div style="display: flex; justify-content: space-between">
                            <input type="search" name="nama_lengkap" id="nama_lengkap"
                                class="form-control d-inline-block w-9 me-3" placeholder="Search karyawan…">
                            <button class="btn btn-dark" style="margin-right: 10px" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg> Search </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-calendar" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                                    </path>
                                                    <path d="M16 3v4"></path>
                                                    <path d="M8 3v4"></path>
                                                    <path d="M4 11h16"></path>
                                                    <path d="M11 15h1"></path>
                                                    <path d="M12 15v3"></path>
                                                </svg>
                                            </span>
                                            <input type="text" value="{{ date('Y-m-d') }}" name="tanggal" id="tanggal"
                                                class="form-control" placeholder="Tanggal Absensi" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-vcenter table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>NIK</th>
                                                        <th>NAMA KARYAWAN</th>
                                                        <th>DEPARTMENT</th>
                                                        <th>JADWAL</th>
                                                        <th>JAM MASUK</th>
                                                        <th>FOTO MASUK</th>
                                                        <th>JAM KELUAR</th>
                                                        <th>FOTO KELUAR</th>
                                                        <th>KETERANGAN</th>
                                                        <th></th>
                                                        <th class="w-1"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="loadAbsensi">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Modal Foto Masuk -->
<div class="modal modal-blur fade" id="modal-map" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Lokasi Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="loadMap">
            </div>
        </div>
    </div>
</div>
@push('myScript')
    <script>
        $(function() {
            $("#tanggal").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            })

            function loadAbsensi() {
                var tanggal = $("#tanggal").val();
                $.ajax({
                    type: 'POST',
                    url: '/admin/getAbsensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadAbsensi").html(respond);
                    }
                })
            }
            $("#tanggal").change(function(e) {
                loadAbsensi()
            })
        });
    </script>
@endpush
