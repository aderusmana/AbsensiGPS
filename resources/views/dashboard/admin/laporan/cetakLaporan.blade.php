<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        h3,
        h4 {
            font-family: Arial, Helvetica, sans-serif
        }

        .tableKaryawan {
            margin-top: 20px;
        }

        .tableKaryawan td {
            padding: 5px;
        }

        .tableAbsensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tableAbsensi tr th {
            border: 1px solid black;
            padding: 8px;
            background-color: rgb(85, 196, 252);

        }

        .tableAbsensi tr td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    @php
        function selisih($jam_masuk, $jam_keluar)
        {
            [$h, $m, $s] = explode(':', $jam_masuk);
            $dtAwal = mktime($h, $m, $s, '1', '1', '1');
            [$h, $m, $s] = explode(':', $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode('.', $totalmenit / 60);
            $sisamenit = $totalmenit / 60 - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ':' . round($sisamenit2);
        }
    @endphp

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <!-- Write HTML just like a web page -->
        <table style="width: 100%" border="1">
            <tr>
                <td style="text-align: center">
                    <img src="{{ asset('assetsAdmin') }}/dist/img/logoAdmin.png" width="200px" height="120px"
                        alt="">
                </td>
                <td style="text-align: center">
                    <h3>PT MOBILOGIX TEKNOLOGI INDONESIA</h3>
                    <h4>LAPORAN ABSENSI
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }}</h4>
                    <h5>Jl.H.Amsir, Sunter Jaya , Tanjung Priok, Jakarta Utara, DKI Jakarta 14350</h5>
                </td>
            </tr>
        </table>
        <table class="tableKaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->avatar);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" width="150px" height="200px">
                </td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departement</td>
                <td>:</td>
                <td>{{ $karyawan->department->nama_department }}</td>
            </tr>
            <tr>
                <td>No. Telp</td>
                <td>:</td>
                <td>{{ $karyawan->no_telp }}</td>
            </tr>
        </table>
        <table class="tableAbsensi">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Keluar</th>
                <th>Foto</th>
                <th>Keterangan</th>
                <th>Total Jam</th>
            </tr>

            @foreach ($absensi as $absen)
                @php
                    $pathMasuk = Storage::url('uploads/absensi/' . $absen->foto_masuk);
                    $pathKeluar = Storage::url('uploads/absensi/' . $absen->foto_keluar);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($absen->tgl_absensi)) }}</td>
                    <td>{{ $absen->jam_masuk }}</td>
                    <td><img src="{{ url($pathMasuk) }}" alt="" width="30px"></td>
                    <td>{{ $absen->jam_keluar != null ? $absen->jam_keluar : 'Belum Absen' }}</td>
                    <td>
                        @if ($absen->jam_keluar != null)
                            <img src="{{ url($pathKeluar) }}" alt="" width="30px">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-hourglass-high text-warning" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6.5 7h11"></path>
                                <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z"></path>
                                <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z"></path>
                            </svg>
                        @endif
                    </td>

                    <td>
                        @if ($absen->jam_masuk >= $absen->akhir_jamMasuk)
                            @php
                                $jam_terlambat = selisih($absen->akhir_jamMasuk, $absen->jam_masuk);
                            @endphp
                            <span>Terlambat - {{ $jam_terlambat }}</span>
                        @else
                            <span>Tepat Waktu</span>
                        @endif
                    </td>
                    <td>
                        @if ($absen->jam_keluar != null)
                            @php
                                $jam_kerja = selisih($absen->jam_masuk, $absen->jam_keluar);
                            @endphp
                            <span>{{ $jam_kerja }}</span>
                        @else
                            @php
                                $jam_kerja = 0;
                            @endphp
                            <span>{{ $jam_kerja }} </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 250px">
            <tr>
                <td colspan="2" style="text-align: right"> Jakarta, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center;vertical-align:bottom" height="100px">
                    <u>James Jefferies</u><br>
                    <i><b>Direktur Utama</b></i>
                </td>
                <td style="text-align: center;vertical-align:bottom">
                    <u>Mika Joan</u><br>
                    <i><b>HRD Manager</b></i>
                </td>
            </tr>

        </table>

    </section>

</body>

</html>
