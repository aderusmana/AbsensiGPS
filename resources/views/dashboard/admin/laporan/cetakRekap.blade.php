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
            font-size: 7px
        }

        .tableAbsensi tr td {
            border: 1px solid black;
            padding: 5px;
            font-size: 8px
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">

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
                    <h4>REKAP ABSENSI
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }}</h4>
                    <h5>Jl.H.Amsir, Sunter Jaya , Tanjung Priok, Jakarta Utara, DKI Jakarta 14350</h5>
                </td>
            </tr>
        </table>


        <table class="tableAbsensi">
            <tr>
                <th rowspan="2">Nik</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">TANGGAL</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">TT</th>
            </tr>
            <tr>
                <?php
                    for ($i=1; $i <= 31; $i++) {
                ?>
                <th>{{ $i }}</th>
                <?php
                }
                ?>
            </tr>

            @foreach ($rekap as $rp)
                <tr>
                    <td>{{ $rp->nik }}</td>
                    <td>{{ $rp->nama_lengkap }}</td>
                    <?php
                    $totalhadir = 0;
                    $totalterlambat = 0;
                    for ($i=1; $i <= 31; $i++) {
                        $tgl = "tgl_".$i;


                        if (empty($rp->$tgl)) {
                            $hadir = ['',''];
                            $totalhadir += 0;
                        }else{
                            $hadir = explode("-",$rp->$tgl);
                            $totalhadir += 1;
                            if ($hadir[0] > $rp->akhir_jamMasuk) {
                                $totalterlambat += 1;
                            }
                        }
                     ?>
                    <td>
                        <span
                            style="color:
                            {{ $hadir[0] > $rp->akhir_jamMasuk ? 'red' : '' }}">{{ $hadir[0] }}
                        </span>
                        <span
                            style="color:
                            {{ $hadir[1] > $rp->set_jamPulang ? 'red' : '' }}">{{ $hadir[1] }}
                        </span>
                    </td>
                    <?php
                     }
                    ?>
                    <td>
                        {{ $totalhadir }}
                    </td>
                    <td>
                        {{ $totalterlambat }}
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
