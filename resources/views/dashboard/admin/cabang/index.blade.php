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
                        Data Lokasi Kantor
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class=" d-flex">

                        <button href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-tambah">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Tambah Cabang
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        @push('myScript')
            @if (session('success'))
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('success') }}'
                    })
                </script>
            @endif

            @if (session('error'))
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: '{{ session('error') }}'
                    })
                </script>
            @endif
        @endpush
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Kode Cabang</th>
                                        <th>Nama Cabang</th>
                                        <th>Lokasi Kantor</th>
                                        <th>Radius</th>
                                        <th class="w-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cabang as $cb)
                                        <tr>
                                            <td>{{ $cb->kode_cabang }}</td>
                                            <td>{{ $cb->nama_cabang }}</td>
                                            <td>{{ $cb->lokasi_kantor }}</td>
                                            <td>{{ $cb->radius }}</td>
                                            <td style="display: flex; justify-content: space-between">
                                                <a href="" class="badge bg-warning" style="margin-right: 5px"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit/{{ $cb->id }}">Edit</a>
                                                <a href="" class="badge bg-danger ">
                                                    <form action="/admin/cabang/{{ $cb->id }}" method="post"
                                                        class="deleteConfirm">
                                                        @csrf
                                                        @method('delete')
                                                        Hapus
                                                    </form>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- {{ $cabang->links('vendor.pagination.bootstrap-5') }} --}}
@endsection

{{-- Modal Tambah cabang  --}}

<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Cabang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="/admin/cabang" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Cabang</label>
                        <input type="text" class="form-control" name="kode_cabang" placeholder="Masukan Kode Cabang">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name Cabang</label>
                        <input type="text" class="form-control" name="nama_cabang" placeholder="Masukan Nama Cabang">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi Kantor</label>
                        <input type="text" class="form-control" name="lokasi_kantor"
                            placeholder="Masukan Lokasi Kantor">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Radius</label>
                        <input type="number" class="form-control" name="radius" placeholder="Masukan Radius">
                    </div>
                    <button type="submit" class="btn btn-primary btn-pill w-100" id="addData">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Cabang  --}}
@foreach ($cabang as $cb)
    <div class="modal modal-blur fade" id="modal-edit/{{ $cb->id }}" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Cabang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="/admin/cabang/{{ $cb->id }}/update" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode Cabang</label>
                            <input type="text" class="form-control" name="kode_cabang"
                                placeholder="Masukan Kode cabang" value={{ $cb->kode_cabang }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Cabang</label>
                            <input type="text" class="form-control" name="nama_cabang"
                                placeholder="Masukan Nama cabang" value={{ $cb->nama_cabang }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Kantor</label>
                            <input type="text" class="form-control" name="lokasi_kantor"
                                placeholder="Masukan Lokasi Kantor" value="{{ $cb->lokasi_kantor }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Radius</label>
                            <input type="number" class="form-control" name="radius" placeholder="Masukan Radius"
                                value="{{ $cb->radius }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-pill w-100">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
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

@push('myScript')
    <script>
        $(function() {
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
                    confirmButtonText: 'Ya, Hapus !  ',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        swalWithBootstrapButtons.fire(
                            'Terhapus!',
                            'Data Kamu berhasil dihapus.',
                            'Berhasil'
                        )
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Dibatalkan',
                            'Datamu aman :)',
                            'error'
                        )
                    }
                })
            })
        })
    </script>
@endpush
