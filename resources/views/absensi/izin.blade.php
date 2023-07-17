@extends('layouts.masterlayout')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>

@section('content')
    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="absensi/formIzin" class="fab" data-toggle="modal" data-target="#formIzin">
            <ion-icon name="add-circle-outline"></ion-icon>
        </a>
    </div>

    <div class="row">
        <div class="col" style="margin-top: 70px">
            @if (session('error'))
                <div class="alert alert-outline alert-danger">
                    <h3>{{ session('error') }}</h3>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-outline alert-success">
                    <h3>{{ session('success') }}</h3>
                </div>
            @endif
        </div>
    </div>

    @if ($izin->isEmpty())
        <div class="alert alert-warning">
            <p>Data Belum Ada</p>
        </div>
    @endif

    <div class="row">
        <div class="col">
            @foreach ($izin as $i)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            @if (!empty($i->foto))
                                @php
                                    $path = Storage::url('uploads/bukti/' . $i->foto);
                                @endphp
                                <img src="{{ url($path) }}" alt="" width="50px" height="50px">
                            @else
                                <img src="{{ asset('assets/img/nofoto.png') }}" alt="" width="50px"
                                    height="50px">
                            @endif
                            <div class="in ml-2">
                                <div>
                                    <small><b>{{ $i->karyawan->nama_lengkap }}</b></small><br>
                                    <small>{{ date('d-m-Y', strtotime($i->tgl_izin)) }} -
                                        ({{ $i->status == 's' ? 'Sakit' : 'Izin' }})
                                    </small>
                                </div>

                                @if ($i->status_approved == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($i->status_approved == 1)
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($i->status_approved == 2)
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>

@endsection

<!-- Modal form  -->
<div class="modal fade" id="formIzin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle"> Form Izin/ Sakit</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="storeIzin" method="POST" enctype="multipart/form-data" id="frmIzin">
                    @csrf
                    <div class="col">
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <input class="form-control datepicker" name="tgl_izin" placeholder="Tanggal"
                                    id="tgl_izin">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Izin/Sakit</option>
                                    <option value="i">Izin</option>
                                    <option value="s">Sakit</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                            </div>
                        </div>
                        <div class="custom-file-upload" id="fileUpload1">
                            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                            <label for="fileuploadInput">
                                <span>
                                    <strong>
                                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                            aria-label="cloud upload outline"></ion-icon>
                                        <i>Tap to Upload</i>
                                    </strong>
                                </span>
                            </label>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <ion-icon name="refresh-outline"></ion-icon>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('myScript')
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: "bootstrap4",

        });
        $("#tgl_izin").change(function(e) {
            var tgl_izin = $(this).val();
            $.ajax({
                type: 'POST',
                url: "/admin/cekIzin",
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl_izin: tgl_izin
                },
                cache: false,
                success: function(respond) {
                    if (respond == 1) {
                        Swal.fire({
                            title: 'Oops!',
                            text: "Maaf Anda Sudah Melakukan Pengajuan Pada Tanggal Tersebut !, SIlahkan Pilih Tanggal Lain",
                            icon: 'warning',
                        }).then((result) => {
                            $("#tgl_izin").val("")
                        })
                    }
                }
            })
        })

        $('#frmIzin').submit(function() {
            var tgl_izin = $('#tgl_izin').val();
            var status = $('#status').val();
            var keterangan = $('#keterangan').val();

            if (tgl_izin == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: "Tanggal Harus Diisi",
                    icon: 'warning',
                })
                return false;
            } else if (status == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: "Status Harus Diisi",
                    icon: 'warning',
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    title: 'Oops!',
                    text: "Keterangan Harus Diisi",
                    icon: 'warning',
                });
                return false;
            }
        });
    </script>
@endpush
