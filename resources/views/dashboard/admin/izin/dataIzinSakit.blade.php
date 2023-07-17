@extends('layouts.admin.master')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Data Izin / Sakit
                    </div>
                    <h2 class="page-title">
                        Persetujuan Izin / Sakit
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <form action="/admin/karyawan" method="GET">
                        <div style="display: flex; justify-content: space-between">
                            <input type="search" name="nama_lengkap" id="nama_lengkap"
                                class="form-control d-inline-block w-9 me-3" placeholder="Search karyawan…"
                                value="{{ Request('nama_lengkap') }}">


                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @if (session('error'))
                <div class="alert alert-outline alert-danger">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-outline alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <form action="/admin/dataIzinSakit" method="get" autocomplete="off">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-calendar-search" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4.5">
                                            </path>
                                            <path d="M16 3v4"></path>
                                            <path d="M8 3v4"></path>
                                            <path d="M4 11h16"></path>
                                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                            <path d="M20.2 20.2l1.8 1.8"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="dari" name="dari" placeholder="Dari"
                                        value="{{ Request('dari') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-calendar-search" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4.5">
                                            </path>
                                            <path d="M16 3v4"></path>
                                            <path d="M8 3v4"></path>
                                            <path d="M4 11h16"></path>
                                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                            <path d="M20.2 20.2l1.8 1.8"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="sampai" name="sampai" placeholder="Sampai"
                                        value="{{ Request('sampai') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap"
                                        value="{{ Request('nama_lengkap') }}" placeholder="Search Karyawan"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-status-change" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M6 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M18 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M6 12v-2a6 6 0 1 1 12 0v2"></path>
                                            <path d="M15 9l3 3l3 -3"></path>
                                        </svg>
                                    </span>
                                    <select class="form-select form-control d-inline-block w-9 me-3"
                                        name="status_approved" id="status_approved"
                                        aria-label="Floating label select example">
                                        <option>Pilih Status</option>
                                        <option value="0" {{ Request('status_approved') === '0' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="1"{{ Request('status_approved') == 1 ? 'selected' : '' }}>
                                            Disetujui
                                        </option>
                                        <option value="2"{{ Request('status_approved') == 2 ? 'selected' : '' }}>
                                            Ditolak
                                        </option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary w-100"type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg> Search </button>
                            </div>
                        </div>

                    </form>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NIK</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Status Approved</th>
                                        <th class="w-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($izinsakit as $is)
                                        @php
                                            $pathBukti = Storage::url('uploads/bukti/' . $is->foto);
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-M-Y', strtotime($is->tgl_izin)) }}</td>
                                            <td>{{ $is->karyawan->nik }}</td>
                                            <td>{{ $is->karyawan->nama_lengkap }}</td>
                                            <td>{{ $is->karyawan->jabatan }}</td>
                                            <td>{{ $is->karyawan->department->nama_department }}</td>
                                            <td>{{ $is->status = 'i' ? 'Izin' : 'Sakit' }}</td>
                                            <td>{{ $is->keterangan }}</td>
                                            <td>
                                                @if ($is->status_approved == 0)
                                                    <span class="badge bg-orange">Pending</span>
                                                @elseif ($is->status_approved == 1)
                                                    <span class="badge bg-green">Disetujui</span>
                                                @else
                                                    <span class="badge bg-red">Ditolak</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($is->status_approved == 0)
                                                    <a href="#" class="badge bg-blue" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit/{{ $is->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-eye-check" width="30"
                                                            height="30" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                            <path
                                                                d="M11.143 17.961c-3.221 -.295 -5.936 -2.281 -8.143 -5.961c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6c-.222 .37 -.449 .722 -.68 1.057">
                                                            </path>
                                                            <path d="M15 19l2 2l4 -4"></path>
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="#"class="badge bg-red">
                                                        <form action="/admin/izinSakit/{{ $is->id }}/batalkan"
                                                            method="post" class="deleteConfirm">
                                                            @csrf
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-circle-x text-white"
                                                                width="30" height="30" viewBox="0 0 21 21"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0">
                                                                </path>
                                                                <path d="M10 10l4 4m0 -4l-4 4"></path>
                                                            </svg>
                                                        </form>
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>

                                        <div class="modal modal-blur fade" id="modal-edit/{{ $is->id }}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Persetujuan Izin</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <form action="/admin/izinSakit/{{ $is->id }}/update"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-body p-0 text-center">
                                                                    @if ($is->foto != null)
                                                                        <img src="{{ url($pathBukti) }}" alt=""
                                                                            width="200px" height="200px">
                                                                    @else
                                                                        <img src="{{ asset('assetsAdmin') }}/dist/img/nopict.png""
                                                                            alt="" width="100px" height="200px">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-floating">
                                                                <select class="form-select" id="floatingSelect"
                                                                    name="status_approved"
                                                                    aria-label="Floating label select example">
                                                                    <option selected="">Pilih Persetujuan</option>
                                                                    <option value="1">Disetujui</option>
                                                                    <option value="2">Ditolak</option>
                                                                </select>
                                                                <label for="floatingSelect">Select Persetujuan</label>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary btn-pill w-100 mt-5">
                                                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-edit"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none">
                                                                    </path>
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                    </path>
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                    </path>
                                                                    <path d="M16 5l3 3"></path>
                                                                </svg>
                                                                Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>
                    @if ($izinsakit->isEmpty())
                        <div class="alert alert-warning">
                            <p>Data Tidak ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{ $izinsakit->links('vendor.pagination.bootstrap-5') }}
@endsection
@push('myScript')
    <script>
        $(function() {
            $("#dari").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            $("#sampai").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            $(".deleteConfirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Apa Kamu Yakin ?',
                    text: "Kamu tidak bisa membatalkan nya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan !',
                    cancelButtonText: 'Tidak!  ',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        swalWithBootstrapButtons.fire(
                            'Terbatalkan!',
                            'Persetujuan berhasil dibatalkan.',
                            'Berhasil'
                        )
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Dicancel',
                            'Persetujuan tidak berubah :)',
                            'error'
                        )
                    }
                })
            })

        });
    </script>
@endpush
