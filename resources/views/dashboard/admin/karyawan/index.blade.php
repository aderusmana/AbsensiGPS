@extends('layouts.admin.master')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Karyawan
                    </div>
                    <h2 class="page-title">
                        Data Karyawan
                    </h2>
                </div>

                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <form action="/admin/karyawan" method="GET">
                        <div style="display: flex; justify-content: space-between">
                            <input type="search" name="nama_lengkap" id="nama_lengkap"
                                class="form-control d-inline-block w-9 me-3" placeholder="Search karyawan…"
                                value="{{ Request('nama_lengkap') }}">
                            <select class="form-select form-control d-inline-block w-9 me-3" name="department_id"
                                aria-label="Floating label select example">
                                <option value="">Pilih Department</option>
                                @foreach ($department as $dp)
                                    <option {{ Request('department_id' == $dp->id ? 'selected' : '') }}
                                        value="{{ $dp->id }}">
                                        {{ $dp->nama_department }}</option>
                                @endforeach
                            </select>
                            <select class="form-select form-control d-inline-block w-9 me-3" name="cabang_id"
                                aria-label="Floating label select example">
                                <option value="">Pilih Cabang</option>
                                @foreach ($cabang as $cb)
                                    <option {{ Request('cabang_id' == $cb->id ? 'selected' : '') }}
                                        value="{{ $cb->id }}">
                                        {{ $cb->kode_cabang }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-dark" style="margin-right: 10px" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg> Search </button>
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-tambah">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Tambah Karyawan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            @if ($karyawan->isEmpty())
                <div class="alert alert-warning">
                    <p>Data Tidak ditemukan</p>
                </div>
            @endif
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
            <div class="row row-cards">
                @foreach ($karyawan as $kr)
                    <div class="col-md-4 col-lg-3">
                        <div class="card">
                            <div class="card-body p-4 text-center">
                                @php
                                    $path = Storage::url('uploads/karyawan/' . $kr->avatar);
                                @endphp
                                @if (empty($kr->avatar))
                                    <img src="{{ asset('assetsAdmin/dist/img/no_user.png') }}" alt="avatar"
                                        class="avatar avatar-xl mb-3 rounded"></img>
                                @else
                                    <img src="{{ url($path) }}" alt="avatar"
                                        class="avatar avatar-xl mb-3 rounded"></img>
                                @endif
                                <div class="mt-3">
                                    <span class="badge bg-purple-lt">{{ $kr->nik }}</span>
                                </div>
                                <h3 class="m-0 mb-1"><a href="#">{{ $kr->nama_lengkap }}</a></h3>
                                <div class="text-muted">{{ $kr->jabatan }}</div>
                                <div class="text-muted">{{ $kr->department->nama_department }}</div>
                                <div class="text-muted">{{ $kr->cabang->kode_cabang }}</div>
                            </div>
                            <div class="d-flex">
                                <a href="#" class="card-btn bg-warning" data-bs-toggle="modal"
                                    data-bs-target="#modal-edit/{{ $kr->id }}">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                        </path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                    Edit
                                </a>


                                <a href="" class="card-btn bg-danger">
                                    <form action="/admin/karyawan/{{ $kr->id }}/delete" method="post"
                                        class="deleteConfirm">
                                        @csrf
                                        @method('delete')
                                        <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class=" icon icon-tabler icon-tabler-trash" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 7l16 0"></path>
                                            <path d="M10 11l0 6"></path>
                                            <path d="M14 11l0 6"></path>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                        </svg>
                                        Delete
                                    </form>
                                </a>

                                <a href="/admin/jamKerja/{{ $kr->id }}/set" class="card-btn bg-info">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-settings-check" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M11.445 20.913a1.665 1.665 0 0 1 -1.12 -1.23a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.31 .318 1.643 1.79 .997 2.694">
                                        </path>
                                        <path d="M15 19l2 2l4 -4"></path>
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                    </svg>
                                    Set
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
@endsection

{{-- modal tambah karyawan  --}}
<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Karyawan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="/admin/karyawan/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" name="nik" placeholder="Masukan NIK"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap"
                            placeholder="Masukan Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" placeholder="Masukan Jabatan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-select form-control d-inline-block w-9 me-3" name="department_id"
                            required>
                            <option value="">Pilih Department</option>
                            @foreach ($department as $dp)
                                <option value="{{ $dp->id }}">
                                    {{ $dp->nama_department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cabang</label>
                        <select class="form-select form-control d-inline-block w-9 me-3" name="cabang_id" required>
                            <option value="">Pilih Cabang</option>
                            @foreach ($cabang as $cb)
                                <option value="{{ $cb->id }}">
                                    {{ $cb->kode_cabang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="number" class="form-control" name="no_telp"
                            placeholder="Masukan No Telp"required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Avatar</label>
                        <img class="img-preview img-fluid" width="300px" alt="">
                        <input type="file" name="avatar" class="form-control" accept=".png, .jpg, .jpeg"
                            id="avatar" onchange="previewImage()">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="password"
                            placeholder="Masukan Password"required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-pill w-100">
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
@foreach ($karyawan as $kr)
    {{-- modal edit karyawan  --}}
    <div class="modal modal-blur fade" id="modal-edit/{{ $kr->id }}" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Karyawan </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="/admin/karyawan/{{ $kr->id }}/update" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="number" class="form-control" name="nik" placeholder="Masukan NIK"
                                value="{{ $kr->nik }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap"
                                placeholder="Masukan Nama Lengkap" value="{{ $kr->nama_lengkap }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" placeholder="Masukan Jabatan"
                                value="{{ $kr->jabatan }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select form-control d-inline-block w-9 me-3" name="department_id">
                                <option value="{{ $kr->department->id }}">
                                    {{ $kr->department->nama_department }}</option>
                                @foreach ($department as $dp)
                                    <option value="{{ $dp->id }}">
                                        {{ $dp->nama_department }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cabang</label>
                            <select class="form-select form-control d-inline-block w-9 me-3" name="cabang_id">
                                <option value="{{ $kr->cabang->id }}">
                                    {{ $kr->cabang->kode_cabang }}</option>
                                @foreach ($cabang as $cb)
                                    <option value="{{ $cb->id }}">
                                        {{ $cb->kode_cabang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No Telp</label>
                            <input type="number" class="form-control" name="no_telp" placeholder="Masukan No Telp"
                                value="{{ $kr->no_telp }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Avatar</label>
                            @if ($kr->avatar)
                                @php
                                    $path = Storage::url('uploads/karyawan/' . $kr->avatar);
                                @endphp
                                <img src="{{ url($path) }}" class="img-preview2 img-fluid" width="200px"
                                    alt="avatar">
                            @else
                                <img class="img-preview2 img-fluid" width="200px" alt="avatar">
                            @endif
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg"
                                class="avatar2 form-control " placeholder="Upload File" onchange="previewImage2()">
                            <input type="hidden" name="old_avatar" value="{{ $kr->avatar }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Masukan Password">
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

<script>
    function previewImage() {
        const image = document.querySelector('#avatar');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const blob = URL.createObjectURL(image.files[0]);
        imgPreview.src = blob;
    }

    function previewImage2() {
        const image = document.querySelector('.avatar2');
        const imgPreview = document.querySelector('.img-preview2');

        imgPreview.style.display = 'block';

        const blob = URL.createObjectURL(image.files[0]);
        imgPreview.src = blob;

    }
</script>

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
                    confirmButtonText: 'Ya, Hapus !',
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
