@extends('layouts/masterlayout')

@section('content')
    <div class="section" id="user-section" style="display: flex; justify-content: space-between">
        <div id="user-detail">
            <div class="avatar" data-toggle="modal" data-target="#Profile">
                @if (!empty(Auth::guard('karyawan')->user()->avatar))
                    @php
                        $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->avatar);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="img-fluid" width="60px">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="img-fluid" width="60px">
                @endif
            </div>
            <div id="user-info">
                <h3 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h3>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }} - </span>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->cabang->kode_cabang }}</span>
            </div>
        </div>
        <div class="mt-3">
            <a href="/logout">
                <ion-icon name="log-out-outline" class="text-white" style="font-size: 2rem"></ion-icon>
            </a>
        </div>

    </div>

    <div class="section" id="menu-section">

        <div class="card mt-2">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editprofile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/absensi/izin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/absensi/history" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/absensi/lokasi" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absensiHariIni != null && $absensiHariIni->jam_masuk != null)
                                        <ion-icon name="camera" data-toggle="modal" data-target="#Masuk">
                                        </ion-icon>
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h5 class="presencetitle">Masuk</h5>
                                    <div style="font-size: 13px">
                                        <span>{{ $absensiHariIni != null ? $absensiHariIni->jam_masuk : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($absensiHariIni != null && $absensiHariIni->jam_keluar != null)
                                        <ion-icon name="camera" data-toggle="modal" data-target="#Keluar">
                                        </ion-icon>
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h5 class="presencetitle">Pulang</h5>
                                    <div style="font-size: 13px">
                                        <span>{{ $absensiHariIni != null && $absensiHariIni->jam_keluar != null ? $absensiHariIni->jam_keluar : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekapAbsensi">
            <h4>Rekap Absensi Bulan {{ $namaBulan[$bulanIni] }} pada tahun {{ $tahunIni }}</h4>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:16px 12px !important; line-height:0.9rem">
                            <span class="badge badge-danger"
                                style="position: absolute; top:1px;right:10px;font-size:0.7rem;z-index:999">{{ $rekapAbsensi->jmlHadir != null ? $rekapAbsensi->jmlHadir : 0 }}</span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.7rem;" class="text-primary">
                            </ion-icon>
                            <span style="font-size: 0.8rem; font-weight:900">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:16px 12px !important;line-height:0.9rem">
                            <span class="badge badge-danger"
                                style="position: absolute; top:1px;right:10px;font-size:0.7rem;z-index:999">{{ $rekapIzin_Sakit->jmlIzin != null ? $rekapIzin_Sakit->jmlIzin : 0 }}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.7rem;" class="text-success">
                            </ion-icon>
                            <span style="font-size: 0.8rem; font-weight:900">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:16px 12px !important;line-height:0.9rem">
                            <span class="badge badge-danger"
                                style="position: absolute; top:1px;right:10px;font-size:0.7rem;z-index:999">{{ $rekapIzin_Sakit->jmlSakit != null ? $rekapIzin_Sakit->jmlSakit : 0 }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.7rem;" class="text-danger">
                            </ion-icon>
                            <span style="font-size: 0.8rem; font-weight:900">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding:16px 12px !important;line-height:0.9rem">
                            <span class="badge badge-danger"
                                style="position: absolute; top:1px;right:10px;font-size:0.7rem;z-index:999">{{ $rekapAbsensi->jmlTerlambat != null ? $rekapAbsensi->jmlTerlambat : 0 }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.7rem;" class="text-warning">
                            </ion-icon>
                            <span style="font-size: 0.8rem; font-weight:900">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($absensiBulanIni as $bln)
                            <li>

                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date('d-m-Y', strtotime($bln->tgl_absensi)) }}</div>
                                        <span class="badge badge-warning">{{ $bln->jam_masuk }}</span>
                                        <span
                                            class="badge badge-danger">{{ $absensiHariIni != null && $bln->jam_keluar != null ? $bln->jam_keluar : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $lb)
                            <li>
                                <div class="item">
                                    @if (!empty($lb->karyawan->avatar))
                                        @php
                                            $path = Storage::url('uploads/karyawan/' . $lb->karyawan->avatar);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="avatar" class="imaged w48">
                                    @else
                                        <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    @endif
                                    <div class="in ml-2">
                                        <div>
                                            <b>{{ $lb->karyawan->nama_lengkap }}</b><br>
                                            <small class="text-muted">{{ $lb->karyawan->jabatan }}</small>
                                        </div>
                                        <span
                                            class="text-white badge {{ $lb->jam_masuk < '07:00' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $lb->jam_masuk }} </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>




    <!-- Modal Foto Masuk -->
    <div class="modal fade" id="Masuk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Foto Absen Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($absensiHariIni != null)
                        @php
                            $path = Storage::url('uploads/absensi/' . $absensiHariIni->foto_masuk);
                        @endphp
                        <img src="{{ url($path) }}" alt="" width="300px" height="300px">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Foto Keluar -->
    <div class="modal fade" id="Keluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Foto Absen Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if ($absensiHariIni != null && $absensiHariIni->foto_keluar != null)
                        @php
                            $path = Storage::url('uploads/absensi/' . $absensiHariIni->foto_keluar);
                        @endphp
                        <img src="{{ url($path) }}" alt="" width="300px" height="300px">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Foto Profile -->
    <div class="modal fade" id="Profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLongTitle">Foto Profile</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if (!empty(Auth::guard('karyawan')->user()->avatar))
                        @php
                            $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->avatar);
                        @endphp
                        <img src="{{ url($path) }}" alt="avatar" class="img-fluid">
                    @else
                        <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="img-fluid">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
